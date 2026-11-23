<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\HealthVisit;
use App\Models\Household;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * System Administrator Dashboard.
     */
    public function admin(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Statistics
        |--------------------------------------------------------------------------
        */
        $totalResidents = Resident::count();

        $totalHouseholds = Household::count();

        $totalHealthVisits = HealthVisit::count();

        $totalSeniorCitizens = SeniorCitizen::count();

        $todayHealthVisits = HealthVisit::whereDate(
            'visit_date',
            today()
        )->count();

        $today = CarbonImmutable::today();
        $visitCountsByDay = HealthVisit::query()
            ->toBase()
            ->selectRaw('DATE(visit_date) as visit_day, COUNT(*) as visit_count')
            ->groupByRaw('DATE(visit_date)')
            ->get()
            ->mapWithKeys(fn (object $row): array => [$row->visit_day => (int) $row->visit_count]);

        $visitCountsByMonth = [];
        $visitCountsByYear = [];
        foreach ($visitCountsByDay as $date => $count) {
            $month = substr($date, 0, 7);
            $year = (int) substr($date, 0, 4);
            $visitCountsByMonth[$month] = ($visitCountsByMonth[$month] ?? 0) + $count;
            $visitCountsByYear[$year] = ($visitCountsByYear[$year] ?? 0) + $count;
        }

        $weekStart = $today->startOfWeek(CarbonInterface::MONDAY);
        $firstYear = min([$today->year, ...array_keys($visitCountsByYear)]);
        $lastYear = max([$today->year, ...array_keys($visitCountsByYear)]);

        $healthVisitChartData = [
            'day' => [
                'title' => 'Daily Health Visits',
                'description' => 'Health visits over the last 30 days, including today',
                'axis' => 'Day',
                'points' => collect(range(29, 0))->map(function (int $offset) use ($today, $visitCountsByDay): array {
                    $date = $today->subDays($offset);

                    return ['label' => $date->format('M j'), 'count' => $visitCountsByDay->get($date->toDateString(), 0)];
                })->all(),
            ],
            'week' => [
                'title' => 'Weekly Health Visits',
                'description' => 'Health visits over the last 12 weeks, through today',
                'axis' => 'Week starting Monday',
                'points' => collect(range(11, 0))->map(function (int $offset) use ($weekStart, $today, $visitCountsByDay): array {
                    $start = $weekStart->subWeeks($offset);
                    $count = collect(range(0, 6))->sum(function (int $day) use ($start, $today, $visitCountsByDay): int {
                        $date = $start->addDays($day);

                        return $date->lessThanOrEqualTo($today) ? $visitCountsByDay->get($date->toDateString(), 0) : 0;
                    });

                    return ['label' => $start->format('M j, Y'), 'count' => $count];
                })->all(),
            ],
            'month' => [
                'title' => 'Monthly Health Visits',
                'description' => "Health visits recorded in {$today->year}",
                'axis' => 'Month',
                'points' => collect(range(0, 11))->map(function (int $offset) use ($today, $visitCountsByMonth): array {
                    $date = $today->startOfYear()->addMonths($offset);

                    return ['label' => $date->format('M'), 'count' => $visitCountsByMonth[$date->format('Y-m')] ?? 0];
                })->all(),
            ],
            'year' => [
                'title' => 'Yearly Health Visits',
                'description' => 'Health visits over the last 5 calendar years',
                'axis' => 'Year',
                'points' => collect(range($today->year - 4, $today->year))
                    ->map(fn (int $year): array => ['label' => (string) $year, 'count' => $visitCountsByYear[$year] ?? 0])
                    ->all(),
            ],
            'all' => [
                'title' => 'All Health Visits',
                'description' => 'All recorded health visits, grouped by year',
                'axis' => 'Year',
                'points' => collect(range($firstYear, $lastYear))
                    ->map(fn (int $year): array => ['label' => (string) $year, 'count' => $visitCountsByYear[$year] ?? 0])
                    ->all(),
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Recent Health Visits
        |--------------------------------------------------------------------------
        */
        $recentHealthVisits = HealthVisit::with('resident')
            ->latest('visit_date')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recently Added Residents
        |--------------------------------------------------------------------------
        */
        $recentResidents = Resident::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Admin Dashboard
        |--------------------------------------------------------------------------
        */
        return view('dashboard.admin.dashboard', [

            'totalResidents' => $totalResidents,

            'totalHouseholds' => $totalHouseholds,

            'totalHealthVisits' => $totalHealthVisits,

            'totalSeniorCitizens' => $totalSeniorCitizens,

            'todayHealthVisits' => $todayHealthVisits,

            'healthVisitChartData' => $healthVisitChartData,

            'recentHealthVisits' => $recentHealthVisits,

            'recentResidents' => $recentResidents,

        ]);
    }

    /**
     * Barangay Official Dashboard.
     *
     * Provides community-level monitoring data using the same
     * shared database used by the other authorized roles.
     */
    public function official(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Community Statistics
        |--------------------------------------------------------------------------
        */
        $totalResidents = Resident::count();

        $totalHouseholds = Household::count();

        $upcomingEventsCount = Event::query()
            ->whereDate('event_date', '>=', today())
            ->count();

        $announcementCount = Announcement::count();

        /*
        |--------------------------------------------------------------------------
        | Upcoming Schedule
        |--------------------------------------------------------------------------
        */
        $upcomingEvents = Event::query()
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recently Added Residents
        |--------------------------------------------------------------------------
        */
        $recentResidents = Resident::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Announcements
        |--------------------------------------------------------------------------
        */
        $announcements = Announcement::query()
            ->latest()
            ->take(3)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Official Dashboard
        |--------------------------------------------------------------------------
        */
        return view('dashboard.official.dashboard', [

            'totalResidents' => $totalResidents,

            'totalHouseholds' => $totalHouseholds,

            'upcomingEventsCount' => $upcomingEventsCount,

            'announcementCount' => $announcementCount,

            'upcomingEvents' => $upcomingEvents,

            'recentResidents' => $recentResidents,

            'announcements' => $announcements,

        ]);
    }

    /**
     * Health Worker Dashboard.
     */
    public function healthworker(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Statistics
        |--------------------------------------------------------------------------
        | These are shared database records.
        |
        | Anything added or updated by a Health Worker will therefore
        | automatically be reflected in the Administrator and Official
        | dashboards when they query the same tables.
        |--------------------------------------------------------------------------
        */
        $totalResidents = Resident::count();

        $totalHouseholds = Household::count();

        $totalSeniorCitizens = SeniorCitizen::count();

        /*
        |--------------------------------------------------------------------------
        | Recently Added Residents
        |--------------------------------------------------------------------------
        */
        $recentResidents = Resident::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Health Worker Dashboard
        |--------------------------------------------------------------------------
        */
        return view('dashboard.healthworker.dashboard', [

            'totalResidents' => $totalResidents,

            'totalHouseholds' => $totalHouseholds,

            'totalSeniorCitizens' => $totalSeniorCitizens,

            'recentResidents' => $recentResidents,

        ]);
    }
}
