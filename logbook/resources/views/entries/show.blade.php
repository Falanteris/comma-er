@extends('layouts.app')

@section('title', $entry->title)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('entries.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 flex-1">Log Entry Detail</h1>
        <a href="{{ route('entries.edit', $entry) }}"
           class="bg-blue-50 hover:bg-blue-100 text-blue-600 text-sm font-medium px-4 py-2 rounded-lg transition">
            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
        </a>
        <form action="{{ route('entries.destroy', $entry) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this entry?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="bg-red-50 hover:bg-red-100 text-red-500 text-sm font-medium px-4 py-2 rounded-lg transition">
                <i class="fa-solid fa-trash mr-1"></i> Delete
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @php
            $colors = [
                'info'     => 'bg-blue-100 text-blue-700 border-blue-200',
                'warning'  => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                'error'    => 'bg-red-100 text-red-700 border-red-200',
                'critical' => 'bg-purple-100 text-purple-700 border-purple-200',
            ];
            $color = $colors[$entry->severity] ?? 'bg-gray-100 text-gray-600 border-gray-200';
        @endphp

        <div class="flex items-start justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">{{ $entry->title }}</h2>
            <span class="inline-block text-xs font-bold px-3 py-1 rounded-full border {{ $color }} ml-4 whitespace-nowrap">
                {{ strtoupper($entry->severity) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Category</p>
                <p class="font-medium text-gray-700">{{ $entry->category }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Logged At</p>
                <p class="font-medium text-gray-700">{{ $entry->logged_at->format('F j, Y — H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Created</p>
                <p class="text-gray-500">{{ $entry->created_at->diffForHumans() }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Last Updated</p>
                <p class="text-gray-500">{{ $entry->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        @if($entry->description)
            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Description</p>
                <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $entry->description }}</div>
            </div>
        @else
            <div class="border-t border-gray-100 pt-4 text-gray-400 text-sm italic">
                No description provided.
            </div>
        @endif
    </div>
</div>
@endsection
