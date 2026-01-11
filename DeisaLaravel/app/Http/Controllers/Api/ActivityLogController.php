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
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return response()->json($logs);
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
