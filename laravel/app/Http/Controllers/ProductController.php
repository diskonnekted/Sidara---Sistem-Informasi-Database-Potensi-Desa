<?php

namespace App\Http\Controllers;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Potential::with('village')->where('verification_status', 'verified');

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('attributes->product_category', $request->category);
        }

        // Filter berdasarkan kecamatan
        if ($request->filled('kecamatan')) {
            $query->whereHas('village', function($q) use ($request) {
                $q->where('district_name', $request->kecamatan);
            });
        }

        // Filter berdasarkan desa
        if ($request->filled('desa')) {
            $query->whereHas('village', function($q) use ($request) {
                $q->where('village_name', $request->desa);
            });
        }

        // Filter berdasarkan harga
        if ($request->has('harga_min')) {
            $query->whereRaw("CAST(REPLACE(REPLACE(price_range, 'Rp.', ''), ',', '') AS UNSIGNED) >= ?", [$request->harga_min]);
        }
        if ($request->has('harga_max')) {
            $query->whereRaw("CAST(REPLACE(REPLACE(price_range, 'Rp.', ''), ',', '') AS UNSIGNED) <= ?", [$request->harga_max]);
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get filter options
        $categories = Potential::where('verification_status', 'verified')
            ->whereNotNull('attributes->product_category')
            ->get() // Ambil semua data dulu
            ->pluck('attributes.product_category') // Kemudian pluck dari collection
            ->unique()
            ->filter()
            ->values();

        $kecamatans = Village::distinct()->pluck('district_name')->filter()->values();
        $desas = Village::distinct()->pluck('village_name')->filter()->values();

        return view('products.index', compact('products', 'categories', 'kecamatans', 'desas'));
    }

    public function show($id)
    {
        $product = Potential::with('village')->where('verification_status', 'verified')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
