@extends('layouts.app')

@section('title', 'All Entries')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Entries</p>
        <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Today</p>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['today'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Errors</p>
        <p class="text-3xl font-bold text-red-500">{{ $stats['errors'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Critical</p>
        <p class="text-3xl font-bold text-purple-600">{{ $stats['critical'] }}</p>
    </div>
</div>

{{-- Filter Bar --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" action="{{ route('entries.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search title or description..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Category</label>
            <select name="category" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">All Categories</option>
                @foreach(['General','Maintenance','Incident','Observation','Task','Other'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Severity</label>
            <select name="severity" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">All Severities</option>
                @foreach(['info','warning','error','critical'] as $sev)
                    <option value="{{ $sev }}" {{ request('severity') == $sev ? 'selected' : '' }}>{{ ucfirst($sev) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>
        @if(request()->anyFilled(['search','category','severity']))
            <a href="{{ route('entries.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Clear</a>
        @endif
    </form>
</div>

{{-- Entries Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($entries->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <i class="fa-solid fa-book text-5xl mb-4 text-gray-200"></i>
            <p class="text-lg font-medium">No log entries found</p>
            <p class="text-sm mt-1">
                <a href="{{ route('entries.create') }}" class="text-blue-500 hover:underline">Create your first entry</a>
            </p>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs text-gray-400 uppercase tracking-wider px-6 py-3">Date & Time</th>
                    <th class="text-left text-xs text-gray-400 uppercase tracking-wider px-6 py-3">Title</th>
                    <th class="text-left text-xs text-gray-400 uppercase tracking-wider px-6 py-3 hidden md:table-cell">Category</th>
                    <th class="text-left text-xs text-gray-400 uppercase tracking-wider px-6 py-3">Severity</th>
                    <th class="text-right text-xs text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($entries as $entry)
                    @php
                        $colors = [
                            'info'     => 'bg-blue-100 text-blue-700',
                            'warning'  => 'bg-yellow-100 text-yellow-700',
                            'error'    => 'bg-red-100 text-red-700',
                            'critical' => 'bg-purple-100 text-purple-700',
                        ];
                        $color = $colors[$entry->severity] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-400 whitespace-nowrap">
                            {{ $entry->logged_at->format('M d, Y') }}<br>
                            <span class="text-xs">{{ $entry->logged_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('entries.show', $entry) }}" class="font-medium text-gray-800 hover:text-blue-600">
                                {{ $entry->title }}
                            </a>
                            @if($entry->description)
                                <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $entry->description }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ $entry->category }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full {{ $color }}">
                                {{ strtoupper($entry->severity) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('entries.edit', $entry) }}" class="text-blue-400 hover:text-blue-600 mr-3">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('entries.destroy', $entry) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this entry?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-300 hover:text-red-500">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($entries->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $entries->links() }}
            </div>
        @endif
    @endif
</div>

@endsection
