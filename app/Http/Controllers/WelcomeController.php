<?php

namespace App\Http\Controllers;

use App\Models\ChildHealth;
use App\Models\Event;
use App\Models\HealthRecord;
use App\Models\HealthVisit;
use App\Models\Household;
use App\Models\Immunization;
use App\Models\MaternalCare;
use App\Models\MedicalInventory;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $demographics = [
            'gender' => ['Male' => 0, 'Female' => 0, 'Other / Unspecified' => 0],
            'status' => ['Active' => 0, 'Inactive' => 0, 'Unknown status' => 0],
        ];
        $residentCount = 0;

        foreach (Resident::query()
            ->selectRaw('gender, status, COUNT(*) as total')
            ->groupBy('gender', 'status')
            ->toBase()
            ->cursor() as $group) {
            $count = (int) $group->total;
            $residentCount += $count;
            $gender = match (strtolower(trim((string) $group->gender))) {
                'male' => 'Male',
                'female' => 'Female',
                default => 'Other / Unspecified',
            };
            $status = match (strtolower(trim((string) $group->status))) {
                'active' => 'Active',
                'inactive' => 'Inactive',
                default => 'Unknown status',
            };

            $demographics['gender'][$gender] += $count;
            $demographics['status'][$status] += $count;
        }

        foreach ($demographics as $name => $counts) {
            if (array_filter($counts, fn (int $count): bool => $count > 0 && $count < 5)) {
                $demographics[$name] = null;
            }
        }

        $yearStart = CarbonImmutable::today()->startOfYear();
        $monthlyCounts = array_fill(1, 12, 0);
        $visitCountsByDay = HealthVisit::query()
            ->where('visit_date', '>=', $yearStart)
            ->where('visit_date', '<', $yearStart->addYear())
            ->toBase()
            ->selectRaw('DATE(visit_date) as visit_day, COUNT(*) as visit_count')
            ->groupByRaw('DATE(visit_date)')
            ->get();

        foreach ($visitCountsByDay as $day) {
            $monthlyCounts[(int) substr($day->visit_day, 5, 2)] += (int) $day->visit_count;
        }

        $monthlyHealthVisits = [];
        foreach ($monthlyCounts as $month => $count) {
            $monthlyHealthVisits[] = [
                'label' => $yearStart->addMonths($month - 1)->format('M'),
                'count' => $count,
            ];
        }

        $healthEntries = HealthRecord::count()
            + Immunization::count()
            + MaternalCare::count()
            + ChildHealth::count()
            + SeniorCitizen::count();

        return view('welcome', [
            'overview' => [
                'residents' => $residentCount,
                'households' => Household::count(),
                'events' => Event::count(),
                'upcomingEvents' => Event::whereDate('event_date', '>=', now()->toDateString())->count(),
                'inventory' => MedicalInventory::count(),
                'healthEntries' => $healthEntries >= 5 ? $healthEntries : null,
            ],
            'demographics' => $demographics,
            'healthVisitYear' => $yearStart->year,
            'monthlyHealthVisits' => $monthlyHealthVisits,
        ]);
    }
}
