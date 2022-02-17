@props(['active' => false])

@php
$activeLink = $active ? 'active' : '';
@endphp
<a {{ $attributes->merge(['class' => "h-full flex items-center text-gray-700 px-3 py-2 text-sm font-medium nav-link $activeLink"]) }}>
  {{ $slot }}
</a>
