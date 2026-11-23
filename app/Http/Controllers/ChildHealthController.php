<?php

namespace App\Http\Controllers;

use App\Models\ChildHealth;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ChildHealthController extends Controller
{
    /**
     * Display a listing of child health records.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim((string) $request->input('search'));

        $childHealths = ChildHealth::query()
            ->with('resident')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nutritional_status', 'like', "%{$search}%")
                        ->orWhere('breastfeeding_status', 'like', "%{$search}%")
                        ->orWhere('deworming_status', 'like', "%{$search}%")
                        ->orWhereHas('resident', function ($residentQuery) use ($search) {
                            $residentQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('middle_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('assessment_date')
            ->paginate(10)
            ->withQueryString();

        return view('child-health.index', compact(
            'childHealths',
            'search'
        ));
    }

    /**
     * Show the form for creating a new child health record.
     */
    public function create(): View
    {
        $residents = $this->eligibleResidents()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('child-health.create', compact('residents'));
    }

    /**
     * Store a newly created child health record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                Rule::exists('residents', 'id')
                    ->where(function ($query) {
                        $query
                            ->whereDate('birth_date', '>=', today()->subYears(5)->toDateString())
                            ->whereDate('birth_date', '<=', today()->toDateString());
                    }),
            ],

            'assessment_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'weight_kg' => [
                'nullable',
                'numeric',
                'min:0',
                'max:300',
            ],

            'height_cm' => [
                'nullable',
                'numeric',
                'min:0',
                'max:250',
            ],

            'nutritional_status' => [
                'nullable',
                'in:Normal,Underweight,Wasted,Severely Wasted,Overweight,Obese',
            ],

            'breastfeeding_status' => [
                'nullable',
                'in:Exclusive Breastfeeding,Mixed Feeding,Formula Feeding,Not Breastfeeding,Not Applicable',
            ],

            'vitamin_a_status' => [
                'nullable',
                'in:Given,Not Given,Not Due',
            ],

            'vitamin_a_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'deworming_status' => [
                'nullable',
                'in:Given,Not Given,Not Due',
            ],

            'deworming_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'developmental_milestones' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'health_assessment' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $childHealth = ChildHealth::create($validated);

        return redirect()
            ->route('child-health.show', $childHealth)
            ->with('success', 'Child health record created successfully.');
    }

    /**
     * Display the specified child health record.
     */
    public function show(ChildHealth $childHealth): View
    {
        $childHealth->load('resident');

        return view('child-health.show', compact('childHealth'));
    }

    /**
     * Show the form for editing the specified child health record.
     */
    public function edit(ChildHealth $childHealth): View
    {
        $childHealth->load('resident');

        return view('child-health.edit', compact('childHealth'));
    }

    /**
     * Update the specified child health record.
     */
    public function update(
        Request $request,
        ChildHealth $childHealth
    ): RedirectResponse {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                Rule::in([(string) $childHealth->resident_id]),
            ],

            'assessment_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'weight_kg' => [
                'nullable',
                'numeric',
                'min:0',
                'max:300',
            ],

            'height_cm' => [
                'nullable',
                'numeric',
                'min:0',
                'max:250',
            ],

            'nutritional_status' => [
                'nullable',
                'in:Normal,Underweight,Wasted,Severely Wasted,Overweight,Obese',
            ],

            'breastfeeding_status' => [
                'nullable',
                'in:Exclusive Breastfeeding,Mixed Feeding,Formula Feeding,Not Breastfeeding,Not Applicable',
            ],

            'vitamin_a_status' => [
                'nullable',
                'in:Given,Not Given,Not Due',
            ],

            'vitamin_a_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'deworming_status' => [
                'nullable',
                'in:Given,Not Given,Not Due',
            ],

            'deworming_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'developmental_milestones' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'health_assessment' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $childHealth->update($validated);

        return redirect()
            ->route('child-health.index')
            ->with('success', 'Child health record updated successfully.');
    }

    /**
     * Remove the specified child health record.
     */
    public function destroy(ChildHealth $childHealth): RedirectResponse
    {
        $childHealth->delete();

        return redirect()
            ->route('child-health.index')
            ->with('success', 'Child health record deleted successfully.');
    }

    private function eligibleResidents(): Builder
    {
        return Resident::query()
            ->whereDate('birth_date', '>=', today()->subYears(5)->toDateString())
            ->whereDate('birth_date', '<=', today()->toDateString());
    }
}
