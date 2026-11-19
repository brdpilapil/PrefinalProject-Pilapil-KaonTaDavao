@props(['rating'])

@php
    $rounded = (int) round((float) $rating);
@endphp

<span class="inline-flex items-center gap-0.5 text-amber-500" aria-label="{{ $rating }} out of 5 stars">
    @for ($i = 1; $i <= 5; $i++)
        <span>{{ $i <= $rounded ? '★' : '☆' }}</span>
    @endfor
</span>