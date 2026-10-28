<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CertificateController extends Controller
{
    /**
     * Display all certificates.
     */
    public function index()
    {
        $certificates = Certificate::with([
            'resident',
            'issuer',
        ])
            ->latest('date_issued')
            ->latest('id')
            ->paginate(15);

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Show the certificate creation form.
     */
    public function create()
    {
        $residents = Resident::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $certificateTypes = [
            'Certificate of Residency',
            'Certificate of Indigency',
            'Barangay Clearance',
            'Certificate of Good Moral Character',
            'Medical Certificate',
            'Health Certificate',
            'Medical Examination Certificate',
            'Fitness to Work Certificate',
            'Fitness to Attend School Certificate',
            'Vaccination / Immunization Certificate',
        ];

        return view('certificates.create', compact(
            'residents',
            'certificateTypes'
        ));
    }

    /**
     * Store a newly issued certificate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'exists:residents,id',
            ],

            'certificate_type' => [
                'required',
                Rule::in([
                    'Certificate of Residency',
                    'Certificate of Indigency',
                    'Barangay Clearance',
                    'Certificate of Good Moral Character',
                    'Medical Certificate',
                    'Health Certificate',
                    'Medical Examination Certificate',
                    'Fitness to Work Certificate',
                    'Fitness to Attend School Certificate',
                    'Vaccination / Immunization Certificate',
                ]),
            ],

            'purpose' => [
                'nullable',
                'string',
                'max:500',
            ],

            'date_issued' => [
                'required',
                'date',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $validated['certificate_number'] = $this->generateCertificateNumber();
        $validated['issued_by'] = Auth::id();
        $validated['status'] = 'Issued';

        $certificate = Certificate::create($validated);

        return redirect()
            ->route('certificates.show', $certificate)
            ->with('success', 'Certificate successfully issued.');
    }

    /**
     * Display a specific certificate.
     */
    public function show(Certificate $certificate)
    {
        $certificate->load([
            'resident.household',
            'issuer',
        ]);

        return view('certificates.show', compact('certificate'));
    }

    /**
     * Show the certificate edit form.
     */
    public function edit(Certificate $certificate)
    {
        $residents = Resident::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $certificateTypes = [
            'Certificate of Residency',
            'Certificate of Indigency',
            'Barangay Clearance',
            'Certificate of Good Moral Character',
            'Medical Certificate',
            'Health Certificate',
            'Medical Examination Certificate',
            'Fitness to Work Certificate',
            'Fitness to Attend School Certificate',
            'Vaccination / Immunization Certificate',
        ];

        return view('certificates.edit', compact(
            'certificate',
            'residents',
            'certificateTypes'
        ));
    }

    /**
     * Update a certificate.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'resident_id' => [
                'required',
                'exists:residents,id',
            ],

            'certificate_type' => [
                'required',
                Rule::in([
                    'Certificate of Residency',
                    'Certificate of Indigency',
                    'Barangay Clearance',
                    'Certificate of Good Moral Character',
                    'Medical Certificate',
                    'Health Certificate',
                    'Medical Examination Certificate',
                    'Fitness to Work Certificate',
                    'Fitness to Attend School Certificate',
                    'Vaccination / Immunization Certificate',
                ]),
            ],

            'purpose' => [
                'nullable',
                'string',
                'max:500',
            ],

            'date_issued' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:Issued,Cancelled',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $certificate->update($validated);

        return redirect()
            ->route('certificates.show', $certificate)
            ->with('success', 'Certificate successfully updated.');
    }

    /**
     * Cancel a certificate.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->update([
            'status' => 'Cancelled',
        ]);

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificate successfully cancelled.');
    }

    /**
     * Display a printable version of the certificate.
     */
    public function print(Certificate $certificate)
    {
        $certificate->load([
            'resident.household',
            'issuer',
        ]);

        return view('certificates.print', compact('certificate'));
    }

    /**
     * Generate the next certificate number.
     *
     * Example:
     * CERT-2026-000001
     */
    private function generateCertificateNumber(): string
    {
        $year = now()->year;

        $lastCertificate = Certificate::whereYear(
            'created_at',
            $year
        )
            ->latest('id')
            ->first();

        $nextNumber = $lastCertificate
            ? ((int) substr($lastCertificate->certificate_number, -6)) + 1
            : 1;

        return sprintf(
            'CERT-%d-%06d',
            $year,
            $nextNumber
        );
    }
}
