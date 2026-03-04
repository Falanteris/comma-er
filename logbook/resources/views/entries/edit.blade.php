@extends('layouts.app')

@section('title', 'Edit Entry')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('entries.show', $entry) }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Log Entry</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('entries.update', $entry) }}" method="POST">
            @csrf @method('PUT')
            @include('entries._form')
            <div class="flex gap-3 mt-6">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition">
                    <i class="fa-solid fa-save mr-2"></i>Update Entry
                </button>
                <a href="{{ route('entries.show', $entry) }}"
                   class="border border-gray-200 text-gray-500 hover:bg-gray-50 font-medium px-6 py-2.5 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
