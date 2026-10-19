<?php

namespace App\Http\Controllers;

use App\Models\HealthVisit;
use App\Models\Resident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HealthVisitController extends Controller
{
    /**
     * Display a list of health visits.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $healthVisits = HealthVisit::query()
            ->with('resident')
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('resident', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->latest('visit_date')
            ->paginate(10)
            ->withQueryString();

        return view('health-visits.index', [
            'healthVisits' => $healthVisits,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a health visit.
     */
    public function create(): View
    {
        $residents = Resident::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('health-visits.create', [
            'residents' => $residents,
        ]);
    }

    /**
     * Store a newly created health visit.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
            ],
            'visit_date' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
            'visit_type' => [
                'nullable',
                'string',
                'max:255',
            ],
            'chief_complaint' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'assessment' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'treatment' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'attended_by' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        HealthVisit::create($validated);

        return redirect()
            ->route('health-visits.index')
            ->with('success', 'Health visit recorded successfully.');
    }

    /**
     * Display a specific health visit.
     */
    public function show(HealthVisit $healthVisit): View
    {
        $healthVisit->load('resident');

        return view('health-visits.show', [
            'healthVisit' => $healthVisit,
        ]);
    }

    /**
     * Show the form for editing a health visit.
     */
    public function edit(HealthVisit $healthVisit): View
    {
        $residents = Resident::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('health-visits.edit', [
            'healthVisit' => $healthVisit,
            'residents' => $residents,
        ]);
    }

    /**
     * Update a health visit.
     */
    public function update(
        Request $request,
        HealthVisit $healthVisit
    ): RedirectResponse {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
            ],
            'visit_date' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
            'visit_type' => [
                'nullable',
                'string',
                'max:255',
            ],
            'chief_complaint' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'assessment' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'treatment' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'attended_by' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $healthVisit->update($validated);

        return redirect()
            ->route('health-visits.index')
            ->with('success', 'Health visit updated successfully.');
    }

    /**
     * Delete a health visit.
     */
    public function destroy(HealthVisit $healthVisit): RedirectResponse
    {
        $healthVisit->delete();

        return redirect()
            ->route('health-visits.index')
            ->with('success', 'Health visit deleted successfully.');
    }
}