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
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display the Analytics dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Population Overview
        |--------------------------------------------------------------------------
        */

        $totalResidents = Resident::count();

        $totalHouseholds = Household::count();

        $maleResidents = Resident::whereRaw('LOWER(gender) = ?', ['male'])
            ->count();

        $femaleResidents = Resident::whereRaw('LOWER(gender) = ?', ['female'])
            ->count();

        $otherGenderResidents = max(
            0,
            $totalResidents - $maleResidents - $femaleResidents
        );

        /*
        |--------------------------------------------------------------------------
        | Resident Status
        |--------------------------------------------------------------------------
        */

        $residentStatusSummary = Resident::query()
            ->selectRaw('COALESCE(status, "Unknown") as status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Age Demographics
        |--------------------------------------------------------------------------
        |
        | Age groups:
        | 0–4       Early childhood
        | 5–17      Children
        | 18–59     Adults
        | 60+       Senior citizens
        |
        */

        $ageGroups = [
            '0–4' => 0,
            '5–17' => 0,
            '18–59' => 0,
            '60+' => 0,
        ];

        Resident::query()
            ->whereNotNull('birth_date')
            ->pluck('birth_date')
            ->each(function ($birthDate) use (&$ageGroups) {

                $age = Carbon::parse($birthDate)->age;

                if ($age <= 4) {
                    $ageGroups['0–4']++;
                } elseif ($age <= 17) {
                    $ageGroups['5–17']++;
                } elseif ($age <= 59) {
                    $ageGroups['18–59']++;
                } else {
                    $ageGroups['60+']++;
                }
            });

        $ageGroups['Unknown'] = max(
            0,
            $totalResidents - array_sum($ageGroups)
        );

        /*
        |--------------------------------------------------------------------------
        | Health Program Overview
        |--------------------------------------------------------------------------
        */

        $totalHealthRecords = HealthRecord::count();

        $totalImmunizations = Immunization::count();

        $totalMaternalCare = MaternalCare::count();

        $totalChildHealth = ChildHealth::count();

        $totalSeniorCitizens = SeniorCitizen::count();

        /*
        |--------------------------------------------------------------------------
        | Immunization Analytics
        |--------------------------------------------------------------------------
        */

        $immunizationByVaccine = Immunization::query()
            ->selectRaw(
                'COALESCE(vaccine_name, "Unknown") as vaccine_name, COUNT(*) as total'
            )
            ->groupBy('vaccine_name')
            ->orderByDesc('total')
            ->get();

        $immunizationTrend = Immunization::query()
            ->whereNotNull('date_administered')
            ->selectRaw(
                'DATE_FORMAT(date_administered, "%Y-%m") as month, COUNT(*) as total'
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Maternal Care Analytics
        |--------------------------------------------------------------------------
        */

        $maternalCareByStatus = MaternalCare::query()
            ->selectRaw(
                'COALESCE(pregnancy_status, "Unknown") as pregnancy_status, COUNT(*) as total'
            )
            ->groupBy('pregnancy_status')
            ->orderByDesc('total')
            ->get();

        $maternalCareTrend = MaternalCare::query()
            ->whereNotNull('last_prenatal_visit')
            ->selectRaw(
                'DATE_FORMAT(last_prenatal_visit, "%Y-%m") as month, COUNT(*) as total'
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Child Health Analytics
        |--------------------------------------------------------------------------
        */

        $childHealthByNutrition = ChildHealth::query()
            ->selectRaw(
                'COALESCE(nutritional_status, "Unknown") as nutritional_status, COUNT(*) as total'
            )
            ->groupBy('nutritional_status')
            ->orderByDesc('total')
            ->get();

        $childHealthTrend = ChildHealth::query()
            ->whereNotNull('assessment_date')
            ->selectRaw(
                'DATE_FORMAT(assessment_date, "%Y-%m") as month, COUNT(*) as total'
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Senior Citizen Analytics
        |--------------------------------------------------------------------------
        */

        $seniorCitizenByLivingArrangement = SeniorCitizen::query()
            ->selectRaw(
                'COALESCE(living_arrangement, "Unknown") as living_arrangement, COUNT(*) as total'
            )
            ->groupBy('living_arrangement')
            ->orderByDesc('total')
            ->get();

        $seniorCitizenPensionCount = SeniorCitizen::query()
            ->where('receives_social_pension', true)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Medical Inventory Analytics
        |--------------------------------------------------------------------------
        */

        $totalMedicalInventory = MedicalInventory::count();

        $totalInventoryQuantity = (int) MedicalInventory::sum('quantity');

        $expiredInventory = MedicalInventory::query()
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', now()->toDateString())
            ->count();

        $expiringSoonInventory = MedicalInventory::query()
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', now()->toDateString())
            ->whereDate(
                'expiry_date',
                '<=',
                now()->addDays(30)->toDateString()
            )
            ->count();

        $lowStockInventory = MedicalInventory::query()
            ->where('quantity', '<=', 10)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Schedule Analytics
        |--------------------------------------------------------------------------
        */

        $totalEvents = Event::count();

        $upcomingEvents = Event::query()
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        $eventsByType = Event::query()
            ->selectRaw(
                'COALESCE(event_type, "Other") as event_type, COUNT(*) as total'
            )
            ->groupBy('event_type')
            ->orderByDesc('total')
            ->get();

        $eventsByMonth = Event::query()
            ->whereNotNull('event_date')
            ->selectRaw(
                'DATE_FORMAT(event_date, "%Y-%m") as month, COUNT(*) as total'
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Gender Summary
        |--------------------------------------------------------------------------
        */

        $genderSummary = collect([
            (object) [
                'gender' => 'Male',
                'total' => $maleResidents,
            ],
            (object) [
                'gender' => 'Female',
                'total' => $femaleResidents,
            ],
            (object) [
                'gender' => 'Other / Unspecified',
                'total' => $otherGenderResidents,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Dashboard Summary
        |--------------------------------------------------------------------------
        */

        $programCoverage = [
            'Health Records' => $totalHealthRecords,
            'Immunizations' => $totalImmunizations,
            'Maternal Care' => $totalMaternalCare,
            'Child Health' => $totalChildHealth,
            'Senior Citizens' => $totalSeniorCitizens,
        ];

        return view('analytics.index', compact(
            'totalResidents',
            'totalHouseholds',
            'maleResidents',
            'femaleResidents',
            'otherGenderResidents',
            'genderSummary',
            'residentStatusSummary',
            'ageGroups',

            'totalHealthRecords',
            'totalImmunizations',
            'totalMaternalCare',
            'totalChildHealth',
            'totalSeniorCitizens',
            'programCoverage',

            'immunizationByVaccine',
            'immunizationTrend',

            'maternalCareByStatus',
            'maternalCareTrend',

            'childHealthByNutrition',
            'childHealthTrend',

            'seniorCitizenByLivingArrangement',
            'seniorCitizenPensionCount',

            'totalMedicalInventory',
            'totalInventoryQuantity',
            'expiredInventory',
            'expiringSoonInventory',
            'lowStockInventory',

            'totalEvents',
            'upcomingEvents',
            'eventsByType',
            'eventsByMonth',
        ));
    }
}
