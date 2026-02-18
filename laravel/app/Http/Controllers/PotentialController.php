<?php

namespace App\Http\Controllers;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Http\Request;

class PotentialController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Potential::with('village')->where('verification_status', 'verified');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $baseQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', '%'.$q.'%')
                    ->orWhere('description', 'like', '%'.$q.'%');
            });
        }

        $selectedDistrict = $request->input('district');
        $selectedVillageId = $request->input('village');
        $selectedCategory = $request->input('category');

        if ($selectedDistrict) {
            $baseQuery->whereHas('village', function ($sub) use ($selectedDistrict) {
                $sub->where('district_name', $selectedDistrict);
            });
        }

        if ($selectedVillageId) {
            $baseQuery->where('village_id', (int) $selectedVillageId);
        }

        if ($selectedCategory) {
            $baseQuery->where(function ($sub) use ($selectedCategory) {
                $sub->where('attributes->category', $selectedCategory)
                    ->orWhere('attributes->category_slug', $selectedCategory);
            });
        }

        $latestPotentials = (clone $baseQuery)
            ->orderBy('created_at', 'desc')
            ->limit(9)
            ->get();

        $excludeIds = $latestPotentials->pluck('id')->all();

        $popularQuery = (clone $baseQuery)
            ->when($excludeIds, function ($query) use ($excludeIds) {
                $query->whereNotIn('id', $excludeIds);
            })
            ->orderBy('created_at', 'desc');

        $popularPotentials = $popularQuery
            ->paginate(9)
            ->withQueryString();

        $districts = Village::select('district_name')
            ->distinct()
            ->orderBy('district_name')
            ->pluck('district_name');

        $villagesQuery = Village::query();

        if ($selectedDistrict) {
            $villagesQuery->where('district_name', $selectedDistrict);
        }

        $villages = $villagesQuery
            ->orderBy('village_name')
            ->get();

        return view('home', [
            'latestPotentials' => $latestPotentials,
            'popularPotentials' => $popularPotentials,
            'districts' => $districts,
            'villages' => $villages,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function show(string $slug)
    {
        $potential = Potential::with('village')->where('slug', $slug)->firstOrFail();

        return view('potentials.show', [
            'potential' => $potential,
        ]);
    }
}
