<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $logs = $query->paginate(20);

        if ($request->ajax()) {
            return view('history.table', compact('logs'))->render();
        }

        return view('history.index', compact('logs'));
    }
}
