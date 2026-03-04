{{-- Title --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-400">*</span></label>
    <input type="text" name="title" value="{{ old('title', $entry->title ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300
                  @error('title') border-red-400 @enderror"
           placeholder="Brief summary of the log entry">
    @error('title')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Date & Time --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time <span class="text-red-400">*</span></label>
    <input type="datetime-local" name="logged_at"
           value="{{ old('logged_at', isset($entry) ? $entry->logged_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300
                  @error('logged_at') border-red-400 @enderror">
    @error('logged_at')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Category & Severity Row --}}
<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-400">*</span></label>
        <select name="category" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ old('category', $entry->category ?? 'General') == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Severity <span class="text-red-400">*</span></label>
        <select name="severity" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            @foreach($severities as $sev)
                <option value="{{ $sev }}" {{ old('severity', $entry->severity ?? 'info') == $sev ? 'selected' : '' }}>
                    {{ ucfirst($sev) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Description --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="5"
              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
              placeholder="Detailed notes, observations, or actions taken...">{{ old('description', $entry->description ?? '') }}</textarea>
</div>
