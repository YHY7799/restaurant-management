<!-- resources/views/components/search-select.blade.php -->
<div>
    <select 
        wire:model="{{ $attributes->get('wire:model') }}" 
        {{ $attributes->merge(['class' => 'w-full border rounded-lg p-2']) }}
        multiple="{{ $attributes->get('multiple') }}"
    >
        @if($attributes->get('searchable'))
            <input 
                type="text" 
                placeholder="Search..." 
                class="w-full p-2 border-b focus:outline-none" 
                wire:model.debounce.300ms="search"
            >
        @endif

        @foreach($options as $option)
            <option 
                value="{{ $option[$attributes->get('option-value')] }}"
                :selected="selectedItems.includes({{ $option[$attributes->get('option-value')] }})"
            >
                {{ $option[$attributes->get('option-label')] }}
            </option>
        @endforeach
    </select>
</div>