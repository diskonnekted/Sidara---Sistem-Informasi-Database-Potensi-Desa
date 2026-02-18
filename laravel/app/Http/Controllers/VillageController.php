<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index(Request $request)
    {
        $query = Village::query()->orderBy('district_name')->orderBy('village_name');

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($sub) use ($q) {
                $sub->where('village_name', 'like', '%' . $q . '%')
                    ->orWhere('district_name', 'like', '%' . $q . '%');
            });
        }

        $villages = $query->get();

        return view('villages.index', [
            'villages' => $villages,
        ]);
    }

    public function show(string $slug)
    {
        $village = Village::with('potentials')->where('slug', $slug)->firstOrFail();

        return view('villages.show', [
            'village' => $village,
        ]);
    }
}

