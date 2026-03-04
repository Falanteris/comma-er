<?php

namespace App\Http\Controllers;

use App\Models\LogEntry;
use Illuminate\Http\Request;

class LogEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = LogEntry::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by severity
        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        $entries = $query->orderBy('logged_at', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total'    => LogEntry::count(),
            'today'    => LogEntry::whereDate('logged_at', today())->count(),
            'critical' => LogEntry::where('severity', 'critical')->count(),
            'errors'   => LogEntry::where('severity', 'error')->count(),
        ];

        return view('entries.index', compact('entries', 'stats'));
    }

    public function create()
    {
        return view('entries.create', [
            'severities' => LogEntry::severities(),
            'categories' => LogEntry::categories(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'severity'    => 'required|in:info,warning,error,critical',
            'logged_at'   => 'required|date',
        ]);

        LogEntry::create($validated);

        return redirect()->route('entries.index')
            ->with('success', 'Log entry created successfully.');
    }

    public function show(LogEntry $entry)
    {
        return view('entries.show', compact('entry'));
    }

    public function edit(LogEntry $entry)
    {
        return view('entries.edit', [
            'entry'      => $entry,
            'severities' => LogEntry::severities(),
            'categories' => LogEntry::categories(),
        ]);
    }

    public function update(Request $request, LogEntry $entry)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'severity'    => 'required|in:info,warning,error,critical',
            'logged_at'   => 'required|date',
        ]);

        $entry->update($validated);

        return redirect()->route('entries.show', $entry)
            ->with('success', 'Log entry updated successfully.');
    }

    public function destroy(LogEntry $entry)
    {
        $entry->delete();

        return redirect()->route('entries.index')
            ->with('success', 'Log entry deleted.');
    }
}
