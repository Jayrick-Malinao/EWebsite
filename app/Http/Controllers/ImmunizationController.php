<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use App\Models\Resident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImmunizationController extends Controller
{
    /**
     * Display a listing of immunization records.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $immunizations = Immunization::query()
            ->with('resident')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('vaccine_name', 'like', "%{$search}%")
                        ->orWhere('vaccine_type', 'like', "%{$search}%")
                        ->orWhere('dose_number', 'like', "%{$search}%")
                        ->orWhereHas('resident', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('middle_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('date_administered')
            ->paginate(10)
            ->withQueryString();

        return view('immunizations.index', [
            'immunizations' => $immunizations,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new immunization record.
     */
    public function create(): View
    {
        $residents = Resident::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('immunizations.create', [
            'residents' => $residents,
        ]);
    }

    /**
     * Store a newly created immunization record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateImmunization($request);

        Immunization::create($validated);

        return redirect()
            ->route('immunizations.index')
            ->with('success', 'Immunization record created successfully.');
    }

    /**
     * Display a specific immunization record.
     */
    public function show(Immunization $immunization): View
    {
        $immunization->load('resident');

        return view('immunizations.show', [
            'immunization' => $immunization,
        ]);
    }

    /**
     * Show the form for editing an immunization record.
     */
    public function edit(Immunization $immunization): View
    {
        $immunization->load('resident');

        $residents = Resident::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('immunizations.edit', [
            'immunization' => $immunization,
            'residents' => $residents,
        ]);
    }

    /**
     * Update an immunization record.
     */
    public function update(
        Request $request,
        Immunization $immunization
    ): RedirectResponse {
        $validated = $this->validateImmunization($request);

        $immunization->update($validated);

        return redirect()
            ->route('immunizations.index')
            ->with('success', 'Immunization record updated successfully.');
    }

    /**
     * Delete an immunization record.
     */
    public function destroy(Immunization $immunization): RedirectResponse
    {
        $immunization->delete();

        return redirect()
            ->route('immunizations.index')
            ->with('success', 'Immunization record deleted successfully.');
    }

    /**
     * Validate immunization data.
     */
    private function validateImmunization(Request $request): array
    {
        return $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
            ],

            'vaccine_name' => [
                'required',
                'string',
                'max:255',
            ],

            'vaccine_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'dose_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'date_administered' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'next_dose_date' => [
                'nullable',
                'date',
                'after_or_equal:date_administered',
            ],

            'batch_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'administered_by' => [
                'nullable',
                'string',
                'max:255',
            ],

            'site_of_administration' => [
                'nullable',
                'string',
                'max:255',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);
    }
}

