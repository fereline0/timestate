@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center text-gray-700 focus:outline-none transition ease-in-out duration-300'
            : 'inline-flex items-center text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
