<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potential;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PotentialController extends Controller
{
    public function index(Request $request)
    {
        $query = Potential::with('village')->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('verification_status', $request->input('status'));
        }

        if ($request->filled('district')) {
            $query->whereHas('village', function ($q) use ($request) {
                $q->where('district_name', $request->input('district'));
            });
        }

        if ($request->filled('category')) {
            $query->where('attributes->product_category', $request->input('category'));
        }

        if ($request->filled('village')) {
            $query->whereHas('village', function ($q) use ($request) {
                $q->where('village_name', $request->input('village'));
            });
        }

        $potentials = $query->paginate(10)->withQueryString();

        // Get unique districts for filter dropdown
        $districts = Village::distinct('district_name')
            ->orderBy('district_name')
            ->pluck('district_name');

        // Kategori potensi (kode tetap)
        $categories = [
            'UM' => 'UM - Produk UMKM',
            'WS' => 'WS - Wisata & Rekreasi',
            'PT' => 'PT - Pertanian & Perkebunan',
            'SB' => 'SB - Seni, Budaya, & Jasa',
        ];

        // Get villages list for desa filter
        $villages = Village::orderBy('village_name')
            ->pluck('village_name');

        return view('admin.potentials.index', [
            'potentials' => $potentials,
            'districts' => $districts,
            'categories' => $categories,
            'villages' => $villages,
        ]);
    }

    public function create()
    {
        $villages = Village::orderBy('village_name')->get();

        return view('admin.potentials.create', [
            'potential' => new Potential(),
            'villages' => $villages,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['slug'] = Str::slug($data['title']);
        $data['source'] = 'manual';

        $data['images'] = $this->handleImages($request);

        Potential::create($data);

        return redirect()
            ->route('admin.potentials.index')
            ->with('status', 'Potensi desa berhasil dibuat.');
    }

    public function edit(Potential $potential)
    {
        $villages = Village::orderBy('village_name')->get();

        return view('admin.potentials.edit', [
            'potential' => $potential,
            'villages' => $villages,
        ]);
    }

    public function update(Request $request, Potential $potential)
    {
        $data = $this->validateData($request, $potential->id);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $images = $this->handleImages($request, $potential);
        $data['images'] = $images;

        $potential->update($data);

        return redirect()
            ->route('admin.potentials.index')
            ->with('status', 'Potensi desa berhasil diperbarui.');
    }

    public function destroy(Potential $potential)
    {
        $potential->delete();

        return redirect()
            ->route('admin.potentials.index')
            ->with('status', 'Potensi desa berhasil dihapus.');
    }

    public function deleteImage(Potential $potential, $imageIndex)
    {
        $images = $potential->images ?: [];
        
        // Validasi index
        if (!isset($images[$imageIndex])) {
            return redirect()
                ->route('admin.potentials.edit', $potential)
                ->with('error', 'Foto tidak ditemukan.');
        }
        
        // Hapus file dari storage jika bukan external URL
        $imageToDelete = $images[$imageIndex];
        if (!filter_var($imageToDelete, FILTER_VALIDATE_URL)) {
            $filePath = storage_path('app/public/' . $imageToDelete);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Hapus dari array images
        array_splice($images, $imageIndex, 1);
        
        // Update database
        $potential->update(['images' => $images]);

        return redirect()
            ->route('admin.potentials.edit', $potential)
            ->with('status', 'Foto berhasil dihapus.');
    }

    protected function validateData(Request $request, $ignoreId = null)
    {
        $rules = [
            'village_id' => 'required|exists:villages,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:potentials,slug',
            'description' => 'nullable|string',
            'price_range' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:50',
            'location_address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'verification_status' => 'required|in:pending,verified,rejected',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            'reset_images' => 'nullable|boolean',
        ];

        if ($ignoreId) {
            $rules['slug'] = 'nullable|string|max:255|unique:potentials,slug,' . $ignoreId;
        }

        return $request->validate($rules);
    }

    protected function handleImages(Request $request, ?Potential $potential = null)
    {
        $images = [];

        if ($potential && !$request->boolean('reset_images')) {
            $images = $potential->images ?: [];
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('potentials', 'public');
                    $images[] = $path;
                }
            }
        }

        return $images;
    }
}
