<header class="bg-emerald-900 text-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="text-lg font-extrabold tracking-tight">
            Kaon Ta! Davao Pilapil's Food Guide
        </a>

        <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-300">Home</a>
            <a href="{{ route('eateries.index') }}" class="hover:text-amber-300">Eateries</a>
            <a href="{{ route('districts.index') }}" class="hover:text-amber-300">Districts</a>
            <a href="{{ route('eateries.create') }}" class="bg-amber-400 text-emerald-950 font-semibold px-3 py-1.5 rounded-lg hover:bg-amber-300">
                Add Eatery
            </a>
        </nav>
    </div>
</header>