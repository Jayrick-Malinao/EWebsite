<?php

namespace App\Http\Controllers;

use App\Models\ChildHealth;
use App\Models\Resident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChildHealthController extends Controller
{
    /**
     * Display a listing of child health records.
     */
    public function index(Request $request): View
    {
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
        $residents = Resident::query()
            ->where(function ($query) {
                $query
                    ->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 19')
                    ->orWhere('birth_date', '>=', now()->subYears(19)->startOfDay());
            })
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
                'exists:residents,id',
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
                'string',
                'max:100',
            ],

            'breastfeeding_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'vitamin_a_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'vitamin_a_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'deworming_status' => [
                'nullable',
                'string',
                'max:100',
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
        $residents = Resident::query()
            ->where(function ($query) use ($childHealth) {
                $query
                    ->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 19')
                    ->orWhere('birth_date', '>=', now()->subYears(19)->startOfDay())
                    ->orWhere('id', $childHealth->resident_id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('child-health.edit', compact(
            'childHealth',
            'residents'
        ));
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
                'exists:residents,id',
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
                'string',
                'max:100',
            ],

            'breastfeeding_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'vitamin_a_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'vitamin_a_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'deworming_status' => [
                'nullable',
                'string',
                'max:100',
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
            ->route('child-health.show', $childHealth)
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
}