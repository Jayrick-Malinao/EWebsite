<?php

namespace App\Http\Controllers;

use App\Models\ChildHealth;
use App\Models\Event;
use App\Models\HealthRecord;
use App\Models\Household;
use App\Models\Immunization;
use App\Models\MaternalCare;
use App\Models\MedicalInventory;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index(): View
    {
        /*
         * ---------------------------------------------------------
         * Basic record totals
         * ---------------------------------------------------------
         */
        $totalResidents = Resident::count();

        $totalHouseholds = Household::count();

        $totalHouseholdHeads = Resident::where(
            'is_household_head',
            true
        )->count();

        $totalHealthRecords = HealthRecord::count();

        $totalImmunizations = Immunization::count();

        $totalMaternalCare = MaternalCare::count();

        $totalChildHealth = ChildHealth::count();

        $totalSeniorCitizens = SeniorCitizen::count();

        $totalMedicalInventory = MedicalInventory::count();

        /*
         * ---------------------------------------------------------
         * Resident gender summary
         * ---------------------------------------------------------
         */
        $genderSummary = Resident::query()
            ->select('gender', DB::raw('COUNT(*) as total'))
            ->groupBy('gender')
            ->orderByDesc('total')
            ->get();

        /*
         * ---------------------------------------------------------
         * Resident status summary
         * ---------------------------------------------------------
         */
        $residentStatusSummary = Resident::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        /*
         * ---------------------------------------------------------
         * Upcoming schedule events
         * ---------------------------------------------------------
         */
        $upcomingEvents = Event::query()
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        /*
         * ---------------------------------------------------------
         * Medical inventory alerts
         *
         * Items that are already expired or will expire
         * within the next 30 days.
         * ---------------------------------------------------------
         */
        $inventoryAlerts = MedicalInventory::query()
            ->whereDate(
                'expiry_date',
                '<=',
                now()->addDays(30)->toDateString()
            )
            ->orderBy('expiry_date')
            ->take(5)
            ->get();

        /*
         * ---------------------------------------------------------
         * Recent residents
         * ---------------------------------------------------------
         */
        $recentResidents = Resident::query()
            ->latest()
            ->take(5)
            ->get();

        /*
         * ---------------------------------------------------------
         * Report data
         * ---------------------------------------------------------
         */
        return view('reports.index', [
            'totalResidents' => $totalResidents,
            'totalHouseholds' => $totalHouseholds,
            'totalHouseholdHeads' => $totalHouseholdHeads,
            'totalHealthRecords' => $totalHealthRecords,
            'totalImmunizations' => $totalImmunizations,
            'totalMaternalCare' => $totalMaternalCare,
            'totalChildHealth' => $totalChildHealth,
            'totalSeniorCitizens' => $totalSeniorCitizens,
            'totalMedicalInventory' => $totalMedicalInventory,
            'genderSummary' => $genderSummary,
            'residentStatusSummary' => $residentStatusSummary,
            'upcomingEvents' => $upcomingEvents,
            'inventoryAlerts' => $inventoryAlerts,
            'recentResidents' => $recentResidents,
        ]);
    }
}
