<?php

namespace App\Http\Controllers;

use App\Models\MedicalInventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalInventoryController extends Controller
{
    /**
     * Display all medical inventory records.
     */
    public function index(): View
    {
        $medicalInventories = MedicalInventory::query()
            ->orderBy('expiry_date')
            ->orderBy('medicine_name')
            ->get();

        return view('medical-inventories.index', compact('medicalInventories'));
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
}