<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Santri;
use App\Models\SantriSakit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Staff Dashboard
     */
    public function dashboard()
    {
        $pasienHariIni = SantriSakit::whereDate('created_at', today())->count();
        $perluTindakan = SantriSakit::where('status', 'Sakit')->count();
        $totalObat = Obat::count();
        $obatHampirHabis = Obat::where('stok', '<', 10)->count();

        $activePatients = SantriSakit::with(['santri.kelas'])
            ->where('status', 'Sakit')
            ->latest()
            ->take(5)
            ->get();

        $recentPatients = SantriSakit::with(['santri.kelas'])
            ->latest()
            ->take(10)
            ->get();

        return view('staff.dashboard', compact(
            'pasienHariIni',
            'perluTindakan',
            'totalObat',
            'obatHampirHabis',
            'activePatients',
            'recentPatients'
        ));
    }

    /**
     * Medicine Management
     */
    public function obatIndex()
    {
        $obat = Obat::orderBy('nama_obat')->paginate(20);
        return view('staff.obat.index', compact('obat'));
    }

    public function obatCreate()
    {
        return view('staff.obat.create');
    }

    public function obatStore(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        Obat::create($validated);

        return redirect()->route('staff.obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function obatEdit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('staff.obat.edit', compact('obat'));
    }

    public function obatUpdate(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $obat->update($validated);

        return redirect()->route('staff.obat.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    public function obatDestroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('staff.obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    /**
     * View Santri Data
     */
    public function santriIndex(Request $request)
    {
        $query = Santri::with('kelas');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $santri = $query->orderBy('nama_lengkap')->paginate(20);

        return view('staff.santri.index', compact('santri'));
    }

    /**
     * Generate PDF Report
     */
    public function laporanIndex()
    {
        return view('staff.laporan.index');
    }

    public function laporanGenerate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:pasien,obat,summary',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $type = $validated['type'];

        $data = [];

        if ($type === 'pasien') {
            $data['pasien'] = SantriSakit::with(['santri.kelas'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            $view = 'staff.laporan.pdf.pasien';
        } elseif ($type === 'obat') {
            $data['obat'] = Obat::all();
            $view = 'staff.laporan.pdf.obat';
        } else {
            $data['totalPasien'] = SantriSakit::whereBetween('created_at', [$startDate, $endDate])->count();
            $data['pasienSembuh'] = SantriSakit::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'Sembuh')->count();
            $data['pasienSakit'] = SantriSakit::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'Sakit')->count();
            $data['totalObat'] = Obat::count();
            $data['obatHampirHabis'] = Obat::where('stok', '<', 10)->count();
            $view = 'staff.laporan.pdf.summary';
        }

        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

        $pdf = Pdf::loadView($view, $data);

        return $pdf->download('laporan-' . $type . '-' . now()->format('Y-m-d') . '.pdf');
    }
}
