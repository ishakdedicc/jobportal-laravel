@props([
    'url' => '/',
    'active' => false,
    'icon' => null,
    'mobile' => false
])

@php
    $baseClasses = $mobile
        ? 'block px-4 py-2 hover:bg-blue-700'
        : 'text-white hover:underline py-2';

    $activeClasses = $active ? 'text-yellow-500 font-bold' : '';
@endphp

<a
    href="{{ $url }}"
    class="{{ $baseClasses }} {{ $activeClasses }}"
    @if($active) aria-current="page" @endif
>
    @if($icon)
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</a>
