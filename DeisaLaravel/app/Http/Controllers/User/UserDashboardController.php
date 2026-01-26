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
            
            // Active patients (those who are still 'sakit')
            $activePatients = SantriSakit::with(['santri', 'santri.kelas'])
                ->where('status', 'sakit')
                ->orderBy('created_at', 'desc')
                ->get();
                
            $perluTindakan = $activePatients->count();

            // Recent activity (all statuses)
            $recentPatients = SantriSakit::with(['santri', 'santri.kelas'])
                ->latest()
                ->limit(5)
                ->get();

            return view('user.dashboard', compact(
                'pasienHariIni', 
                'perluTindakan', 
                'activePatients', 
                'recentPatients'
            ));
        } catch (\Exception $e) {
            return view('user.dashboard', [
                'pasienHariIni' => 0,
                'perluTindakan' => 0,
                'activePatients' => [],
                'recentPatients' => []
            ])->with('error', 'Gagal memuat data dashboard.');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
