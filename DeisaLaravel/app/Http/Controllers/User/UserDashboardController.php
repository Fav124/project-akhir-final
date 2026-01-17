<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SantriSakit;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        try {
            $today = Carbon::today();
            $pasienHariIni = SantriSakit::whereDate('created_at', $today)->count();
            $perluTindakan = SantriSakit::where('status', 'menunggu')->count();

            // Recent Patients
            $recentPatients = SantriSakit::with('santri')->latest()->limit(5)->get();

            return view('user.dashboard', compact('pasienHariIni', 'perluTindakan', 'recentPatients'));
        } catch (\Exception $e) {
            return view('user.dashboard', [
                'pasienHariIni' => 0,
                'perluTindakan' => 0,
                'recentPatients' => []
            ])->with('error', 'Gagal memuat data dashboard.');
        }
    }
}
