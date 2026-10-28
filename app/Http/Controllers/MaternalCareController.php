<?php

namespace App\Http\Controllers;

use App\Models\MaternalCare;
use App\Models\Resident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaternalCareController extends Controller
{
    /**
     * Display a listing of maternal care records.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim((string) $request->input('search'));

        $maternalCares = MaternalCare::query()
            ->with('resident')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('pregnancy_status', 'like', "%{$search}%")
                        ->orWhere('delivery_type', 'like', "%{$search}%")
                        ->orWhere('place_of_delivery', 'like', "%{$search}%")
                        ->orWhereHas('resident', function ($residentQuery) use ($search) {
                            $residentQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('middle_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('maternal-care.index', compact(
            'maternalCares',
            'search'
        ));
    }

    /**
     * Show the form for creating a new maternal care record.
     */
    public function create(): View
    {
        $residents = Resident::query()
            ->where('gender', 'Female')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('maternal-care.create', compact('residents'));
    }

    /**
     * Store a newly created maternal care record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
            ],

            'last_menstrual_period' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'expected_delivery_date' => [
                'nullable',
                'date',
                'after_or_equal:last_menstrual_period',
            ],

            'actual_delivery_date' => [
                'nullable',
                'date',
                'after_or_equal:last_menstrual_period',
                'before_or_equal:today',
            ],

            'pregnancy_status' => [
                'required',
                'in:Pregnant,Delivered,Miscarriage,Stillbirth,Completed',
            ],

            'last_prenatal_visit' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'prenatal_visit_count' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'delivery_type' => [
                'nullable',
                'in:Normal,Cesarean Section,Assisted',
            ],

            'place_of_delivery' => [
                'nullable',
                'string',
                'max:255',
            ],

            'birth_outcome' => [
                'nullable',
                'in:Live Birth,Stillbirth,Miscarriage',
            ],

            'pregnancy_risk_factors' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'medical_conditions' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'medications' => [
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

        /*
        |--------------------------------------------------------------------------
        | Automatically Generate Pregnancy Number
        |--------------------------------------------------------------------------
        |
        | Pregnancy numbers are sequential for each resident.
        |
        | Example:
        | Resident #5:
        |   Pregnancy #1
        |   Pregnancy #2
        |   Pregnancy #3
        |
        */

        $lastPregnancyNumber = MaternalCare::query()
            ->where('resident_id', $validated['resident_id'])
            ->max('pregnancy_number');

        $validated['pregnancy_number'] = ((int) $lastPregnancyNumber) + 1;

        $maternalCare = MaternalCare::create($validated);

        return redirect()
            ->route('maternal-care.show', $maternalCare)
            ->with('success', 'Maternal care record created successfully.');
    }

    /**
     * Display the specified maternal care record.
     */
    public function show(MaternalCare $maternalCare): View
    {
        $maternalCare->load('resident');

        return view('maternal-care.show', compact('maternalCare'));
    }

    /**
     * Show the form for editing the specified maternal care record.
     */
    public function edit(MaternalCare $maternalCare): View
    {
        $residents = Resident::query()
            ->where(function ($query) use ($maternalCare) {
                $query
                    ->where('gender', 'Female')
                    ->orWhere('id', $maternalCare->resident_id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('maternal-care.edit', compact(
            'maternalCare',
            'residents'
        ));
    }

    /**
     * Update the specified maternal care record.
     */
    public function update(
        Request $request,
        MaternalCare $maternalCare
    ): RedirectResponse {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'integer',
                'exists:residents,id',
            ],

            'last_menstrual_period' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'expected_delivery_date' => [
                'nullable',
                'date',
                'after_or_equal:last_menstrual_period',
            ],

            'actual_delivery_date' => [
                'nullable',
                'date',
                'after_or_equal:last_menstrual_period',
                'before_or_equal:today',
            ],

            'pregnancy_status' => [
                'required',
                'in:Pregnant,Delivered,Miscarriage,Stillbirth,Completed',
            ],

            'last_prenatal_visit' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'prenatal_visit_count' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'delivery_type' => [
                'nullable',
                'in:Normal,Cesarean Section,Assisted',
            ],

            'place_of_delivery' => [
                'nullable',
                'string',
                'max:255',
            ],

            'birth_outcome' => [
                'nullable',
                'in:Live Birth,Stillbirth,Miscarriage',
            ],

            'pregnancy_risk_factors' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'medical_conditions' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'medications' => [
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

        /*
        |--------------------------------------------------------------------------
        | Keep Existing Pregnancy Number
        |--------------------------------------------------------------------------
        |
        | Editing a record must NOT change its pregnancy number.
        |
        */

        $validated['pregnancy_number'] = $maternalCare->pregnancy_number;

        $maternalCare->update($validated);

        return redirect()
            ->route('maternal-care.show', $maternalCare)
            ->with('success', 'Maternal care record updated successfully.');
    }

    /**
     * Remove the specified maternal care record.
     */
    public function destroy(MaternalCare $maternalCare): RedirectResponse
    {
        $maternalCare->delete();

        return redirect()
            ->route('maternal-care.index')
            ->with('success', 'Maternal care record deleted successfully.');
    }
}
