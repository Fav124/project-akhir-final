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

        if ($request->has('user_id') && $request->user_id != '') {
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

        if ($request->ajax()) {
            return view('admin.activity._table', compact('logs'));
        }

        return view('admin.activity.index', compact('logs', 'users'));
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
