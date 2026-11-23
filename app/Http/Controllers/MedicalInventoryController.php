<?php

namespace App\Http\Controllers;

use App\Models\MedicalInventory;
use App\Models\Resident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MedicalInventoryController extends Controller
{
    /**
     * Display all medical inventory records.
     */
    public function index(): View
    {
        $today = now(config('app.timezone'))->startOfDay();
        $medicalInventories = MedicalInventory::query()
            ->orderBy('expiry_date')
            ->orderBy('medicine_name')
            ->get();
        $expiredInventories = $medicalInventories
            ->filter(fn (MedicalInventory $inventory): bool => $inventory->expiry_date->lt($today));
        $unexpiredInventories = $medicalInventories
            ->reject(fn (MedicalInventory $inventory): bool => $inventory->expiry_date->lt($today));
        $expiredQuantity = $expiredInventories->sum('quantity');
        $unexpiredQuantity = $unexpiredInventories->sum('quantity');
        $totalQuantity = $expiredQuantity + $unexpiredQuantity;

        return view('medical-inventories.index', [
            'medicalInventories' => $medicalInventories,
            'expiredInventories' => $expiredInventories,
            'unexpiredInventories' => $unexpiredInventories,
            'today' => $today,
            'expiredQuantity' => $expiredQuantity,
            'unexpiredQuantity' => $unexpiredQuantity,
            'expiredPercentage' => $totalQuantity > 0
                ? (int) round($expiredQuantity / $totalQuantity * 100)
                : 0,
            'unexpiredPercentage' => $totalQuantity > 0
                ? (int) round($unexpiredQuantity / $totalQuantity * 100)
                : 0,
        ]);
    }

    /**
     * Show the form for adding a new medical inventory record.
     */
    public function create(): View
    {
        return view('medical-inventories.create');
    }

    /**
     * Store a new medical inventory record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'medicine_name' => [
                'required',
                'string',
                'max:255',
            ],

            'expiry_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'medicine_name.required' => 'Medicine name is required.',
            'expiry_date.required' => 'Expiry date is required.',
            'expiry_date.after_or_equal' => 'The expiry date cannot be earlier than today.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity cannot be negative.',
        ]);

        MedicalInventory::create([
            'medicine_name' => $validated['medicine_name'],
            'expiry_date' => $validated['expiry_date'],
            'quantity' => $validated['quantity'],

            // New inventory items have not received any expiry alerts.
            'alert_1_month_sent' => false,
            'alert_15_days_sent' => false,
            'alert_7_days_sent' => false,
            'alert_expiry_sent' => false,
        ]);

        return redirect()
            ->route('medical-inventories.index')
            ->with('success', 'Medical inventory item added successfully.');
    }

    /**
     * Show the form for editing a medical inventory record.
     */
    public function edit(MedicalInventory $medicalInventory): View
    {
        return view('medical-inventories.edit', compact('medicalInventory'));
    }

    /**
     * Update a medical inventory record.
     */
    public function update(Request $request, MedicalInventory $medicalInventory): RedirectResponse
    {
        $validated = $request->validate([
            'medicine_name' => [
                'required',
                'string',
                'max:255',
            ],

            'expiry_date' => [
                'required',
                'date',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'medicine_name.required' => 'Medicine name is required.',
            'expiry_date.required' => 'Expiry date is required.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity cannot be negative.',
        ]);

        $medicalInventory->update([
            'medicine_name' => $validated['medicine_name'],
            'expiry_date' => $validated['expiry_date'],
            'quantity' => $validated['quantity'],
        ]);

        return redirect()
            ->route('medical-inventories.index')
            ->with('success', 'Medical inventory item updated successfully.');
    }

    /**
     * Delete a medical inventory record.
     */
    public function destroy(MedicalInventory $medicalInventory): RedirectResponse
    {
        $medicalInventory->delete();

        return redirect()
            ->route('medical-inventories.index')
            ->with('success', 'Medical inventory item deleted successfully.');
    }

    public function stockOut(): View
    {
        $today = now(config('app.timezone'))->toDateString();
        $medicalInventories = MedicalInventory::query()
            ->where('quantity', '>', 0)
            ->whereDate('expiry_date', '>=', $today)
            ->orderBy('medicine_name')
            ->orderBy('expiry_date')
            ->get();
        $residents = Resident::query()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'middle_name', 'last_name', 'suffix']);

        return view('medical-inventories.stock-out', [
            'medicalInventories' => $medicalInventories,
            'residents' => $residents,
            'releasedBy' => auth()->user(),
            'releasedAt' => now(config('app.timezone')),
        ]);
    }

    public function storeStockOut(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'medical_inventory_id' => ['required', 'integer', 'exists:medical_inventories,id'],
            'resident_id' => ['required', 'integer', 'exists:residents,id'],
            'method' => ['required', 'string', 'max:100'],
            'purpose' => ['required', 'string', 'max:1000'],
            'quantity' => ['required', 'integer', 'min:1'],
            'confirmation' => ['accepted'],
        ], [
            'medical_inventory_id.required' => 'Select a medicine from the searchable list.',
            'resident_id.required' => 'Select a resident from the searchable list.',
            'quantity.min' => 'Release quantity must be at least one unit.',
            'confirmation.accepted' => 'Confirm the stock release before submitting.',
        ]);

        DB::transaction(function () use ($validated): void {
            $inventory = MedicalInventory::query()
                ->lockForUpdate()
                ->findOrFail($validated['medical_inventory_id']);
            $today = now(config('app.timezone'))->startOfDay();

            if ($inventory->expiry_date->lt($today)) {
                throw ValidationException::withMessages([
                    'medical_inventory_id' => 'Expired medicine cannot be released.',
                ]);
            }

            if ($validated['quantity'] > $inventory->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => "Only {$inventory->quantity} units are currently available.",
                ]);
            }

            $inventory->decrement('quantity', $validated['quantity']);
            $inventory->transactions()->create([
                'resident_id' => $validated['resident_id'],
                'released_by_id' => auth()->id(),
                'method' => $validated['method'],
                'purpose' => $validated['purpose'],
                'quantity' => $validated['quantity'],
                'released_at' => now(config('app.timezone')),
            ]);
        });

        return redirect()
            ->route('medical-inventories.index')
            ->with('success', 'Medicine stock released successfully.');
    }
}
