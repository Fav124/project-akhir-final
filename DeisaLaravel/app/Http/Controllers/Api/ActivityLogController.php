<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 50);
        $query = ActivityLog::with('user');

        // Role filtering
        if ($request->user()->role !== 'admin') {
            $query->where('user_id', $request->user()->id);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate($limit);

        // Summary stats
        $summaryQuery = ActivityLog::query();
        if ($request->user()->role !== 'admin') {
            $summaryQuery->where('user_id', $request->user()->id);
        }

        $summary = [
            'total' => (clone $summaryQuery)->count(),
            'today' => (clone $summaryQuery)->whereDate('created_at', now())->count(),
            'santri' => (clone $summaryQuery)->where('module', 'Santri')->count(),
            'sakit' => (clone $summaryQuery)->where('module', 'Sakit')->count(),
            'obat' => (clone $summaryQuery)->where('module', 'Obat')->count(),
        ];

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'data' => $logs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'action' => 'required',
            'module' => 'required',
            'detail' => 'nullable',
        ]);

        $log = ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => $request->action,
            'module' => $request->module,
            'detail' => $request->detail,
            'ip_address' => $request->ip()
        ]);

        return response()->json(['data' => $log], 201);
    }
}
