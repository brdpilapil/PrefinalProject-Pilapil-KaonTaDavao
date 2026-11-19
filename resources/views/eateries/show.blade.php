@extends('layouts.app')

@section('content')
    @php
        $pesoMap = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
    @endphp

    <div class="bg-white border border-stone-200 rounded-xl p-6 shadow-sm mb-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-extrabold text-stone-900">{{ $eatery->name }}</h1>
                    @if (! $eatery->is_open)
                        <span class="rounded-full bg-red-100 text-red-700 text-xs font-bold px-3 py-1">Closed</span>
                    @endif
                </div>

                <p class="text-sm text-stone-600 mt-1">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="font-semibold text-emerald-800 underline">
                        {{ $eatery->district->name }}
                    </a>
                    · {{ $eatery->address }}
                    · <span class="font-bold">{{ $pesoMap[$eatery->price_range] ?? '₱' }}</span>
                </p>

                @if ($eatery->specialty)
                    <p class="text-sm text-stone-700 mt-2">
                        <span class="font-semibold">House Specialty:</span> {{ $eatery->specialty }}
                    </p>
                @endif

                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach ($eatery->features as $feature)
                        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                           class="text-xs bg-amber-100 text-amber-900 hover:bg-amber-200 px-2.5 py-1 rounded-full font-medium">
                            {{ $feature->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}"
                   class="border border-stone-300 text-stone-800 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-stone-50">
                    Edit
                </a>

                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if ($eatery->permit)
            <div class="mt-6 rounded-lg border border-stone-200 bg-stone-50 p-4 flex flex-wrap items-center justify-between gap-2 text-sm">
                <div>
                    <span class="font-semibold text-stone-800">Business Permit:</span>
                    <span class="font-mono">{{ $eatery->permit->permit_no }}</span>
                    ·
                    <span class="text-stone-600">Expires {{ $eatery->permit->expires_on->format('M d, Y') }}</span>
                </div>

                @if ($eatery->permit->expires_on->lt(today()))
                    <span class="font-bold text-red-600">Permit expired</span>
                @endif
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <section class="lg:col-span-1">
            <h2 class="text-xl font-bold text-stone-900 mb-4">Dishes</h2>

            @if ($eatery->dishes->isEmpty())
                <p class="text-sm text-stone-500">No dishes listed yet.</p>
            @else
                <ul class="bg-white border border-stone-200 rounded-xl divide-y divide-stone-200">
                    @foreach ($eatery->dishes as $dish)
                        <li class="p-4 flex items-center justify-between gap-2">
                            <div>
                                <p class="font-semibold text-stone-900">{{ $dish->name }}</p>
                                @if ($dish->is_bestseller)
                                    <span class="inline-block mt-0.5 text-xs bg-emerald-100 text-emerald-800 font-semibold px-2 py-0.5 rounded">
                                        Bestseller
                                    </span>
                                @endif
                            </div>
                            <span class="font-bold text-stone-800">₱{{ number_format((float) $dish->price, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="lg:col-span-2 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-stone-900 mb-4">Write a Review</h2>

                @if (! $eatery->is_open)
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm font-medium">
                        This eatery is closed. Reviews are paused.
                    </div>
                @else
                    <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}"
                          class="bg-white border border-stone-200 rounded-xl p-5 space-y-4">
                        @csrf

                        @if ($errors->any())
                            <div class="rounded-lg border border-red-300 bg-red-50 p-3 text-sm text-red-800">
                                <ul class="list-disc pl-5 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="user_id" class="block text-sm font-semibold text-stone-700">Reviewer</label>
                                <select id="user_id" name="user_id" class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                                    <option value="">Choose reviewer</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected((string) old('user_id') === (string) $user->id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rating" class="block text-sm font-semibold text-stone-700">Rating (1–5)</label>
                                <select id="rating" name="rating" class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                                    <option value="">Select stars</option>
                                    @for ($star = 5; $star >= 1; $star--)
                                        <option value="{{ $star }}" @selected((string) old('rating') === (string) $star)>
                                            {{ $star }} {{ Str::plural('Star', $star) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="body" class="block text-sm font-semibold text-stone-700">Review</label>
                            <textarea id="body" name="body" rows="3"
                                      class="mt-1 w-full rounded-lg border-stone-300 text-sm">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-emerald-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-700">
                            Post Review
                        </button>
                    </form>
                @endif
            </div>

            <div>
                <h2 class="text-xl font-bold text-stone-900 mb-4">Reviews ({{ $eatery->reviews->count() }})</h2>

                @if ($eatery->reviews->isEmpty())
                    <p class="text-sm text-stone-500">No reviews yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($eatery->reviews as $review)
                            <div class="bg-white border border-stone-200 rounded-xl p-4">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <a href="{{ route('reviewers.show', $review->user) }}"
                                           class="font-bold text-emerald-800 hover:underline">
                                            {{ $review->user->name }}
                                        </a>
                                        <div class="flex items-center gap-2 text-xs text-stone-500 mt-0.5">
                                            <x-rating :rating="$review->rating" />
                                            <span>{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 font-semibold hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                                <p class="mt-3 text-sm text-stone-700">{{ $review->body }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection