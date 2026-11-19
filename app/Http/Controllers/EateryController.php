<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EateryController extends Controller
{
    public function index(Request $request): View
    {
        $eateries = Eatery::query()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q');
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('specialty', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('district'), function ($query) use ($request) {
                $query->where('district_id', $request->integer('district'));
            })
            ->when($request->filled('feature'), function ($query) use ($request) {
                $feature = $request->string('feature');
                $query->whereHas('features', fn ($sub) => $sub->where('name', $feature));
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create(): View
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(StoreEateryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $eatery = Eatery::create([
            ...Arr::only($validated, ['district_id', 'name', 'address', 'price_range', 'specialty', 'is_open']),
            'slug' => Str::slug($validated['name']),
        ]);

        $eatery->permit()->create(Arr::only($validated, ['permit_no', 'expires_on']));
        $eatery->features()->sync($validated['features']);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('status', 'Eatery added.');
    }

    public function show(Eatery $eatery): View
    {
        $eatery->load([
            'district',
            'permit',
            'dishes',
            'features',
            'reviews' => fn ($query) => $query->latest()->with('user'),
        ]);

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery): View
    {
        $eatery->load(['permit', 'features']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery): RedirectResponse
    {
        $validated = $request->validated();

        $eatery->update([
            ...Arr::only($validated, ['district_id', 'name', 'address', 'price_range', 'specialty', 'is_open']),
            'slug' => Str::slug($validated['name']),
        ]);

        $eatery->permit()->updateOrCreate(
            ['eatery_id' => $eatery->id],
            Arr::only($validated, ['permit_no', 'expires_on'])
        );

        $eatery->features()->sync($validated['features']);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('status', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery): RedirectResponse
    {
        $eatery->permit()?->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()
            ->route('eateries.index')
            ->with('status', 'Eatery deleted.');
    }
}