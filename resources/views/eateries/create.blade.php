@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white border border-stone-200 rounded-xl p-6 shadow-sm">
        <h1 class="text-2xl font-extrabold text-stone-900 mb-6">Add New Eatery</h1>

        <form method="POST" action="{{ route('eateries.store') }}">
            @csrf
            @include('eateries._form')

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-emerald-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-emerald-700">
                    Save Eatery
                </button>
                <a href="{{ route('eateries.index') }}" class="text-sm text-stone-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
@endsection