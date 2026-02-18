<?php

namespace App\Http\Controllers;

use App\Models\Potential;
use Illuminate\Http\Request;

class PotentialController extends Controller
{
    public function index(Request $request)
    {
        $query = Potential::with('village')->where('verification_status', 'verified');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', '%'.$q.'%')
                    ->orWhere('description', 'like', '%'.$q.'%');
            });
        }

        if ($request->filled('district')) {
            $district = $request->input('district');
            $query->whereHas('village', function ($sub) use ($district) {
                $sub->where('district_name', $district);
            });
        }

        $potentials = $query->orderBy('created_at', 'desc')->limit(9)->get();

        return view('home', [
            'potentials' => $potentials,
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

