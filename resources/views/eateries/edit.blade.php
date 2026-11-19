@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white border border-stone-200 rounded-xl p-6 shadow-sm">
        <h1 class="text-2xl font-extrabold text-stone-900 mb-6">Edit {{ $eatery->name }}</h1>

        <form method="POST" action="{{ route('eateries.update', $eatery) }}">
            @csrf
            @method('PUT')
            @include('eateries._form')

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-emerald-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-emerald-700">
                    Update Eatery
                </button>
                <a href="{{ route('eateries.show', $eatery) }}" class="text-sm text-stone-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
@endsection