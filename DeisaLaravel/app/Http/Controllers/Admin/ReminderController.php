<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::where('user_id', Auth::id())
            ->active()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reminders
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'type' => 'required|string',
            'priority' => 'required|in:low,normal,high',
            'data' => 'nullable|array'
        ]);

        $reminder = Reminder::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reminder created successfully',
            'data' => $reminder
        ]);
    }

    public function dismiss($id)
    {
        $reminder = Reminder::where('user_id', Auth::id())->findOrFail($id);
        $reminder->update(['is_dismissed' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Reminder dismissed'
        ]);
    }
}
