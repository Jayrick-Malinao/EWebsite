<?php

namespace App\Http\Controllers;

use App\Models\Household;
use App\Models\Resident;
use App\Rules\AddressFitsStorage;
use App\Rules\PersonName;
use App\Rules\PhilippineMobileNumber;
use App\Services\AuditLogService;
use App\Support\BarangayAddress;
use App\Support\PhilippineMobileNumberFormatter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResidentController extends Controller
{
    /**
     * Display a listing of residents.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'filter' => ['nullable', Rule::in(['senior_age', 'senior_registered', 'pregnant', 'children_18', 'children_5'])],
        ]);

        $search = trim((string) $request->input('search'));
        $filter = (string) $request->input('filter', '');

        $residents = Resident::query()
            ->with('household')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('philhealth_number', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%");
                });
            })
            ->when($filter === 'senior_age', fn ($query) => $query
                ->whereDate('birth_date', '<=', today()->subYearsNoOverflow(60)->toDateString()))
            ->when($filter === 'senior_registered', fn ($query) => $query
                ->whereHas('seniorCitizen', fn ($query) => $query->where('senior_status', 'Active')))
            ->when($filter === 'pregnant', fn ($query) => $query
                ->whereHas('maternalCares', fn ($query) => $query
                    ->where('pregnancy_status', 'Pregnant')
                    ->whereNull('actual_delivery_date')))
            ->when(in_array($filter, ['children_18', 'children_5'], true), fn ($query) => $query
                ->whereDate('birth_date', '>', today()->subYearsNoOverflow($filter === 'children_18' ? 19 : 6)->toDateString())
                ->whereDate('birth_date', '<=', today()->toDateString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('residents.index', compact('residents', 'search', 'filter'));
    }

    /**
     * Show the form for creating a new resident.
     */
    public function create(): View
    {
        $households = Household::query()
            ->orderBy('household_code')
            ->get();

        return view('residents.create', [
            'addressParts' => BarangayAddress::split(null),
            'households' => $households,
            'localityParts' => BarangayAddress::localityParts(),
            'puroks' => BarangayAddress::puroks(),
        ]);
    }

    /**
     * Store a newly created resident.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateResident($request);

        return DB::transaction(function () use ($validated): RedirectResponse {
            /*
             * A household head does not need to select an existing household.
             * A new household will be created automatically for the head.
             */
            if ($validated['is_household_head']) {
                $this->ensureNoExistingHouseholdHead($validated);

                $household = Household::create([
                    'household_code' => $this->generateHouseholdCode(),
                    'household_head_name' => $this->fullNameFromData($validated),
                    'address' => $validated['household_address'],
                    'contact_number' => $validated['contact_number'] ?? null,
                    'status' => 'Active',
                ]);

                $validated['household_id'] = $household->id;
                $validated['relationship_to_head'] = 'Household Head';
            } else {
                /*
                 * A family member MUST belong to an existing household.
                 */
                $household = Household::findOrFail($validated['household_id']);

                $this->ensureHouseholdHasHead($household);
                $validated['contact_number'] = $this->householdHeadContact($household);

                /*
                 * Family members should not be marked as household heads.
                 */
                $validated['is_household_head'] = false;
            }

            $resident = Resident::create($validated);

            /*
             * Keep the household's displayed head name synchronized
             * with the actual resident marked as household head.
             */
            if ($resident->is_household_head) {
                $household->update([
                    'household_head_name' => $resident->full_name,
                    'address' => $resident->household_address,
                    'contact_number' => $resident->contact_number,
                ]);
            }

            /*
             * Record the resident creation after the resident and
             * related household information have been successfully saved.
             */
            AuditLogService::created(
                module: 'Residents',
                model: $resident,
                description: 'Resident created: '.$resident->full_name.'.',
            );

            return redirect()
                ->route('residents.index')
                ->with('success', 'Resident added successfully.');
        });
    }

    /**
     * Display the specified resident.
     */
    public function show(Resident $resident): View
    {
        $resident->load('household');

        return view('residents.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resident.
     */
    public function edit(Resident $resident): View
    {
        $resident->load('household');

        $households = Household::query()
            ->orderBy('household_code')
            ->get();

        return view('residents.edit', [
            'addressParts' => BarangayAddress::split($resident->household_address),
            'households' => $households,
            'localityParts' => BarangayAddress::localityParts(),
            'puroks' => BarangayAddress::puroks(),
            'resident' => $resident,
        ]);
    }

    /**
     * Update the specified resident.
     */
    public function update(
        Request $request,
        Resident $resident
    ): RedirectResponse {
        /*
         * Preserve the resident's original database values before
         * making any changes. These values will be stored in the audit log.
         */
        $oldValues = $resident->getAttributes();

        $validated = $this->validateResident($request, $resident);

        return DB::transaction(function () use ($validated, $resident, $oldValues): RedirectResponse {
            $oldHousehold = $resident->household;

            if ($validated['is_household_head']) {
                /*
                 * The resident is becoming / remaining a household head.
                 */
                $household = $resident->household;

                if ($household && ! empty($validated['household_id']) && (int) $validated['household_id'] !== $household->id) {
                    throw ValidationException::withMessages([
                        'household_id' => 'A household head cannot be moved to another household through this form.',
                    ]);
                }

                if ($household) {
                    $validated['household_id'] = $household->id;
                }

                if (! $household) {
                    $household = Household::create([
                        'household_code' => $this->generateHouseholdCode(),
                        'household_head_name' => $this->fullNameFromData($validated),
                        'address' => $validated['household_address'],
                        'contact_number' => $validated['contact_number'] ?? null,
                        'status' => 'Active',
                    ]);

                    $validated['household_id'] = $household->id;
                }

                $this->ensureNoExistingHouseholdHead(
                    $validated,
                    $resident
                );

                $validated['relationship_to_head'] = 'Household Head';
            } else {
                /*
                 * A family member MUST have a household.
                 */
                if (empty($validated['household_id'])) {
                    return back()
                        ->withErrors([
                            'household_id' => 'Please select a household for this family member.',
                        ])
                        ->withInput();
                }

                $household = Household::findOrFail($validated['household_id']);

                $this->ensureHouseholdHasHead($household, $resident);
                $validated['contact_number'] = $this->householdHeadContact($household, $resident);

                $validated['is_household_head'] = false;
            }

            $resident->update($validated);

            /*
             * Update the household information when its head is changed.
             */
            if ($resident->is_household_head) {
                $household->update([
                    'household_head_name' => $resident->full_name,
                    'address' => $resident->household_address,
                    'contact_number' => $resident->contact_number,
                ]);
                $household->residents()->where('id', '!=', $resident->id)->update([
                    'contact_number' => $resident->contact_number,
                ]);
            }

            /*
             * If the resident moved away from an old household and was its head,
             * the old household should no longer point to that resident.
             */
            if (
                $oldHousehold &&
                $oldHousehold->id !== ($resident->household_id ?? null) &&
                $oldHousehold->residents()
                    ->where('is_household_head', true)
                    ->doesntExist()
            ) {
                $oldHousehold->update([
                    'household_head_name' => null,
                ]);
            }

            /*
             * Refresh the model so the audit log contains the actual
             * values persisted in the database.
             */
            $resident->refresh();

            $newValues = $resident->getAttributes();

            AuditLogService::updated(
                module: 'Residents',
                model: $resident,
                oldValues: $oldValues,
                newValues: $newValues,
                description: 'Resident updated: '.$resident->full_name.'.',
            );

            return redirect()
                ->route('residents.index')
                ->with('success', 'Resident updated successfully.');
        });
    }

    /**
     * Remove the specified resident.
     */
    public function destroy(Resident $resident): RedirectResponse
    {
        /*
         * A household head should not be deleted while family members
         * are still connected to the household.
         */
        if (
            $resident->is_household_head &&
            $resident->household &&
            $resident->household->residents()
                ->where('id', '!=', $resident->id)
                ->exists()
        ) {
            return back()->with(
                'error',
                'This household head cannot be deleted while family members are still connected to the household.'
            );
        }

        /*
         * Preserve the resident's information before deletion so the
         * audit record remains useful even after the database record
         * no longer exists.
         */
        $oldValues = $resident->getAttributes();
        $residentName = $resident->full_name;

        $household = $resident->household;
        $wasHead = $resident->is_household_head;

        $resident->delete();

        /*
         * If the deleted resident was the household head and there are
         * no remaining residents, remove the empty household.
         */
        if (
            $wasHead &&
            $household &&
            ! $household->residents()->exists()
        ) {
            $household->delete();
        }

        /*
         * Record the deletion after the resident has been successfully
         * removed from the database.
         */
        AuditLogService::deleted(
            module: 'Residents',
            model: $resident,
            description: 'Resident deleted: '.$residentName.'.',
            oldValues: $oldValues,
        );

        return redirect()
            ->route('residents.index')
            ->with('success', 'Resident deleted successfully.');
    }

    /**
     * Validate resident data.
     */
    private function validateResident(
        Request $request,
        ?Resident $resident = null
    ): array {
        $isHouseholdHead = $request->boolean('is_household_head');

        $validated = $request->validate([
            'household_id' => [
                Rule::requiredIf(! $isHouseholdHead),
                'nullable',
                'integer',
                'exists:households,id',
            ],

            'is_household_head' => [
                'required',
                'boolean',
            ],

            'relationship_to_head' => [
                Rule::requiredIf(! $isHouseholdHead),
                'nullable',
                Rule::in([
                    'Spouse',
                    'Son',
                    'Daughter',
                    'Father',
                    'Mother',
                    'Brother',
                    'Sister',
                    'Grandfather',
                    'Grandmother',
                    'Grandchild',
                    'Other Relative',
                    'Non-Relative',
                ]),
            ],

            'first_name' => [
                'required',
                'string',
                'max:100',
                new PersonName($resident !== null),
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:100',
                new PersonName($resident !== null),
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
                new PersonName($resident !== null),
            ],

            'suffix' => [
                'nullable',
                Rule::in($resident ? ['Jr.', 'Sr.', 'II', 'III', 'IV', 'V'] : ['Jr.', 'Sr.']),
            ],

            'birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'gender' => [
                'required',
                'in:Male,Female',
            ],

            'contact_number' => [
                Rule::excludeIf(! $isHouseholdHead),
                'required',
                'string',
                'max:13',
                new PhilippineMobileNumber($resident ? null : $request),
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'household_address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'purok' => [
                'required',
                'string',
                Rule::in(BarangayAddress::puroks()),
                new AddressFitsStorage,
            ],

            'civil_status' => [
                'required',
                'in:Single,Married,Widowed,Separated,Divorced',
            ],

            'philhealth_number' => [
                'nullable',
                'string',
                'max:50',
                'regex:/\A[0-9]+\z/',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ], [
            'philhealth_number.regex' => 'The PhilHealth number must contain digits only.',
        ]);

        $validated['household_address'] = BarangayAddress::format(
            $validated['purok'],
        );
        unset($validated['purok']);

        return $validated;
    }

    private function householdHeadContact(Household $household, ?Resident $resident = null): string
    {
        $head = $household->residents()
            ->where('is_household_head', true)
            ->when($resident, fn ($query) => $query->where('id', '!=', $resident->id))
            ->first();
        $number = PhilippineMobileNumberFormatter::normalize(trim((string) $head?->contact_number));

        if (! PhilippineMobileNumberFormatter::isValid($number)) {
            throw ValidationException::withMessages([
                'household_id' => 'The household head must have a valid contact number before adding or updating members.',
            ]);
        }

        return $number;
    }

    /**
     * Ensure another resident is not already the household head.
     */
    private function ensureNoExistingHouseholdHead(
        array $validated,
        ?Resident $resident = null
    ): void {
        if (empty($validated['household_id'])) {
            return;
        }

        $query = Resident::query()
            ->where('household_id', $validated['household_id'])
            ->where('is_household_head', true);

        if ($resident) {
            $query->where('id', '!=', $resident->id);
        }

        if ($query->exists()) {
            abort(
                422,
                'This household already has a household head.'
            );
        }
    }

    /**
     * Ensure a household has a household head.
     */
    private function ensureHouseholdHasHead(
        Household $household,
        ?Resident $currentResident = null
    ): void {
        $query = $household->residents()
            ->where('is_household_head', true);

        if ($currentResident) {
            $query->where('id', '!=', $currentResident->id);
        }

        /*
         * This check is intentionally not enforced when editing a resident
         * into a family member if another valid head exists.
         */
        if (! $query->exists()) {
            abort(
                422,
                'This household does not have a household head.'
            );
        }
    }

    /**
     * Generate a unique household code.
     */
    private function generateHouseholdCode(): string
    {
        do {
            $code = 'HH-'.now()->format('Y').'-'.strtoupper(
                substr(uniqid(), -6)
            );
        } while (
            Household::query()
                ->where('household_code', $code)
                ->exists()
        );

        return $code;
    }

    /**
     * Build a resident's full name from validated data.
     */
    private function fullNameFromData(array $data): string
    {
        return collect([
            $data['first_name'] ?? null,
            $data['middle_name'] ?? null,
            $data['last_name'] ?? null,
            $data['suffix'] ?? null,
        ])
            ->filter()
            ->implode(' ');
    }
}
