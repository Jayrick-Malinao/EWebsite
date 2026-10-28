<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\SeniorCitizen;
use App\Rules\PhilippineMobileNumber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeniorCitizenController extends Controller
{
    /**
     * Display a listing of senior citizen records.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim((string) $request->input('search'));

        $seniorCitizens = SeniorCitizen::query()
            ->with('resident')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('osca_id_number', 'like', "%{$search}%")
                        ->orWhere('classification', 'like', "%{$search}%")
                        ->orWhere('senior_status', 'like', "%{$search}%")
                        ->orWhereHas('resident', function ($residentQuery) use ($search) {
                            $residentQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('middle_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('contact_number', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('senior-citizens.index', compact(
            'seniorCitizens',
            'search'
        ));
    }

    /**
     * Show the form for creating a new Senior Citizen record.
     */
    public function create(): View
    {
        /*
         * Only residents who do not already have a Senior Citizen
         * record are available for selection.
         */
        $residents = Resident::query()
            ->whereDoesntHave('seniorCitizen')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('senior-citizens.create', compact('residents'));
    }

    /**
     * Store a newly created Senior Citizen record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
                'unique:senior_citizens,resident_id',
            ],

            'osca_id_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:senior_citizens,osca_id_number',
            ],

            'osca_registration_date' => [
                'nullable',
                'date',
            ],

            'senior_status' => [
                'required',
                'in:Active,Inactive,Deceased,Transferred',
            ],

            'classification' => [
                'nullable',
                'string',
                'max:100',
            ],

            'blood_type' => [
                'nullable',
                'in:A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown',
            ],

            'medical_conditions' => [
                'nullable',
                'string',
            ],

            'maintenance_medications' => [
                'nullable',
                'string',
            ],

            'disabilities' => [
                'nullable',
                'string',
            ],

            'living_arrangement' => [
                'nullable',
                'in:Living Alone,With Spouse,With Family,With Caregiver',
            ],

            'primary_caregiver' => [
                'nullable',
                'string',
                'max:150',
            ],

            'caregiver_contact' => [
                'nullable',
                'string',
                'max:13',
                new PhilippineMobileNumber,
            ],

            'receives_social_pension' => [
                'nullable',
                'boolean',
            ],

            'receives_health_assistance' => [
                'nullable',
                'boolean',
            ],

            'receives_other_benefits' => [
                'nullable',
                'boolean',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        /*
         * Checkbox values are normalized so unchecked boxes
         * are stored as false instead of null.
         */
        $validated['receives_social_pension'] =
            $request->boolean('receives_social_pension');

        $validated['receives_health_assistance'] =
            $request->boolean('receives_health_assistance');

        $validated['receives_other_benefits'] =
            $request->boolean('receives_other_benefits');

        SeniorCitizen::create($validated);

        return redirect()
            ->route('senior-citizens.index')
            ->with('success', 'Senior Citizen record added successfully.');
    }

    /**
     * Display the specified Senior Citizen record.
     */
    public function show(SeniorCitizen $seniorCitizen): View
    {
        $seniorCitizen->load('resident');

        return view('senior-citizens.show', compact('seniorCitizen'));
    }

    /**
     * Show the form for editing the specified Senior Citizen record.
     */
    public function edit(SeniorCitizen $seniorCitizen): View
    {
        $seniorCitizen->load('resident');

        return view('senior-citizens.edit', compact('seniorCitizen'));
    }

    /**
     * Update the specified Senior Citizen record.
     */
    public function update(
        Request $request,
        SeniorCitizen $seniorCitizen
    ): RedirectResponse {
        $validated = $request->validate([
            /*
             * The resident connection is intentionally preserved.
             * We do not allow an existing Senior Citizen record
             * to be transferred to another resident during editing.
             */
            'osca_id_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:senior_citizens,osca_id_number,'.
                    $seniorCitizen->id,
            ],

            'osca_registration_date' => [
                'nullable',
                'date',
            ],

            'senior_status' => [
                'required',
                'in:Active,Inactive,Deceased,Transferred',
            ],

            'classification' => [
                'nullable',
                'string',
                'max:100',
            ],

            'blood_type' => [
                'nullable',
                'in:A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown',
            ],

            'medical_conditions' => [
                'nullable',
                'string',
            ],

            'maintenance_medications' => [
                'nullable',
                'string',
            ],

            'disabilities' => [
                'nullable',
                'string',
            ],

            'living_arrangement' => [
                'nullable',
                'in:Living Alone,With Spouse,With Family,With Caregiver',
            ],

            'primary_caregiver' => [
                'nullable',
                'string',
                'max:150',
            ],

            'caregiver_contact' => [
                'nullable',
                'string',
                'max:13',
                new PhilippineMobileNumber,
            ],

            'receives_social_pension' => [
                'nullable',
                'boolean',
            ],

            'receives_health_assistance' => [
                'nullable',
                'boolean',
            ],

            'receives_other_benefits' => [
                'nullable',
                'boolean',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        $validated['receives_social_pension'] =
            $request->boolean('receives_social_pension');

        $validated['receives_health_assistance'] =
            $request->boolean('receives_health_assistance');

        $validated['receives_other_benefits'] =
            $request->boolean('receives_other_benefits');

        $seniorCitizen->update($validated);

        return redirect()
            ->route('senior-citizens.show', $seniorCitizen)
            ->with('success', 'Senior Citizen record updated successfully.');
    }

    /**
     * Remove the specified Senior Citizen record.
     */
    public function destroy(SeniorCitizen $seniorCitizen): RedirectResponse
    {
        $seniorCitizen->delete();

        return redirect()
            ->route('senior-citizens.index')
            ->with('success', 'Senior Citizen record deleted successfully.');
    }
}
