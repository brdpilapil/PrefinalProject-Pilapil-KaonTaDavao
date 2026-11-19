@props(['eatery'])

@php
    $pesoMap = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
    $count = $eatery->reviews_count ?? 0;
    $avg = $eatery->reviews_avg_rating;
@endphp

<article class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm flex flex-col justify-between gap-4">
    <div class="space-y-2">
        <div class="flex items-start justify-between gap-2">
            <div>
                <h3 class="text-lg font-bold text-stone-900">
                    <a href="{{ route('eateries.show', $eatery) }}" class="hover:text-emerald-700">
                        {{ $eatery->name }}
                    </a>
                </h3>
                <p class="text-xs text-stone-500">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="underline hover:text-emerald-700">
                        {{ $eatery->district->name }}
                    </a>
                    ·
                    <span class="font-semibold text-emerald-800">{{ $pesoMap[$eatery->price_range] ?? '₱' }}</span>
                </p>
            </div>

            @if (! $eatery->is_open)
                <span class="shrink-0 rounded-full bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-0.5">
                    Closed
                </span>
            @endif
        </div>

        @if ($eatery->specialty)
            <p class="text-sm text-stone-600">
                <span class="font-medium text-stone-800">Specialty:</span> {{ $eatery->specialty }}
            </p>
        @endif

        <div class="flex flex-wrap gap-1.5 pt-1">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                   class="text-xs bg-amber-100 text-amber-900 hover:bg-amber-200 px-2 py-0.5 rounded-full font-medium">
                    {{ $feature->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="pt-3 border-t border-stone-100 text-sm flex items-center gap-2">
        @if ($count > 0)
            <x-rating :rating="$avg" />
            <span class="font-semibold text-stone-800">{{ number_format((float) $avg, 1) }}</span>
            <span class="text-stone-500">({{ $count }} {{ Str::plural('review', $count) }})</span>
        @else
            <span class="text-stone-400 italic">No reviews yet</span>
        @endif
    </div>
</article>