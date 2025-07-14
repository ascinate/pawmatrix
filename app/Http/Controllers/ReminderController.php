<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::with('assignedUser')->get();
        $users = User::whereIn('role', ['admin', 'vet', 'staff'])->get();
        
        return view('reminder', compact('reminders', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
        ]);

        $reminder = Reminder::create($validated);

        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully');
    }

    public function update(Request $request, Reminder $reminder)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
        ]);

        $reminder->update($validated);

        return redirect()->route('reminders.index')->with('success', 'Reminder updated successfully');
    }

    public function destroy(Reminder $reminder)
    {
        $reminder->delete();
        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully');
    }

    public function updateStatus(Request $request, Reminder $reminder)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,working,completed'
        ]);

        $reminder->update(['status' => $validated['status']]);
        return response()->json(['success' => true]);
    }
}