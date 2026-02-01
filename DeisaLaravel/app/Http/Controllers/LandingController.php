<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Obat;
use App\Models\SantriSakit;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Statistics for the landing page
        $stats = [
            'total_santri' => Santri::count(),
            'total_obat' => Obat::count(),
            'total_checks' => SantriSakit::count(),
            'active_cases' => SantriSakit::where('status', 'dalam_perawatan')->count(),
        ];

        return view('landing.index', compact('stats'));
    }

    /**
     * Display features page.
     */
    public function features()
    {
        return view('landing.features');
    }
}
