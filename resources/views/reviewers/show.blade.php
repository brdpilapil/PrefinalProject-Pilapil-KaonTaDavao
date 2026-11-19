@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-stone-900">{{ $user->name }}</h1>
        <p class="text-sm font-medium text-stone-600 mt-1">
            {{ $user->reviews_count }} {{ Str::plural('review', $user->reviews_count) }} written
        </p>
    </div>

    <div class="space-y-4">
        @foreach ($user->reviews as $review)
            <article class="bg-white border border-stone-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2">
                    <a href="{{ route('eateries.show', $review->eatery) }}"
                       class="text-lg font-bold text-emerald-800 hover:underline">
                        {{ $review->eatery->name }}
                    </a>
                    <x-rating :rating="$review->rating" />
                </div>
                <p class="mt-2 text-sm text-stone-700">{{ $review->body }}</p>
            </article>
        @endforeach
    </div>
@endsection