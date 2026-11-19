@php
    $selectedFeatures = old('features', isset($eatery) ? $eatery->features->pluck('id')->all() : []);
    $isOpenChecked = old('is_open', isset($eatery) ? $eatery->is_open : true);
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-bold mb-1">Please fix the following errors:</p>
        <ul class="list-disc pl-5 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-semibold text-stone-700">Eatery Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $eatery->name ?? '') }}"
               class="mt-1 w-full rounded-lg border-stone-300 text-sm">
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="district_id" class="block text-sm font-semibold text-stone-700">District</label>
            <select id="district_id" name="district_id" class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                <option value="">Select a district</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected((string) old('district_id', $eatery->district_id ?? '') === (string) $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
            @error('district_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price_range" class="block text-sm font-semibold text-stone-700">Price Range</label>
            <select id="price_range" name="price_range" class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                <option value="budget" @selected(old('price_range', $eatery->price_range ?? '') === 'budget')>Budget (₱)</option>
                <option value="mid" @selected(old('price_range', $eatery->price_range ?? '') === 'mid')>Mid (₱₱)</option>
                <option value="splurge" @selected(old('price_range', $eatery->price_range ?? '') === 'splurge')>Splurge (₱₱₱)</option>
            </select>
            @error('price_range')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="address" class="block text-sm font-semibold text-stone-700">Address</label>
        <input type="text" id="address" name="address" value="{{ old('address', $eatery->address ?? '') }}"
               class="mt-1 w-full rounded-lg border-stone-300 text-sm">
        @error('address')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="specialty" class="block text-sm font-semibold text-stone-700">Specialty (Optional)</label>
        <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}"
               class="mt-1 w-full rounded-lg border-stone-300 text-sm">
        @error('specialty')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="inline-flex items-center gap-2 text-sm font-semibold text-stone-700">
            <input type="checkbox" name="is_open" value="1" @checked((bool) $isOpenChecked) class="rounded border-stone-300 text-emerald-700">
            Currently Open
        </label>
        @error('is_open')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <span class="block text-sm font-semibold text-stone-700 mb-2">Features</span>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2 text-sm text-stone-700 bg-stone-50 border border-stone-200 rounded-lg px-3 py-2">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(in_array($feature->id, $selectedFeatures))
                           class="rounded border-stone-300 text-emerald-700">
                    {{ $feature->name }}
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-stone-200">
        <div>
            <label for="permit_no" class="block text-sm font-semibold text-stone-700">Permit Number</label>
            <input type="text" id="permit_no" name="permit_no"
                   value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}"
                   placeholder="DVO-2026-0923"
                   class="mt-1 w-full rounded-lg border-stone-300 text-sm">
            @error('permit_no')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="expires_on" class="block text-sm font-semibold text-stone-700">Permit Expiry Date</label>
            <input type="date" id="expires_on" name="expires_on"
                   value="{{ old('expires_on', isset($eatery->permit->expires_on) ? $eatery->permit->expires_on->format('Y-m-d') : '') }}"
                   class="mt-1 w-full rounded-lg border-stone-300 text-sm">
            @error('expires_on')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>