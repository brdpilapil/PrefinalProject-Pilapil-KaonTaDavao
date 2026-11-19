@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-extrabold text-stone-900">Davao Eateries</h1>
        <a href="{{ route('eateries.create') }}" class="bg-emerald-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-700">
            + Add Eatery
        </a>
    </div>

    <form method="GET" action="{{ route('eateries.index') }}" class="bg-white border border-stone-200 rounded-xl p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
        <div>
            <label for="q" class="block text-xs font-semibold text-stone-600 mb-1">Search Name or Specialty</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="e.g. Tinola"
                   class="w-full rounded-lg border-stone-300 text-sm">
        </div>

        <div>
            <label for="district" class="block text-xs font-semibold text-stone-600 mb-1">District</label>
            <select id="district" name="district" class="w-full rounded-lg border-stone-300 text-sm">
                <option value="">All Districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected((string) request('district') === (string) $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="feature" class="block text-xs font-semibold text-stone-600 mb-1">Feature</label>
            <select id="feature" name="feature" class="w-full rounded-lg border-stone-300 text-sm">
                <option value="">All Features</option>
                @foreach ($features as $feature)
                    <option value="{{ $feature->name }}" @selected(request('feature') === $feature->name)>
                        {{ $feature->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="bg-emerald-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-700">
                Filter
            </button>
            <a href="{{ route('eateries.index') }}" class="border border-stone-300 text-stone-700 text-sm font-medium px-3 py-2 rounded-lg hover:bg-stone-50">
                Reset
            </a>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <div class="bg-white border border-stone-200 rounded-xl p-8 text-center text-stone-600">
            No eateries match your filters.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $eateries->links() }}
        </div>
    @endif
@endsection