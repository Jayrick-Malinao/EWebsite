<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementSmsDelivery;
use App\Models\Household;
use App\Models\Resident;
use App\Rules\AddressFitsStorage;
use App\Rules\PersonName;
use App\Rules\PhilippineMobileNumber;
use App\Support\BarangayAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HouseholdController extends Controller
{
    /**
     * Display all households.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = $request->string('search')->trim()->toString();

        $households = Household::query()
            ->withCount('residents')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where(
                        'household_code',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'household_head_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'address',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'contact_number',
                            'like',
                            "%{$search}%"
                        );
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('households.index', [
            'households' => $households,
            'search' => $search,
        ]);
    }

    /**
     * Show the create household form.
     */
    public function create(): View
    {
        return view('households.create', [
            'addressParts' => BarangayAddress::split(null),
            'localityParts' => BarangayAddress::localityParts(),
            'puroks' => BarangayAddress::puroks(),
        ]);
    }

    /**
     * Store a new household with its household head
     * and family members.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Household Information
            |--------------------------------------------------------------------------
            */
            'address' => [
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

            'status' => [
                'required',
                'in:Active,Inactive',
            ],

            /*
            |--------------------------------------------------------------------------
            | Household Head
            |--------------------------------------------------------------------------
            */
            'household_head' => [
                'required',
                'array',
            ],

            'household_head.first_name' => [
                'required',
                'string',
                'max:255',
                new PersonName(false),
            ],

            'household_head.middle_name' => [
                'nullable',
                'string',
                'max:255',
                new PersonName(false),
            ],

            'household_head.last_name' => [
                'required',
                'string',
                'max:255',
                new PersonName(false),
            ],

            'household_head.suffix' => [
                'nullable',
                Rule::in(['Jr.', 'Sr.']),
            ],

            'household_head.birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'household_head.gender' => [
                'required',
                'in:Male,Female',
            ],

            'household_head.contact_number' => [
                'required',
                'string',
                'max:13',
                new PhilippineMobileNumber($request),
            ],

            'household_head.email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'household_head.civil_status' => [
                'required',
                'in:Single,Married,Widowed,Separated,Divorced',
            ],

            'household_head.philhealth_number' => [
                'nullable',
                'string',
                'max:255',
                'regex:/\A[0-9]+\z/',
            ],

            /*
            |--------------------------------------------------------------------------
            | Family Members
            |--------------------------------------------------------------------------
            */
            'members' => [
                'nullable',
                'array',
            ],

            'members.*.first_name' => [
                'required',
                'string',
                'max:255',
                new PersonName(false),
            ],

            'members.*.middle_name' => [
                'nullable',
                'string',
                'max:255',
                new PersonName(false),
            ],

            'members.*.last_name' => [
                'required',
                'string',
                'max:255',
                new PersonName(false),
            ],

            'members.*.suffix' => [
                'nullable',
                Rule::in(['Jr.', 'Sr.']),
            ],

            'members.*.relationship_to_head' => [
                'required',
                Rule::in([
                    'Son',
                    'Daughter',
                    'Wife',
                    'Husband',
                    'Mother',
                    'Father',
                    'Grandmother',
                    'Grandfather',
                    'Sister',
                    'Brother',
                    'Grandchild',
                    'Other Relative',
                    'Other',
                ]),
            ],

            'members.*.birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'members.*.gender' => [
                'required',
                'in:Male,Female',
            ],

            'members.*.status' => [
                'sometimes',
                'required',
                Rule::in(['Active', 'Inactive']),
            ],

            'members.*.email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'members.*.purok' => [
                'required',
                'string',
                Rule::in(BarangayAddress::puroks()),
                new AddressFitsStorage,
            ],

            'members.*.civil_status' => [
                'required',
                'in:Single,Married,Widowed,Separated,Divorced',
            ],

            'members.*.philhealth_number' => [
                'nullable',
                'string',
                'max:255',
                'regex:/\A[0-9]+\z/',
            ],
        ], [
            'household_head.philhealth_number.regex' => 'The household head PhilHealth number must contain digits only.',
            'members.*.philhealth_number.regex' => 'The family member PhilHealth number must contain digits only.',
        ]);

        $validated['address'] = BarangayAddress::format(
            $validated['purok'],
        );
        unset($validated['purok']);

        DB::transaction(function () use ($validated) {
            /*
            |--------------------------------------------------------------------------
            | Generate Household Code
            |--------------------------------------------------------------------------
            */
            $householdCode = $this->generateHouseholdCode();

            $head = $validated['household_head'];

            /*
            |--------------------------------------------------------------------------
            | Build Household Head Name
            |--------------------------------------------------------------------------
            */
            $headName = $this->buildFullName(
                $head['first_name'],
                $head['middle_name'] ?? null,
                $head['last_name'],
                $head['suffix'] ?? null
            );

            /*
            |--------------------------------------------------------------------------
            | Create Household
            |--------------------------------------------------------------------------
            */
            $household = Household::create([
                'household_code' => $householdCode,
                'household_head_name' => $headName,
                'address' => $validated['address'],
                'contact_number' => $head['contact_number'],
                'status' => $validated['status'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Household Head
            |--------------------------------------------------------------------------
            */
            Resident::create([
                'household_id' => $household->id,
                'is_household_head' => true,
                'relationship_to_head' => null,
                'first_name' => $head['first_name'],
                'middle_name' => $head['middle_name'] ?? null,
                'last_name' => $head['last_name'],
                'suffix' => $head['suffix'] ?? null,
                'birth_date' => $head['birth_date'],
                'gender' => $head['gender'],
                'contact_number' => $head['contact_number'] ?? null,
                'email' => $head['email'] ?? null,
                'household_address' => $validated['address'],
                'civil_status' => $head['civil_status'],
                'philhealth_number' => $head['philhealth_number'] ?? null,
                'status' => 'Active',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Family Members
            |--------------------------------------------------------------------------
            */
            foreach ($validated['members'] ?? [] as $member) {
                Resident::create([
                    'household_id' => $household->id,
                    'is_household_head' => false,

                    // Save exactly what the user selected.
                    'relationship_to_head' => $member['relationship_to_head'],

                    'first_name' => $member['first_name'],
                    'middle_name' => $member['middle_name'] ?? null,
                    'last_name' => $member['last_name'],
                    'suffix' => $member['suffix'] ?? null,
                    'birth_date' => $member['birth_date'],
                    'gender' => $member['gender'],
                    'contact_number' => $head['contact_number'],
                    'email' => $member['email'] ?? null,
                    'household_address' => BarangayAddress::format($member['purok']),
                    'civil_status' => $member['civil_status'],
                    'philhealth_number' => $member['philhealth_number'] ?? null,
                    'status' => $member['status'] ?? 'Active',
                ]);
            }
        });

        return redirect()
            ->route('households.index')
            ->with(
                'success',
                'Household and family members registered successfully.'
            );
    }

    /**
     * Display a household and all its residents.
     */
    public function show(Household $household): View
    {
        $household->load('residents');

        return view('households.show', [
            'household' => $household,
        ]);
    }

    /**
     * Show the edit household form with
     * household head and family members.
     */
    public function edit(Household $household): View
    {
        $household->load('residents');

        $householdHead = $household->residents
            ->firstWhere('is_household_head', true);

        $familyMembers = $household->residents
            ->where('is_household_head', false)
            ->values();
        $memberAddressParts = $familyMembers
            ->mapWithKeys(fn (Resident $member): array => [
                $member->id => BarangayAddress::split($member->household_address),
            ])
            ->all();

        return view('households.edit', [
            'addressParts' => BarangayAddress::split($household->address),
            'household' => $household,
            'head' => $householdHead,
            'localityParts' => BarangayAddress::localityParts(),
            'memberAddressParts' => $memberAddressParts,
            'members' => $familyMembers,
            'puroks' => BarangayAddress::puroks(),
        ]);
    }

    /**
     * Update household, household head,
     * and family members.
     */
    public function update(
        Request $request,
        Household $household
    ): RedirectResponse {
        $memberNameRule = function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
            $memberIndex = explode('.', $attribute)[1];
            $existingMemberId = $request->input("members.$memberIndex.id");
            (new PersonName($existingMemberId !== null))->validate($attribute, $value, $fail);
        };

        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Household Information
            |--------------------------------------------------------------------------
            */
            'household_code' => [
                'required',
                'string',
                'max:255',
                'unique:households,household_code,'.$household->id,
            ],

            'address' => [
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

            'status' => [
                'required',
                'in:Active,Inactive',
            ],

            /*
            |--------------------------------------------------------------------------
            | Household Head
            |--------------------------------------------------------------------------
            */
            'household_head' => [
                'required',
                'array',
            ],

            'household_head.id' => [
                'required',
                'integer',
            ],

            'household_head.first_name' => [
                'required',
                'string',
                'max:255',
                new PersonName,
            ],

            'household_head.middle_name' => [
                'nullable',
                'string',
                'max:255',
                new PersonName,
            ],

            'household_head.last_name' => [
                'required',
                'string',
                'max:255',
                new PersonName,
            ],

            'household_head.suffix' => [
                'nullable',
                'string',
                'max:50',
            ],

            'household_head.birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'household_head.gender' => [
                'required',
                'in:Male,Female',
            ],

            'household_head.contact_number' => [
                'required',
                'string',
                'max:13',
                new PhilippineMobileNumber,
            ],

            'household_head.email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'household_head.civil_status' => [
                'required',
                'in:Single,Married,Widowed,Separated,Divorced',
            ],

            'household_head.philhealth_number' => [
                'nullable',
                'string',
                'max:255',
                'regex:/\A[0-9]+\z/',
            ],

            /*
            |--------------------------------------------------------------------------
            | Family Members
            |--------------------------------------------------------------------------
            */
            'members' => [
                'nullable',
                'array',
            ],

            'members.*.id' => [
                'nullable',
                'integer',
            ],

            'members.*.first_name' => [
                'required',
                'string',
                'max:255',
                $memberNameRule,
            ],

            'members.*.middle_name' => [
                'nullable',
                'string',
                'max:255',
                $memberNameRule,
            ],

            'members.*.last_name' => [
                'required',
                'string',
                'max:255',
                $memberNameRule,
            ],

            'members.*.suffix' => [
                'nullable',
                'string',
                'max:50',
                function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                    $memberIndex = explode('.', $attribute)[1];
                    if ($request->input("members.$memberIndex.id") === null && ! in_array($value, ['Jr.', 'Sr.'], true)) {
                        $fail('The :attribute must be Jr. or Sr.');
                    }
                },
            ],

            'members.*.relationship_to_head' => [
                'required',
                Rule::in([
                    'Son',
                    'Daughter',
                    'Wife',
                    'Husband',
                    'Mother',
                    'Father',
                    'Grandmother',
                    'Grandfather',
                    'Sister',
                    'Brother',
                    'Grandchild',
                    'Other Relative',
                    'Other',
                ]),
            ],

            'members.*.birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'members.*.gender' => [
                'required',
                'in:Male,Female',
            ],

            'members.*.status' => [
                'sometimes',
                'required',
                Rule::in(['Active', 'Inactive']),
            ],

            'members.*.email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'members.*.purok' => [
                'required',
                'string',
                Rule::in(BarangayAddress::puroks()),
                new AddressFitsStorage,
            ],

            'members.*.civil_status' => [
                'required',
                'in:Single,Married,Widowed,Separated,Divorced',
            ],

            'members.*.philhealth_number' => [
                'nullable',
                'string',
                'max:255',
                'regex:/\A[0-9]+\z/',
            ],
        ], [
            'household_head.philhealth_number.regex' => 'The household head PhilHealth number must contain digits only.',
            'members.*.philhealth_number.regex' => 'The family member PhilHealth number must contain digits only.',
        ]);

        $validated['address'] = BarangayAddress::format(
            $validated['purok'],
        );
        unset($validated['purok']);

        DB::transaction(function () use (
            $validated,
            $household
        ) {
            /*
            |--------------------------------------------------------------------------
            | Find Household Head
            |--------------------------------------------------------------------------
            */
            $householdHead = $household->residents()
                ->where('is_household_head', true)
                ->first();

            if (! $householdHead) {
                throw new \RuntimeException(
                    'Household head record could not be found.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Rebuild Household Head Name
            |--------------------------------------------------------------------------
            */
            $head = $validated['household_head'];

            $headName = $this->buildFullName(
                $head['first_name'],
                $head['middle_name'] ?? null,
                $head['last_name'],
                $head['suffix'] ?? null
            );

            /*
            |--------------------------------------------------------------------------
            | Update Household
            |--------------------------------------------------------------------------
            */
            $household->update([
                'household_code' => $validated['household_code'],
                'household_head_name' => $headName,
                'address' => $validated['address'],
                'contact_number' => $head['contact_number'],
                'status' => $validated['status'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Household Head Resident
            |--------------------------------------------------------------------------
            */
            $householdHead->update([
                'first_name' => $head['first_name'],
                'middle_name' => $head['middle_name'] ?? null,
                'last_name' => $head['last_name'],
                'suffix' => $head['suffix'] ?? null,
                'birth_date' => $head['birth_date'],
                'gender' => $head['gender'],
                'contact_number' => $head['contact_number'] ?? null,
                'email' => $head['email'] ?? null,
                'household_address' => $validated['address'],
                'civil_status' => $head['civil_status'],
                'philhealth_number' => $head['philhealth_number'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Existing Family Member IDs
            |--------------------------------------------------------------------------
            */
            $submittedMemberIds = collect(
                $validated['members'] ?? []
            )
                ->pluck('id')
                ->filter()
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all();

            /*
            |--------------------------------------------------------------------------
            | Remove Members Deleted From The Edit Form
            |--------------------------------------------------------------------------
            */
            $household->residents()
                ->where('is_household_head', false)
                ->whereNotIn('id', $submittedMemberIds)
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | Update Existing Members / Create New Members
            |--------------------------------------------------------------------------
            */
            foreach ($validated['members'] ?? [] as $member) {
                $memberId = ! empty($member['id'])
                    ? (int) $member['id']
                    : null;

                /*
                |--------------------------------------------------------------------------
                | Update Existing Family Member
                |--------------------------------------------------------------------------
                */
                if ($memberId) {
                    $resident = $household->residents()
                        ->where('is_household_head', false)
                        ->where('id', $memberId)
                        ->first();

                    if (! $resident) {
                        throw new \RuntimeException(
                            'One of the selected family members does not belong to this household.'
                        );
                    }

                    $resident->update([
                        /*
                        | Save exactly what the user selected.
                        */
                        'relationship_to_head' => $member['relationship_to_head'],

                        'first_name' => $member['first_name'],
                        'middle_name' => $member['middle_name'] ?? null,
                        'last_name' => $member['last_name'],
                        'suffix' => $member['suffix'] ?? null,
                        'birth_date' => $member['birth_date'],
                        'gender' => $member['gender'],
                        'contact_number' => $head['contact_number'],
                        'email' => $member['email'] ?? null,
                        'household_address' => BarangayAddress::format($member['purok']),
                        'civil_status' => $member['civil_status'],
                        'philhealth_number' => $member['philhealth_number'] ?? null,
                        'status' => $member['status'] ?? $resident->status,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Create New Family Member
                |--------------------------------------------------------------------------
                */
                else {
                    Resident::create([
                        'household_id' => $household->id,
                        'is_household_head' => false,

                        /*
                        | Save exactly what the user selected.
                        */
                        'relationship_to_head' => $member['relationship_to_head'],

                        'first_name' => $member['first_name'],
                        'middle_name' => $member['middle_name'] ?? null,
                        'last_name' => $member['last_name'],
                        'suffix' => $member['suffix'] ?? null,
                        'birth_date' => $member['birth_date'],
                        'gender' => $member['gender'],
                        'contact_number' => $head['contact_number'],
                        'email' => $member['email'] ?? null,
                        'household_address' => BarangayAddress::format($member['purok']),
                        'civil_status' => $member['civil_status'],
                        'philhealth_number' => $member['philhealth_number'] ?? null,
                        'status' => $member['status'] ?? 'Active',
                    ]);
                }
            }
        });

        return redirect()
            ->route('households.show', $household)
            ->with(
                'success',
                'Household and family members updated successfully.'
            );
    }

    /**
     * Delete a household.
     */
    public function destroy(Household $household): RedirectResponse
    {
        $deleted = DB::transaction(function () use ($household): bool {
            $hasOtherHouseholdDeliveries = AnnouncementSmsDelivery::query()
                ->where('household_id', '!=', $household->id)
                ->whereIn('household_head_resident_id', $household->residents()->select('id'))
                ->exists();

            if ($hasOtherHouseholdDeliveries) {
                return false;
            }

            $household->announcementSmsDeliveries()->delete();
            $household->residents()->delete();
            $household->delete();

            return true;
        });

        if (! $deleted) {
            return redirect()
                ->route('households.index')
                ->with('error', 'This household cannot be deleted because one of its residents is referenced by an SMS delivery for another household.');
        }

        return redirect()
            ->route('households.index')
            ->with(
                'success',
                'Household deleted successfully.'
            );
    }

    /**
     * Build a resident's complete name.
     */
    private function buildFullName(
        string $firstName,
        ?string $middleName,
        string $lastName,
        ?string $suffix
    ): string {
        $name = trim(
            $firstName.' '.
            ($middleName ?? '').' '.
            $lastName
        );

        if (! empty($suffix)) {
            $name .= ', '.$suffix;
        }

        return $name;
    }

    /**
     * Generate the next household code.
     */
    private function generateHouseholdCode(): string
    {
        $lastHousehold = Household::query()
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastHousehold
            ? $lastHousehold->id + 1
            : 1;

        do {
            $code = 'HH-'.str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );

            $nextNumber++;
        } while (
            Household::where('household_code', $code)->exists()
        );

        return $code;
    }
}
