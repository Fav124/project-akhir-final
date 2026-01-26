<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // If not admin, only show own logs
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        } elseif ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('action') && $request->action != '') {
            $query->where('action', 'like', "%{$request->action}%");
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest()->paginate(20);
        $users = \App\Models\User::all();

        // Summary Stats (Ringkasan)
        $summaryQuery = ActivityLog::query();
        if (auth()->user()->role !== 'admin') {
            $summaryQuery->where('user_id', auth()->id());
        }
        
        $summary = [
            'total' => (clone $summaryQuery)->count(),
            'today' => (clone $summaryQuery)->whereDate('created_at', today())->count(),
            'akademik' => (clone $summaryQuery)->where('module', 'Akademik')->count(),
            'santri' => (clone $summaryQuery)->where('module', 'Santri')->count(),
            'sakit' => (clone $summaryQuery)->where('module', 'Sakit')->count(),
            'obat' => (clone $summaryQuery)->where('module', 'Obat')->count(),
        ];

        if ($request->ajax()) {
            return view('admin.activity._table', compact('logs'));
        }

        return view('admin.activity.index', compact('logs', 'users', 'summary'));
    }

    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        if (request()->ajax()) {
            return view('admin.activity._detail', compact('log'));
        }
        return view('admin.activity.show', compact('log'));
    }
}
