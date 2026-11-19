@extends('layouts.app')

@section('content')
    <section class="mb-10">
        <h1 class="text-3xl font-extrabold text-stone-900 mb-2">Discover Davao's Best Carinderias</h1>
        <p class="text-stone-600 mb-6">Explore neighborhood eateries, business permits, signature dishes, and local reviews across Davao City.</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-stone-200 rounded-xl p-5">
                <p class="text-xs uppercase tracking-wider text-stone-500 font-semibold">Eateries</p>
                <p class="text-3xl font-extrabold text-emerald-800 mt-1">{{ $eateryCount }}</p>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5">
                <p class="text-xs uppercase tracking-wider text-stone-500 font-semibold">Districts</p>
                <p class="text-3xl font-extrabold text-emerald-800 mt-1">{{ $districtCount }}</p>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-5">
                <p class="text-xs uppercase tracking-wider text-stone-500 font-semibold">Reviews</p>
                <p class="text-3xl font-extrabold text-emerald-800 mt-1">{{ $reviewCount }}</p>
            </div>
        </div>
    </section>

    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-stone-900">Top Rated</h2>
            <a href="{{ route('eateries.index') }}" class="text-sm font-semibold text-emerald-800 hover:underline">
                View all eateries →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($topEateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    </section>
@endsection