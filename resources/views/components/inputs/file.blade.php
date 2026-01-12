@props([
    'id',
    'name',
    'label' => null,
    'required' => false,
    'accept' => null
])

<div class="mb-4">
    @if ($label)
        <label
            for="{{ $id }}"
            class="block text-gray-700 mb-1"
        >
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="file"
        @if ($required) required @endif
        @if ($accept) accept="{{ $accept }}" @endif
        class="w-full px-4 py-2 border rounded focus:outline-none
               @error($name) border-red-500 @enderror"
    />

    @error($name)
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>
