<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use App\Models\Resident;
use App\Rules\PersonName;
use App\Rules\PhilippineMobileNumber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HealthRecordController extends Controller
{
    /**
     * Display a listing of health records.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = $request->string('search')->trim()->toString();

        $healthRecords = HealthRecord::query()
            ->with('resident')
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('resident', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('philhealth_number', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('health-records.index', [
            'healthRecords' => $healthRecords,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a health record.
     */
    public function create(): View
    {
        /*
         * Only residents without an existing health record
         * can be selected for a new health record.
         */
        $residents = Resident::query()
            ->whereDoesntHave('healthRecord')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('health-records.create', [
            'residents' => $residents,
        ]);
    }

    /**
     * Store a newly created health record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateHealthRecord($request);

        /*
         * Protect against creating a second health record
         * for the same resident.
         */
        if (
            HealthRecord::query()
                ->where('resident_id', $validated['resident_id'])
                ->exists()
        ) {
            return back()
                ->withErrors([
                    'resident_id' => 'This resident already has a health record.',
                ])
                ->withInput();
        }

        HealthRecord::create($validated);

        return redirect()
            ->route('health-records.index')
            ->with('success', 'Health record created successfully.');
    }

    /**
     * Display a specific health record.
     */
    public function show(HealthRecord $healthRecord): View
    {
        $healthRecord->load('resident');

        return view('health-records.show', [
            'healthRecord' => $healthRecord,
        ]);
    }

    /**
     * Show the form for editing a health record.
     */
    public function edit(HealthRecord $healthRecord): View
    {
        $healthRecord->load('resident');

        $residents = Resident::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('health-records.edit', [
            'healthRecord' => $healthRecord,
            'residents' => $residents,
        ]);
    }

    /**
     * Update a health record.
     */
    public function update(
        Request $request,
        HealthRecord $healthRecord
    ): RedirectResponse {
        $validated = $this->validateHealthRecord(
            $request,
            $healthRecord
        );

        /*
         * The unique resident_id rule ensures that another
         * health record cannot be assigned to the same resident.
         */
        $healthRecord->update($validated);

        return redirect()
            ->route('health-records.index')
            ->with('success', 'Health record updated successfully.');
    }

    /**
     * Delete a health record.
     */
    public function destroy(HealthRecord $healthRecord): RedirectResponse
    {
        $healthRecord->delete();

        return redirect()
            ->route('health-records.index')
            ->with('success', 'Health record deleted successfully.');
    }

    /**
     * Validate health record data.
     */
    private function validateHealthRecord(
        Request $request,
        ?HealthRecord $healthRecord = null
    ): array {
        return $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
                Rule::unique('health_records', 'resident_id')
                    ->ignore($healthRecord?->id),
            ],

            'blood_type' => [
                'nullable',
                Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            ],

            'allergies' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'chronic_conditions' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'medical_history' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'current_medications' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'disabilities' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'family_medical_history' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:255',
                new PersonName,
            ],

            'emergency_contact_number' => [
                'nullable',
                'string',
                'max:13',
                new PhilippineMobileNumber,
            ],

            'emergency_contact_relationship' => [
                'nullable',
                'string',
                'max:100',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);
    }
}
