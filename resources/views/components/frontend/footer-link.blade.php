@props(['active' => false])

@php
$active_link = $active ? 'text-theme' : 'text-gray-400';
@endphp
<a {{ $attributes->merge(['class' => "hover:text-theme h-full px-4 flex justify-center items-center rounded $active_link transition ease-in-out duration-150"]) }}>
  {{ $slot }}
</a>
