@props([
    'type' => 'success',
    'message' => null,
    'timeout' => 3000
])

@if(session()->has($type))
    <div
        id="{{ $type }}-alert"
        data-duration="{{ $timeout }}"
        class="fixed top-8 right-6 -translate-y-1/2
               z-50 px-4 py-2 rounded shadow-lg text-sm text-white
               {{ $type === 'success' ? 'bg-green-500' : 'bg-red-500' }}"
    >
        {{ $message ?? session($type) }}
    </div>
@endif
