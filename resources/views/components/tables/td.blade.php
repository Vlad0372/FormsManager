@props(['textWrap' => false])

@php
    $classes = 'border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400';

    if($textWrap == true) $classes .= ' wrap';
@endphp

<td {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</td>

<style>
    .wrap {
    overflow-wrap: break-word;
    }
</style>