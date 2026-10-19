<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\HealthVisit;
use App\Models\Household;
use App\Models\Resident;
use App\Models\SeniorCitizen;
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


        /*
        |--------------------------------------------------------------------------
        | Monthly Health Visits
        |--------------------------------------------------------------------------
        */
        $currentYear = now()->year;

        $monthlyVisitCounts = HealthVisit::query()
            ->selectRaw('MONTH(visit_date) as month, COUNT(*) as count')
            ->whereYear('visit_date', $currentYear)
            ->groupByRaw('MONTH(visit_date)')
            ->orderByRaw('MONTH(visit_date)')
            ->get()
            ->keyBy('month');


        /*
        |--------------------------------------------------------------------------
        | Build January - December
        |--------------------------------------------------------------------------
        */
        $monthlyHealthVisits = collect(range(1, 12))
            ->map(function (int $month) use ($monthlyVisitCounts) {

                return [
                    'month' => now()
                        ->startOfYear()
                        ->addMonths($month - 1)
                        ->format('M'),

                    'count' => (int) (
                        $monthlyVisitCounts->get($month)?->count ?? 0
                    ),
                ];

            })
            ->values();


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

            'monthlyHealthVisits' => $monthlyHealthVisits,

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