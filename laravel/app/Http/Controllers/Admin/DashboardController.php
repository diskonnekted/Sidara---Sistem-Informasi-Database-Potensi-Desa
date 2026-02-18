<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potential;
use App\Models\Village;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPotentials = Potential::count();
        $verifiedPotentials = Potential::where('verification_status', 'verified')->count();
        $pendingPotentials = Potential::where('verification_status', 'pending')->count();
        $totalVillages = Village::count();

        $potentialsByDistrict = Village::withCount('potentials')
            ->orderByDesc('potentials_count')
            ->limit(5)
            ->get();

        $latestPotentials = Potential::with('village')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return view('admin.dashboard', [
            'totalPotentials' => $totalPotentials,
            'verifiedPotentials' => $verifiedPotentials,
            'pendingPotentials' => $pendingPotentials,
            'totalVillages' => $totalVillages,
            'potentialsByDistrict' => $potentialsByDistrict,
            'latestPotentials' => $latestPotentials,
        ]);
    }
}

