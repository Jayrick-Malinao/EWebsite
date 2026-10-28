<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Certificate;
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
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DatabaseAssistantController extends Controller
{
    private const MAX_QUERY_ROWS = 50;

    private const MAX_SELECTED_COLUMNS = 20;

    private const QUERYABLE_TABLES = [
        'residents',
        'households',
        'health_records',
        'health_visits',
        'immunizations',
        'maternal_cares',
        'child_healths',
        'senior_citizens',
        'medical_inventories',
        'events',
        'certificates',
        'announcements',
        'users',
        'audit_logs',
    ];

    private const BLOCKED_TABLES = [
        'cache', 'cache_locks', 'failed_jobs', 'job_batches', 'jobs',
        'migrations', 'password_reset_tokens', 'personal_access_tokens',
        'sessions', 'system_settings',
    ];

    private const CLINICAL_TABLES = [
        'health_records', 'health_visits', 'immunizations',
        'maternal_cares', 'child_healths', 'senior_citizens',
    ];

    private const BLOCKED_COLUMNS = [
        'password', 'remember_token', 'two_factor_secret',
        'two_factor_recovery_codes', 'api_token', 'access_token',
        'refresh_token', 'secret', 'private_key', 'password_hash',
        'token', 'api_key', 'api_secret', 'credential', 'credentials',
        'contact_number', 'email', 'phone', 'phone_number',
        'mobile_number', 'address', 'household_address',
        'philhealth_number', 'birth_date',
    ];

    public function chat(Request $request): JsonResponse
    {
        $maxLength = (int) config(
            'database_assistant.max_message_length',
            1000
        );

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:'.$maxLength],
        ]);

        $message = trim($validated['message']);
        $normalized = $this->normalizeMessage($message);

        if ($this->isGreeting($normalized)) {
            return $this->reply($this->isTagalogMessage($normalized)
                ? 'Kumusta! Makakatulong ako sa paghahanap ng impormasyon sa '
                    .'database tungkol sa mga residente, sambahayan, iskedyul, '
                    .'anunsyo, imbentaryo, sertipiko, at mga rekord na pinapayagan '
                    .'ng iyong account.'
                : 'Hello! I am the Barangay Esperanza Health Center database '
                    .'assistant. You can ask me about residents, households, '
                    .'senior citizens, maternal care, child health, health visits, '
                    .'immunizations, medical inventory, schedules, announcements, '
                    .'staff accounts, certificates, and database summaries. '
                    .'Available information depends on your account permissions.');
        }

        if (
            $this->matchesConfiguredIntent($normalized, 'help')
            || $this->isGeneralHelpQuestion($normalized)
        ) {
            return $this->reply($this->isTagalogMessage($normalized)
                ? 'Maaari akong sumagot tungkol sa bilang ng residente at '
                    .'sambahayan, pinapayagang paghahanap ng rekord, mga susunod '
                    .'na iskedyul, nailathalang anunsyo, pag-expire ng imbentaryo, '
                    .'at sertipiko. Halimbawa: “Ilan ang rehistradong residente?” '
                    .'o “May schedule ba this week?” Makikita lamang ang mga '
                    .'rekord na pinapayagan ng iyong tungkulin.'
                : 'I can answer current resident and household counts, permitted '
                .'resident or household lookups, upcoming schedules, published '
                .'announcements, inventory expiry, certificate counts and '
                .'statuses, and other database questions available to your role. '
                .'Examples: “How many residents are registered?”, “May schedule '
                .'ba this week?”, or “Which medicines are expiring soon?” '
                .'Clinical records and inventory are available only to roles '
                .'authorized by the relevant system pages.');
        }

        /*
        |--------------------------------------------------------------------------
        | Deterministic database handlers
        |--------------------------------------------------------------------------
        */

        try {
            if ($this->isHouseholdMembershipQuestion($normalized)) {
                return $this->householdMembershipResponse(
                    $normalized,
                    $this->isTagalogMessage($normalized)
                );
            }

            if ($this->isResidentNameListQuestion($normalized)) {
                return $this->residentNamesResponse();
            }

            if ($this->isSeniorCitizenCountQuestion($normalized)) {
                if (! $this->canViewClinicalRecords()) {
                    return $this->reply(
                        'Senior citizen statistics are available only to '
                        .'authorized health personnel.'
                    );
                }

                $total = SeniorCitizen::count();

                return $this->reply($this->isTagalogMessage($normalized)
                    ? "May {$total} na nakarehistrong senior citizen.\n\n"
                        .'Pinagmulan: senior_citizens table.'
                    : 'There '.($total === 1 ? 'is' : 'are')
                        ." {$total} registered senior citizen"
                        .($total === 1 ? '' : 's')
                        ." in the database.\n\nSource: senior_citizens table.");
            }

            if ($this->isSeniorCitizenListQuestion($normalized)) {
                if (! $this->canViewClinicalRecords()) {
                    return $this->reply(
                        'Senior citizen records are available only to '
                        .'authorized health personnel.'
                    );
                }

                return $this->seniorCitizenListResponse();
            }

            if ($this->isResidentCountQuestion($normalized)) {
                $total = Resident::count();

                $active = Resident::whereRaw(
                    'LOWER(status) = ?',
                    ['active']
                )->count();

                $inactive = Resident::whereRaw(
                    'LOWER(status) = ?',
                    ['inactive']
                )->count();

                return $this->reply($this->isTagalogMessage($normalized)
                    ? "Mga rehistradong residente: {$total}\n"
                        ."Aktibo: {$active}\n"
                        ."Hindi aktibo: {$inactive}\n\n"
                        .'Pinagmulan: residents table.'
                    : "Registered residents: {$total}\n"
                        ."Active residents: {$active}\n"
                        ."Inactive residents: {$inactive}\n\n"
                        .'Source: residents table.');
            }

            if ($this->isHouseholdCountQuestion($normalized)) {
                $total = Household::count();

                return $this->reply($this->isTagalogMessage($normalized)
                    ? "May {$total} na nakarehistrong sambahayan.\n\n"
                        .'Pinagmulan: households table.'
                    : "There are {$total} registered household record(s).\n\n"
                        .'Source: households table.');
            }

            if ($this->isHouseholdListQuestion($normalized)) {
                return $this->householdListResponse($normalized);
            }

            if ($this->isStaffCountQuestion($normalized)) {
                if (auth()->user()?->role !== 'System Administrator') {
                    return $this->reply(
                        'Staff account statistics are available only to the '
                        .'System Administrator.'
                    );
                }

                $total = User::count();

                $healthWorkers = User::where(
                    'role',
                    'Health Worker'
                )->count();

                $officials = User::where(
                    'role',
                    'Official'
                )->count();

                $administrators = User::where(
                    'role',
                    'System Administrator'
                )->count();

                return $this->reply(
                    "Total user accounts: {$total}\n"
                    ."System Administrators: {$administrators}\n"
                    ."Health Workers: {$healthWorkers}\n"
                    ."Officials: {$officials}\n\n"
                    .'Source: users table.'
                );
            }

            if ($this->isHealthVisitCountQuestion($normalized)) {
                if (! $this->canViewClinicalRecords()) {
                    return $this->reply(
                        'Health visit statistics are available only to '
                        .'authorized health personnel.'
                    );
                }

                if (! Schema::hasTable('health_visits')) {
                    return $this->reply(
                        'Health visit records are not available in the current database schema.'
                    );
                }

                $query = HealthVisit::query();

                $this->applyDateRangeToQuery(
                    $query,
                    $normalized,
                    'visit_date'
                );

                $count = $query->count();

                return $this->reply(
                    "There are {$count} health visit record(s)"
                    .$this->dateRangeDescription($normalized)
                    .".\n\nSource: health_visits table."
                );
            }

            if ($this->isExpiredInventoryQuestion($normalized)) {
                if (! $this->canViewMedicalInventory()) {
                    return $this->reply(
                        'Medical inventory information is available only to '
                        .'authorized health personnel.'
                    );
                }

                return $this->inventoryResponse(
                    true,
                    $this->isTagalogMessage($normalized)
                );
            }

            if ($this->isExpiringInventoryQuestion($normalized)) {
                if (! $this->canViewMedicalInventory()) {
                    return $this->reply(
                        'Medical inventory information is available only to '
                        .'authorized health personnel.'
                    );
                }

                return $this->inventoryResponse(
                    false,
                    $this->isTagalogMessage($normalized)
                );
            }

            if ($this->isMedicalInventoryListQuestion($normalized)) {
                if (! $this->canViewMedicalInventory()) {
                    return $this->reply(
                        'Medical inventory information is available only to '
                        .'authorized health personnel.'
                    );
                }

                return $this->medicalInventoryListResponse();
            }

            if (
                $this->isEventLocationQuestion($normalized)
                || $this->isUpcomingScheduleQuestion($normalized)
            ) {
                return $this->upcomingEventsResponse(
                    $normalized,
                    $this->isTagalogMessage($normalized)
                );
            }

            if ($this->isAnnouncementStatusQuestion($normalized)) {
                return $this->announcementStatusResponse(
                    $this->isTagalogMessage($normalized)
                );
            }

            if ($this->isAnnouncementQuestion($normalized)) {
                return $this->announcementsResponse(
                    $this->isTagalogMessage($normalized)
                );
            }

            if ($this->isCertificateStatusQuestion($normalized)) {
                return $this->certificateStatusResponse();
            }

            if ($this->isCertificateCountQuestion($normalized)) {
                return $this->certificateCountResponse();
            }

            if ($this->isHouseholdLookupQuestion($normalized)) {
                return $this->householdLookupResponse($message);
            }

            if ($this->isResidentProfileQuestion($normalized)) {
                return $this->residentProfileResponse($message);
            }
        } catch (QueryException $exception) {
            Log::error('Database assistant deterministic query failed.', [
                'exception' => get_class($exception),
            ]);

            return $this->reply(
                'I could not read the requested records right now. '
                .'No result was assumed; please try again shortly.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Flexible, validated, read-only database question answering
        |--------------------------------------------------------------------------
        */

        try {
            $answer = $this->answerFlexibleDatabaseQuestion($message);

            if ($answer !== null) {
                return $this->reply($answer);
            }
        } catch (QueryException $exception) {
            Log::error('Database assistant query failed.', [
                'exception' => get_class($exception),
            ]);

            return $this->reply(
                'I could not safely complete that database query. '
                .'Please try a more specific question.'
            );
        }

        return $this->reply(
            'I could not find a safe answer. Try asking about a supported '
            .'database module or a general health education topic.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Resident and household lists
    |--------------------------------------------------------------------------
    */

    private function isResidentNameListQuestion(string $message): bool
    {
        $mentionsResidents = preg_match(
            '/\b(residents?|residentes?|registered people|registered persons)\b/',
            $message
        ) === 1;

        $asksForList = preg_match(
            '/\b(all|list|listing|names?|everyone|show|display|'
            .'give me|provide|get|ipakita|ilista|lahat|pangalan)\b/',
            $message
        ) === 1;

        $asksForCount = preg_match(
            '/\b(how many|count|number of|total|ilan|ilang|pila)\b/',
            $message
        ) === 1;

        return $mentionsResidents
            && $asksForList
            && ! $asksForCount
            && preg_match('/\b(households?|sambahayan)\b/', $message) !== 1
            && preg_match(
                '/\b(health visits?|health records?|immunizations?|maternal care|'
                .'child health|senior citizens?|certificates?)\b/',
                $message
            ) !== 1
            && preg_match('/\b(records?|profile|information|details)\b/', $message) !== 1;
    }

    private function residentNamesResponse(): JsonResponse
    {
        $residents = Resident::query()
            ->select([
                'id',
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->limit(500)
            ->get();

        if ($residents->isEmpty()) {
            return $this->reply(
                'There are currently no registered residents in the database.'
            );
        }

        $lines = $residents->values()->map(
            function (Resident $resident, int $index): string {
                return ($index + 1).'. '.$this->residentName($resident);
            }
        );

        return $this->reply(
            "REGISTERED RESIDENTS\n"
            ."Total shown: {$residents->count()}\n\n"
            .$lines->implode("\n")
            ."\n\nSource: residents table."
            .(
                $residents->count() === 500
                    ? "\nShowing up to 500 records."
                    : ''
            )
        );
    }

    private function isHouseholdListQuestion(string $message): bool
    {
        return preg_match('/\b(households?|sambahayan)\b/', $message) === 1
            && preg_match(
                '/\b(list|show|display|all|registered|every|get|provide|ipakita|ilista|lahat)\b/',
                $message
            ) === 1
            && ! $this->isHouseholdCountQuestion($message)
            && ! $this->isHouseholdLookupQuestion($message);
    }

    private function householdListResponse(string $message): JsonResponse
    {
        $households = Household::query()
            ->withCount('residents')
            ->orderBy('household_code')
            ->limit(100)
            ->get();

        if ($households->isEmpty()) {
            return $this->reply(
                'There are currently no registered households.'
            );
        }

        $includeHead = preg_match('/\b(head|household head)\b/', $message) === 1;
        $includeAddress = preg_match('/\b(address|location|saan|tirahan)\b/', $message) === 1;

        $lines = $households->map(function ($household) use (
            $includeHead,
            $includeAddress
        ): string {
            $line = '- Code: '
                .($household->household_code ?: 'Not recorded')
                ."\n  Members: "
                .$household->residents_count
                ."\n  Status: "
                .($household->status ?: 'Not recorded');

            if ($includeHead) {
                $line .= "\n  Head: "
                    .($household->household_head_name ?: 'Not recorded');
            }

            if ($includeAddress) {
                $line .= "\n  Address: "
                    .($household->address ?: 'Not recorded');
            }

            return $line;
        });

        return $this->reply(
            "REGISTERED HOUSEHOLDS\n"
            ."Total shown: {$households->count()}\n\n"
            .$lines->implode("\n\n")
            ."\n\nSource: households and residents tables."
        );
    }

    private function isHouseholdMembershipQuestion(string $message): bool
    {
        return preg_match('/\b(households?|sambahayan)\b/', $message) === 1
            && preg_match(
                '/\b(members?|membership|residents?|residentes?|people|belong|lives in|'
                .'miyembro|kasapi)\b/',
                $message
            ) === 1
            && preg_match(
                '/\b(show|list|who|which|how many|count|number of|'
                .'ipakita|ilista|sino|ilan|ilang|pila)\b/',
                $message
            ) === 1;
    }

    private function householdMembershipResponse(
        string $message,
        bool $tagalog = false
    ): JsonResponse {
        $term = $this->extractSearchTerm($message, [
            'household members',
            'members of household',
            'household membership',
            'residents in household',
            'household residents',
            'members',
            'membership',
            'residents',
            'residente',
            'household code',
            'household',
            'sambahayan',
            'miyembro',
            'kasapi',
        ]);

        if ($term === '') {
            return $this->reply($tagalog
                ? 'Pakibigay ang household code o pangalan ng household head.'
                : 'Please provide a household code or household head name.');
        }

        $households = Household::query()
            ->withCount('residents')
            ->where(function ($query) use ($term) {
                $query->where('household_code', 'like', "%{$term}%")
                    ->orWhere('household_head_name', 'like', "%{$term}%");
            })
            ->limit(2)
            ->get();

        if ($households->isEmpty()) {
            return $this->reply($tagalog
                ? 'Walang nahanap na katugmang sambahayan.'
                : 'No matching household was found.');
        }

        if ($households->count() > 1) {
            return $this->reply($tagalog
                ? 'Maraming sambahayan ang tumugma. Pakibigay ang mas tiyak na code o pangalan.'
                : 'Multiple households matched. Please provide a more specific code or head name.');
        }

        $household = $households->first();

        if ($this->isHouseholdCountQuestion($message)) {
            return $this->reply($tagalog
                ? "Bilang ng rehistradong miyembro: {$household->residents_count}."
                : "Registered household members: {$household->residents_count}.");
        }

        $members = Resident::query()
            ->where('household_id', $household->id)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->limit(100)
            ->get(['first_name', 'middle_name', 'last_name', 'suffix']);

        if ($members->isEmpty()) {
            return $this->reply($tagalog
                ? 'Walang residenteng naka-link sa sambahayang ito.'
                : 'No residents are linked to this household.');
        }

        $lines = $members->map(fn (Resident $resident, int $index) => ($index + 1).'. '.$this->residentName($resident)
        );

        return $this->reply(
            ($tagalog
                ? "MGA MIYEMBRO NG SAMBAHAYAN\n"
                : "HOUSEHOLD MEMBERS\n")
            ."Household code: {$household->household_code}\n\n"
            .$lines->implode("\n")
            .($members->count() === 100
                ? ($tagalog
                    ? "\n\nIpinapakita ang unang 100 rekord."
                    : "\n\nShowing the first 100 records.")
                : '')
        );
    }

    private function isSeniorCitizenCountQuestion(string $message): bool
    {
        return preg_match(
            '/\b(senior citizens?|seniors?|elderly people|'
            .'elderly residents|older adults|matatanda)\b/',
            $message
        ) === 1
            && preg_match(
                '/\b(how many|count|number of|total|quantity|registered|ilan|ilang|pila)\b/',
                $message
            ) === 1
            && ! $this->isSeniorCitizenListQuestion($message);
    }

    private function isSeniorCitizenListQuestion(string $message): bool
    {
        return preg_match(
            '/\b(senior citizens?|seniors?|elderly residents?|older adults|matatanda)\b/',
            $message
        ) === 1
            && preg_match(
                '/\b(list|show|display|all|names?|provide|get|ipakita|ilista|lahat)\b/',
                $message
            ) === 1
            && preg_match(
                '/\b(how many|count|number of|total|ilan|ilang|pila)\b/',
                $message
            ) !== 1;
    }

    private function seniorCitizenListResponse(): JsonResponse
    {
        $records = SeniorCitizen::query()
            ->orderBy('id')
            ->limit(100)
            ->get();

        if ($records->isEmpty()) {
            return $this->reply(
                'There are currently no registered senior citizen records.'
            );
        }

        $residentIds = $records
            ->pluck('resident_id')
            ->filter()
            ->unique()
            ->values();

        $residents = Resident::query()
            ->whereIn('id', $residentIds)
            ->get()
            ->keyBy('id');

        $lines = $records->values()->map(
            function ($record, int $index) use ($residents): string {
                $resident = $residents->get($record->resident_id);

                $name = $resident
                    ? $this->residentName($resident)
                    : 'Resident record not linked';

                return ($index + 1).'. '.$name
                    ."\n   Status: "
                    .($record->senior_status ?: 'Not recorded');
            }
        );

        return $this->reply(
            "REGISTERED SENIOR CITIZENS\n"
            ."Total shown: {$records->count()}\n\n"
            .$lines->implode("\n\n")
            ."\n\nSource: senior_citizens and residents tables."
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Inventory, schedules, announcements, certificates
    |--------------------------------------------------------------------------
    */

    private function inventoryResponse(
        bool $expired,
        bool $tagalog = false
    ): JsonResponse {
        $today = Carbon::today();

        $query = MedicalInventory::query();

        if ($expired) {
            $query->whereDate('expiry_date', '<', $today);
        } else {
            $query->whereDate('expiry_date', '>=', $today)
                ->whereDate(
                    'expiry_date',
                    '<=',
                    $today->copy()->addDays(30)
                );
        }

        $items = $query->orderBy('expiry_date')->limit(20)->get();

        if ($items->isEmpty()) {
            return $this->reply($tagalog
                ? ($expired
                    ? 'Walang nahanap na expired na gamot o medical inventory.'
                    : 'Walang nakatalang imbentaryong mag-e-expire sa loob ng 30 araw.')
                : ($expired
                    ? 'No expired medical inventory items were found.'
                    : 'No inventory items are recorded as expiring within the next 30 days.'));
        }

        $lines = $items->map(function ($item): string {
            return '- '.($item->medicine_name ?? 'Unnamed item')
                .' | Quantity: '.($item->quantity ?? 'Not specified')
                .' | Expiry: '.$this->formatDate($item->expiry_date);
        });

        return $this->reply(
            ($tagalog
                ? ($expired ? "MGA EXPIRED NA GAMOT\n\n" : "MAG-E-EXPIRE SA LOOB NG 30 ARAW\n\n")
                : ($expired ? "EXPIRED MEDICAL INVENTORY\n\n" : "INVENTORY EXPIRING WITHIN 30 DAYS\n\n"))
            .$lines->implode("\n")
            .($tagalog
                ? "\n\nPinagmulan: medical_inventories table."
                : "\n\nSource: medical_inventories table.")
        );
    }

    private function isMedicalInventoryListQuestion(string $message): bool
    {
        if (
            $this->isExpiredInventoryQuestion($message)
            || $this->isExpiringInventoryQuestion($message)
        ) {
            return false;
        }

        return preg_match(
            '/\b(show inventory|medical inventory|show medical inventory|'
            .'medical supplies|show medicines|show medicine stock|'
            .'medicine stock|stock of medicine|mga supply)\b/',
            $message
        ) === 1
            || preg_match(
                '/\b(ipakita|ilista)\b.*\b(stock|gamot|mga gamot)\b/',
                $message
            ) === 1;
    }

    private function medicalInventoryListResponse(): JsonResponse
    {
        $items = MedicalInventory::query()
            ->orderBy('medicine_name')
            ->limit(20)
            ->get(['medicine_name', 'quantity', 'expiry_date']);

        if ($items->isEmpty()) {
            return $this->reply('No medical inventory items are currently recorded.');
        }

        $lines = $items->map(fn ($item) => '- '.$item->medicine_name
            .' | Quantity: '.$item->quantity
            .' | Expiry: '.$this->formatDate($item->expiry_date)
        );

        return $this->reply(
            "MEDICAL INVENTORY (showing up to 20)\n\n"
            .$lines->implode("\n")
            ."\n\nSource: medical_inventories table."
        );
    }

    private function upcomingEventsResponse(
        string $message,
        bool $tagalog = false
    ): JsonResponse {
        $today = Carbon::today();
        $query = Event::query()
            ->whereDate('event_date', '>=', $today);

        if (preg_match('/\b(this week|sa linggong ito|ngayong linggo)\b/', $message) === 1) {
            $query->whereDate('event_date', '<=', $today->copy()->endOfWeek());
        }

        $events = $query->orderBy('event_date')->limit(10)->get();

        if ($events->isEmpty()) {
            return $this->reply(
                $tagalog
                    ? 'Walang nakitang paparating na iskedyul.'
                    : 'No upcoming events or schedules were found.'
            );
        }

        $lines = $events->map(function ($event): string {
            $time = filled($event->start_time)
                ? Carbon::parse($event->start_time)->format('g:i A')
                : 'Time not specified';

            return '- '.$event->title
                ."\n  Type: ".($event->event_type ?: 'Not specified')
                ."\n  Date: ".$this->formatDate($event->event_date)
                ."\n  Time: ".$time
                ."\n  Location: ".($event->location ?: 'Not specified');
        });

        return $this->reply(
            ($tagalog ? "MGA PAPARATING NA ISKEDYUL\n\n" : "UPCOMING EVENTS AND SCHEDULES\n\n")
            .$lines->implode("\n\n")
            .($tagalog
                ? "\n\nPinagmulan: events table."
                : "\n\nSource: events table.")
        );
    }

    private function announcementsResponse(bool $tagalog = false): JsonResponse
    {
        $announcements = Announcement::query()
            ->whereRaw('LOWER(status) = ?', ['published'])
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        if ($announcements->isEmpty()) {
            return $this->reply($tagalog
                ? 'Walang nailathalang anunsyo sa kasalukuyan.'
                : 'No published announcements were found.');
        }

        $lines = $announcements->map(function ($announcement): string {
            return '- '.$announcement->title
                ."\n  Priority: "
                .($announcement->priority ?: 'Normal')
                ."\n  Published: "
                .$this->formatDate($announcement->published_at)
                ."\n  Message: ".$announcement->message;
        });

        return $this->reply(
            ($tagalog ? "MGA NAILATHALANG ANUNSYO\n\n" : "PUBLISHED ANNOUNCEMENTS\n\n")
            .$lines->implode("\n\n")
            .($tagalog
                ? "\n\nPinagmulan: announcements table."
                : "\n\nSource: announcements table.")
        );
    }

    private function isCertificateStatusQuestion(string $message): bool
    {
        return preg_match('/\b(certificates?|sertipiko)\b/', $message) === 1
            && preg_match(
                '/\b(status|statuses|issued|cancelled|canceled|katayuan)\b/',
                $message
            ) === 1;
    }

    private function isAnnouncementStatusQuestion(string $message): bool
    {
        return preg_match(
            '/\b(announcements?|community notices?|anunsyo|abiso)\b/',
            $message
        ) === 1
            && preg_match('/\b(status|statuses|katayuan|estado)\b/', $message) === 1;
    }

    private function announcementStatusResponse(bool $tagalog = false): JsonResponse
    {
        $statuses = Announcement::query()
            ->select('status')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        if ($statuses->isEmpty()) {
            return $this->reply($tagalog
                ? 'Walang nakatalang status ng anunsyo.'
                : 'No announcement statuses are currently recorded.');
        }

        $lines = $statuses->map(fn ($status) => '- '.($status->status ?: ($tagalog ? 'Hindi nakatala' : 'Not recorded'))
            .': '.$status->total
        );

        return $this->reply(
            ($tagalog ? "KATAYUAN NG MGA ANUNSYO\n\n" : "ANNOUNCEMENT STATUS\n\n")
            .$lines->implode("\n")
            .($tagalog
                ? "\n\nPinagmulan: announcements table."
                : "\n\nSource: announcements table.")
        );
    }

    private function certificateStatusResponse(): JsonResponse
    {
        $statuses = Certificate::query()
            ->select('status')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        if ($statuses->isEmpty()) {
            return $this->reply(
                'No certificate records or statuses are currently recorded.'
            );
        }

        $lines = $statuses->map(
            fn ($status) => '- '.($status->status ?: 'Not recorded')
                .': '.$status->total
        );

        return $this->reply(
            "CERTIFICATE STATUS\n\n"
            .$lines->implode("\n")
            ."\n\nSource: certificates table."
        );
    }

    private function isCertificateCountQuestion(string $message): bool
    {
        return preg_match('/\b(certificates?|sertipiko)\b/', $message) === 1
            && preg_match(
                '/\b(how many|count|number of|total|ilan|ilang|pila)\b/',
                $message
            ) === 1;
    }

    private function certificateCountResponse(): JsonResponse
    {
        $total = Certificate::count();

        return $this->reply(
            "There are {$total} certificate record(s) in the database.\n\n"
            .'Source: certificates table.'
        );
    }

    private function householdLookupResponse(string $message): JsonResponse
    {
        $term = $this->extractSearchTerm($message, [
            'household code',
            'household head',
            'households',
            'household',
            'sambahayan',
            'sino ang',
            'saan nakatira',
        ]);

        if ($term === '') {
            return $this->reply(
                'Please provide a household code, household head name, or address.'
            );
        }

        $households = Household::query()
            ->withCount('residents')
            ->where(function ($query) use ($term) {
                $query->where('household_code', 'like', "%{$term}%")
                    ->orWhere('household_head_name', 'like', "%{$term}%")
                    ->orWhere('address', 'like', "%{$term}%");
            })
            ->limit(2)
            ->get();

        if ($households->isEmpty()) {
            return $this->reply('No matching household was found.');
        }

        if ($households->count() > 1) {
            return $this->reply(
                'I found multiple households matching that search. '
                .'Please provide a more specific household code or head name.'
            );
        }

        $household = $households->first();
        $wantsContact = preg_match('/\b(contact|phone|telephone|telepono)\b/', $message) === 1;
        $wantsAddress = preg_match('/\b(address|saan nakatira|tirahan)\b/', $message) === 1;

        return $this->reply(
            "HOUSEHOLD INFORMATION\n\n"
            ."Code: {$household->household_code}\n"
            .'Status: '.($household->status ?: 'Not specified')."\n"
            ."Registered residents: {$household->residents_count}"
            .($wantsAddress
                ? "\nAddress: ".($household->address ?: 'Not specified')
                : '')
            .(preg_match('/\b(head|household head|sino ang)\b/', $message) === 1
                ? "\nHead: ".($household->household_head_name ?: 'Not specified')
                : '')
            .($wantsContact
                ? "\nContact: ".($household->contact_number ?: 'Not specified')
                : '')
            ."\n\n"
            .'Source: households and residents tables.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Flexible read-only database query planner
    |--------------------------------------------------------------------------
    */

    private function answerFlexibleDatabaseQuestion(string $message): ?string
    {
        $schema = $this->getPermittedSchema();

        if (empty($schema['tables'])) {
            return 'No database tables are available to your account.';
        }

        $plannerPrompt = <<<'PROMPT'
You are a read-only database query planner for a Laravel/MySQL barangay
health center records system.

Return ONLY a valid JSON object. Never output SQL.

Database query format:
{
  "type": "database",
  "table": "residents",
  "select": ["residents.id", "residents.first_name", "residents.last_name"],
  "joins": [],
  "filters": [],
  "order_by": [{"column": "residents.last_name", "direction": "asc"}],
  "limit": 20,
  "aggregate": null
}

Aggregate example:
"aggregate": {
  "function": "count",
  "column": "residents.id",
  "alias": "total"
}

Allowed aggregates: count, sum, avg, min, max.
Allowed operators: =, !=, >, >=, <, <=, like, not like, in, not in,
is null, is not null.

Join example:
{
  "table": "households",
  "first": "residents.household_id",
  "operator": "=",
  "second": "households.id",
  "type": "left"
}

Use only the provided permitted schema and relationships.
Never invent table or column names.
Never perform write operations.
Never request secrets, passwords, or tokens.
Do not return all records unless the user clearly requests a list.
For a person's full name, use all meaningful name tokens in the search.
For general help, health education, or greetings, return
{"type":"general","answer":"..."} and answer in the user's language.
For health education, provide general information only, do not diagnose or
prescribe, recommend professional or emergency care when appropriate, and do
not claim to have checked records or consulted an authoritative source.
If unavailable, return {"type":"unsupported","reason":"That information is not available in the permitted database schema."}
PROMPT;

        $planText = $this->callOllama([
            [
                'role' => 'system',
                'content' => $plannerPrompt
                    ."\n\nPermitted database schema:\n"
                    .json_encode(
                        $schema,
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    ),
            ],
            ['role' => 'user', 'content' => $message],
        ], true);

        if ($planText === null) {
            return 'The local AI assistant is temporarily unavailable. '
                .'Please try again shortly, or ask a database question using '
                .'a supported module.';
        }

        $plan = $this->decodeJsonObject($planText);

        if (! is_array($plan)) {
            return 'I could not safely interpret that database question. '
                .'Please try asking it more specifically.';
        }

        $type = $plan['type'] ?? 'general';

        if ($type === 'general') {
            $answer = $plan['answer'] ?? null;

            return is_string($answer) && trim($answer) !== ''
                ? trim($answer)
                : 'I could not safely interpret that question. Please ask '
                    .'about a supported database module or a general health '
                    .'education topic.';
        }

        if ($type === 'unsupported') {
            return 'That information is not available through the assistant. '
                .'Try asking about residents, households, schedules, '
                .'announcements, inventory, certificates, or records your '
                .'role is authorized to view.';
        }

        if ($type !== 'database') {
            return 'I could not determine how to retrieve that information safely.';
        }

        $result = $this->executeValidatedQueryPlan($plan, $schema);

        if (isset($result['error'])) {
            Log::warning('Database assistant rejected a query plan.', [
                'reason' => $result['error'],
            ]);

            return 'I could not safely run that database query. '
                .'Please try a more specific question.';
        }

        if (! empty($result['aggregate'])) {
            return "Database query result:\n"
                .($result['data']['label'] ?? 'Result')
                .': '
                .($result['data']['value'] ?? 'No result')
                ."\n\nSource: Current database records.";
        }

        $rows = $result['data'];

        if ($rows->isEmpty()) {
            return 'No matching records were found in the available database tables.';
        }

        $lines = $rows->map(function ($row): string {
            $fields = [];

            foreach ((array) $row as $column => $value) {
                $label = str_replace('__', '.', (string) $column);
                $displayValue = $value === null
                    ? 'Not recorded'
                    : (is_scalar($value) ? (string) $value : 'Value unavailable');

                $fields[] = "{$label}: {$displayValue}";
            }

            return '- '.implode("\n  ", $fields);
        });

        return "DATABASE RESULTS (current records)\n\n"
            .$lines->implode("\n\n");
    }

    private function getPermittedSchema(): array
    {
        $role = auth()->user()?->role;
        $tables = [];

        foreach (Schema::getTableListing(null, false) as $tableName) {
            if (
                ! is_string($tableName)
                || ! in_array($tableName, self::QUERYABLE_TABLES, true)
                || in_array($tableName, self::BLOCKED_TABLES, true)
            ) {
                continue;
            }

            if (
                in_array($tableName, self::CLINICAL_TABLES, true)
                && ! $this->canViewClinicalRecords()
            ) {
                continue;
            }

            if (
                $tableName === 'medical_inventories'
                && ! $this->canViewMedicalInventory()
            ) {
                continue;
            }

            if ($tableName === 'users' && $role !== 'System Administrator') {
                continue;
            }

            if ($tableName === 'audit_logs' && $role !== 'System Administrator') {
                continue;
            }

            $columns = array_values(array_filter(
                Schema::getColumnListing($tableName),
                fn ($column) => ! $this->isBlockedQueryColumn($column)
            ));

            if ($columns !== []) {
                $tables[$tableName] = $columns;
            }
        }

        return [
            'tables' => $tables,
            'relationships' => $this->knownRelationships($tables),
        ];
    }

    private function knownRelationships(array $tables): array
    {
        $relationships = [
            ['residents.household_id', 'households.id'],
            ['health_records.resident_id', 'residents.id'],
            ['health_visits.resident_id', 'residents.id'],
            ['immunizations.resident_id', 'residents.id'],
            ['maternal_cares.resident_id', 'residents.id'],
            ['child_healths.resident_id', 'residents.id'],
            ['senior_citizens.resident_id', 'residents.id'],
            ['certificates.resident_id', 'residents.id'],
            ['announcement_recipients.announcement_id', 'announcements.id'],
            ['announcement_recipients.resident_id', 'residents.id'],
            ['announcement_sms_deliveries.announcement_id', 'announcements.id'],
            ['announcements.created_by', 'users.id'],
            ['events.created_by', 'users.id'],
            ['audit_logs.user_id', 'users.id'],
            ['announcement_sms_deliveries.household_head_resident_id', 'residents.id'],
        ];

        $available = [];

        foreach ($relationships as [$left, $right]) {
            [$leftTable, $leftColumn] = explode('.', $left, 2);
            [$rightTable, $rightColumn] = explode('.', $right, 2);

            if (
                isset($tables[$leftTable], $tables[$rightTable])
                && in_array($leftColumn, $tables[$leftTable], true)
                && in_array($rightColumn, $tables[$rightTable], true)
            ) {
                $available[] = [
                    'left' => $left,
                    'right' => $right,
                ];
            }
        }

        return $available;
    }

    private function executeValidatedQueryPlan(
        array $plan,
        array $schema
    ): array {
        $availableTables = $schema['tables'] ?? [];
        $baseTable = $plan['table'] ?? null;

        if (! is_string($baseTable) || ! isset($availableTables[$baseTable])) {
            return ['error' => 'Invalid or unauthorized base table.'];
        }

        $query = DB::table($baseTable);
        $joinedTables = [$baseTable => true];
        $joins = $plan['joins'] ?? [];

        if (! is_array($joins) || count($joins) > 5) {
            return ['error' => 'Invalid join definition.'];
        }

        foreach ($joins as $join) {
            if (! is_array($join)) {
                return ['error' => 'Invalid join entry.'];
            }

            $joinTable = $join['table'] ?? null;
            $first = $join['first'] ?? null;
            $second = $join['second'] ?? null;
            $operator = $join['operator'] ?? '=';
            $type = strtolower((string) ($join['type'] ?? 'left'));

            if (
                ! is_string($joinTable)
                || ! isset($availableTables[$joinTable])
                || isset($joinedTables[$joinTable])
            ) {
                return ['error' => 'Unauthorized or duplicate join table.'];
            }

            if (
                ! in_array($type, ['left', 'inner'], true)
                || $operator !== '='
            ) {
                return ['error' => 'Unsupported join type or operator.'];
            }

            if (
                ! $this->isPermittedQualifiedColumn(
                    $first,
                    $availableTables,
                    $joinedTables
                )
                || ! $this->isPermittedQualifiedColumn(
                    $second,
                    $availableTables,
                    array_merge($joinedTables, [$joinTable => true])
                )
            ) {
                return ['error' => 'Invalid join column.'];
            }

            $firstTable = explode('.', $first, 2)[0];
            $secondTable = explode('.', $second, 2)[0];

            if (
                (! isset($joinedTables[$firstTable]) && $firstTable !== $joinTable)
                || (! isset($joinedTables[$secondTable]) && $secondTable !== $joinTable)
            ) {
                return ['error' => 'Join references an unavailable table.'];
            }

            $allowed = false;

            foreach ($schema['relationships'] ?? [] as $relationship) {
                if (
                    ($first === $relationship['left'] && $second === $relationship['right'])
                    || ($first === $relationship['right'] && $second === $relationship['left'])
                ) {
                    $allowed = true;
                    break;
                }
            }

            if (! $allowed) {
                return ['error' => 'Join is not a recognized relationship.'];
            }

            if ($type === 'inner') {
                $query->join($joinTable, $first, '=', $second);
            } else {
                $query->leftJoin($joinTable, $first, '=', $second);
            }

            $joinedTables[$joinTable] = true;
        }

        $filters = $plan['filters'] ?? [];

        if (! is_array($filters) || count($filters) > 20) {
            return ['error' => 'Invalid filter definition.'];
        }

        try {
            if ($filters !== []) {
                $query->where(function (QueryBuilder $nested) use (
                    $filters,
                    $availableTables,
                    $joinedTables
                ) {
                    foreach ($filters as $index => $filter) {
                        if (! is_array($filter)) {
                            throw new \InvalidArgumentException('Invalid filter entry.');
                        }

                        $column = $filter['column'] ?? null;
                        $operator = strtolower(
                            trim((string) ($filter['operator'] ?? '='))
                        );

                        if (! $this->isPermittedQualifiedColumn(
                            $column,
                            $availableTables,
                            $joinedTables
                        )) {
                            throw new \InvalidArgumentException('Invalid filter column.');
                        }

                        $allowedOperators = [
                            '=', '!=', '>', '>=', '<', '<=',
                            'like', 'not like', 'in', 'not in',
                            'is null', 'is not null',
                        ];

                        if (! in_array($operator, $allowedOperators, true)) {
                            throw new \InvalidArgumentException('Invalid filter operator.');
                        }

                        $boolean = strtolower((string) ($filter['boolean'] ?? 'and'));

                        if (! in_array($boolean, ['and', 'or'], true) || $index === 0) {
                            $boolean = 'and';
                        }

                        $value = $filter['value'] ?? null;

                        if ($operator === 'is null') {
                            $boolean === 'or'
                                ? $nested->orWhereNull($column)
                                : $nested->whereNull($column);

                            continue;
                        }

                        if ($operator === 'is not null') {
                            $boolean === 'or'
                                ? $nested->orWhereNotNull($column)
                                : $nested->whereNotNull($column);

                            continue;
                        }

                        if (in_array($operator, ['in', 'not in'], true)) {
                            if (
                                ! is_array($value)
                                || $value === []
                                || count($value) > 20
                            ) {
                                throw new \InvalidArgumentException('Invalid filter list.');
                            }

                            foreach ($value as $item) {
                                if (
                                    (! is_scalar($item) && $item !== null)
                                    || (is_string($item) && mb_strlen($item) > 500)
                                ) {
                                    throw new \InvalidArgumentException('Invalid filter list value.');
                                }
                            }

                            if ($operator === 'in') {
                                $boolean === 'or'
                                    ? $nested->orWhereIn($column, $value)
                                    : $nested->whereIn($column, $value);
                            } else {
                                $boolean === 'or'
                                    ? $nested->orWhereNotIn($column, $value)
                                    : $nested->whereNotIn($column, $value);
                            }

                            continue;
                        }

                        if (! is_scalar($value) && $value !== null) {
                            throw new \InvalidArgumentException('Invalid filter value.');
                        }

                        if (is_string($value) && mb_strlen($value) > 500) {
                            throw new \InvalidArgumentException('Filter value is too long.');
                        }

                        if (in_array($operator, ['like', 'not like'], true)) {
                            $value = (string) $value;

                            if (! str_contains($value, '%')) {
                                $value = '%'.$value.'%';
                            }
                        }

                        if ($boolean === 'or') {
                            $nested->orWhere($column, $operator, $value);
                        } else {
                            $nested->where($column, $operator, $value);
                        }
                    }
                });
            }
        } catch (\InvalidArgumentException $exception) {
            return ['error' => $exception->getMessage()];
        }

        $aggregate = $plan['aggregate'] ?? null;

        if ($aggregate !== null) {
            if (! is_array($aggregate)) {
                return ['error' => 'Invalid aggregate definition.'];
            }

            $function = strtolower((string) ($aggregate['function'] ?? 'count'));
            $column = $aggregate['column'] ?? null;

            if (! in_array($function, ['count', 'sum', 'avg', 'min', 'max'], true)) {
                return ['error' => 'Unsupported aggregate function.'];
            }

            if (! $this->isPermittedQualifiedColumn(
                $column,
                $availableTables,
                $joinedTables
            )) {
                return ['error' => 'Invalid aggregate column.'];
            }

            $value = match ($function) {
                'count' => $this->runReadQuery(
                    fn () => $query->count($column)
                ),
                'sum' => $this->runReadQuery(
                    fn () => $query->sum($column)
                ),
                'avg' => $this->runReadQuery(
                    fn () => $query->avg($column)
                ),
                'min' => $this->runReadQuery(
                    fn () => $query->min($column)
                ),
                'max' => $this->runReadQuery(
                    fn () => $query->max($column)
                ),
            };

            return [
                'aggregate' => true,
                'data' => [
                    'label' => ucfirst($function).' of '.$column,
                    'value' => $value ?? 0,
                ],
            ];
        }

        $select = $plan['select'] ?? [];

        if (
            ! is_array($select)
            || $select === []
            || count($select) > self::MAX_SELECTED_COLUMNS
        ) {
            return ['error' => 'Invalid selected columns.'];
        }

        $safeSelect = [];

        foreach ($select as $column) {
            if (! $this->isPermittedQualifiedColumn(
                $column,
                $availableTables,
                $joinedTables
            )) {
                return ['error' => 'Invalid selected column.'];
            }

            $safeSelect[] = $column.' as '.str_replace('.', '__', $column);
        }

        $query->select($safeSelect);

        $orderBy = $plan['order_by'] ?? [];

        if (! is_array($orderBy) || count($orderBy) > 5) {
            return ['error' => 'Invalid sorting definition.'];
        }

        foreach ($orderBy as $order) {
            if (! is_array($order)) {
                return ['error' => 'Invalid sorting entry.'];
            }

            $column = $order['column'] ?? null;
            $direction = strtolower((string) ($order['direction'] ?? 'asc'));

            if (
                ! $this->isPermittedQualifiedColumn(
                    $column,
                    $availableTables,
                    $joinedTables
                )
                || ! in_array($direction, ['asc', 'desc'], true)
            ) {
                return ['error' => 'Invalid sorting column or direction.'];
            }

            $query->orderBy($column, $direction);
        }

        $limit = filter_var($plan['limit'] ?? 20, FILTER_VALIDATE_INT);

        if ($limit === false || $limit < 1) {
            $limit = 20;
        }

        return [
            'aggregate' => false,
            'data' => $this->runReadQuery(
                fn () => $query->limit(min($limit, self::MAX_QUERY_ROWS))->get()
            ),
        ];
    }

    private function isPermittedQualifiedColumn(
        mixed $qualifiedColumn,
        array $availableTables,
        array $joinedTables
    ): bool {
        if (
            ! is_string($qualifiedColumn)
            || ! preg_match(
                '/^([A-Za-z_][A-Za-z0-9_]*)\.([A-Za-z_][A-Za-z0-9_]*)$/',
                $qualifiedColumn,
                $matches
            )
        ) {
            return false;
        }

        $table = $matches[1];
        $column = $matches[2];

        return isset($availableTables[$table])
            && isset($joinedTables[$table])
            && in_array($column, $availableTables[$table], true)
            && ! $this->isBlockedQueryColumn($column);
    }

    private function isBlockedQueryColumn(string $column): bool
    {
        $column = mb_strtolower($column);

        return in_array($column, self::BLOCKED_COLUMNS, true)
            || preg_match(
                '/(?:^|_)(?:password|token|secret|credential|private_key)(?:$|_)/',
                $column
            ) === 1;
    }

    private function runReadQuery(callable $query): mixed
    {
        $connection = DB::connection();

        if ($connection->getDriverName() !== 'mysql') {
            return $query();
        }

        $previousTimeout = (int) $connection
            ->selectOne('SELECT @@SESSION.max_execution_time AS timeout_ms')
            ->timeout_ms;
        $timeout = max(
            100,
            min(10000, (int) config('database_assistant.query_timeout_ms', 3000))
        );

        $connection->statement(
            'SET SESSION max_execution_time = '.$timeout
        );

        try {
            return $query();
        } finally {
            $connection->statement(
                'SET SESSION max_execution_time = '.$previousTimeout
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Resident profile lookup
    |--------------------------------------------------------------------------
    */

    private function residentProfileResponse(string $message): JsonResponse
    {
        $normalized = $this->normalizeMessage($message);
        $mentionsRecordType = preg_match(
            '/\b(health records?|health visits?|medical history|immunizations?|'
            .'maternal care|child health|senior citizens?|certificates?)\b/',
            $normalized
        ) === 1;
        $showHealthRecord = preg_match(
            '/\b(health records?|medical history|blood type|allergies|'
            .'chronic conditions|current medications)\b/',
            $normalized
        ) === 1;
        $showHealthVisits = preg_match('/\b(health visits?|visit records?)\b/', $normalized) === 1;
        $showImmunizations = preg_match('/\b(immunizations?|vaccinations?|vaccines?)\b/', $normalized) === 1;
        $showMaternalCare = preg_match('/\b(maternal care|prenatal|pregnancy)\b/', $normalized) === 1;
        $showChildHealth = preg_match('/\b(child health|child records?|nutrition)\b/', $normalized) === 1;
        $showSeniorCitizen = preg_match('/\b(senior citizens?|elderly|osca)\b/', $normalized) === 1;
        $showCertificates = preg_match('/\b(certificates?)\b/', $normalized) === 1;

        if (
            preg_match('/\b(records?|record types?)\b/', $normalized) === 1
            && ! $mentionsRecordType
        ) {
            return $this->reply(
                'Which record do you mean: health records, visits, '
                .'immunizations, maternal care, child health, senior citizen '
                .'records, or certificates?'
            );
        }

        $term = $this->extractSearchTerm($message, [
            'resident records', 'resident record', 'residents', 'resident',
            'registered people', 'registered persons', 'residente', 'mga residente',
            'health records', 'health record', 'health visits', 'health visit',
            'medical history', 'immunizations', 'immunization',
            'maternal care', 'child health', 'senior citizen',
            'certificates', 'certificate', 'sino si', 'hanapin ang',
            'ipakita ang', 'saan nakatira si', 'nasaan si',
            'contact number', 'phone number', 'email address',
        ]);

        if ($term === '') {
            return $this->reply(
                'Please provide the resident’s name so I can search the database.'
            );
        }

        $tokens = array_values(array_filter(
            preg_split('/\s+/', trim($term)) ?: [],
            fn ($token) => $token !== ''
        ));

        $fullNameExpression =
            "TRIM(CONCAT_WS(' ', first_name, middle_name, last_name, suffix))";

        $residents = Resident::query()
            ->where(function (EloquentBuilder $query) use (
                $tokens,
                $term,
                $fullNameExpression
            ) {
                $query->whereRaw("{$fullNameExpression} = ?", [$term]);

                $query->orWhere(function (EloquentBuilder $nameQuery) use ($tokens) {
                    foreach ($tokens as $token) {
                        $nameQuery->where(function (EloquentBuilder $tokenQuery) use ($token) {
                            $tokenQuery->where('first_name', 'like', "%{$token}%")
                                ->orWhere('middle_name', 'like', "%{$token}%")
                                ->orWhere('last_name', 'like', "%{$token}%")
                                ->orWhere('suffix', 'like', "%{$token}%");
                        });
                    }
                });
            })
            ->orderByRaw("CASE WHEN {$fullNameExpression} = ? THEN 0 ELSE 1 END", [$term])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->limit(6)
            ->get();

        if ($residents->isEmpty()) {
            return $this->reply(
                "No resident matched \"{$term}\". Check the spelling and try again."
            );
        }

        if ($residents->count() > 1) {
            $matches = $residents->take(5)->map(
                fn ($resident) => '- '.$this->residentName($resident)
                    .' (Resident ID: '.$resident->id.')'
            );

            return $this->reply(
                "I found multiple possible matches. Please specify which resident you mean:\n\n"
                .$matches->implode("\n")
            );
        }

        $resident = $residents->first();
        $canViewClinical = $this->canViewClinicalRecords();
        $canViewContacts = in_array(
            auth()->user()?->role,
            ['System Administrator', 'Health Worker', 'Official'],
            true
        );

        $sections = [];

        $sections[] = "RESIDENT PROFILE\n"
            ."Resident ID: {$resident->id}\n"
            .'Name: '.$this->residentName($resident)."\n"
            .'Status: '.($resident->status ?: 'Not specified');

        if (preg_match('/\b(birth date|birthday|age|gender|sex|civil status)\b/', $normalized) === 1) {
            $sections[] = "DEMOGRAPHIC INFORMATION\n"
                .'Birth date: '.$this->formatDate($resident->birth_date)."\n"
                .'Gender: '.($resident->gender ?: 'Not specified')."\n"
                .'Civil status: '.($resident->civil_status ?: 'Not specified');
        }

        if ($canViewContacts) {
            $contactFields = [];

            if (preg_match('/\b(contact|phone|telephone|telepono)\b/', $normalized) === 1) {
                $contactFields[] = 'Contact number: '
                    .($resident->contact_number ?: 'Not specified');
            }

            if (preg_match('/\b(email)\b/', $normalized) === 1) {
                $contactFields[] = 'Email: '
                    .($resident->email ?: 'Not specified');
            }

            if (preg_match('/\b(address|saan nakatira|tirahan)\b/', $normalized) === 1) {
                $contactFields[] = 'Address: '
                    .($resident->household_address ?: 'Not specified');
            }

            if ($contactFields !== []) {
                $sections[] = "CONTACT INFORMATION\n"
                    .implode("\n", $contactFields);
            }
        }

        $household = $resident->household_id
            ? Household::find($resident->household_id)
            : null;

        if ($household) {
            $sections[] = "HOUSEHOLD INFORMATION\n"
                .'Household code: '.($household->household_code ?: 'Not specified')."\n"
                .'Household status: '.($household->status ?: 'Not specified');

            if (preg_match('/\b(head|sino ang household head)\b/', $normalized) === 1) {
                $sections[count($sections) - 1] .= "\nHousehold head: "
                    .($household->household_head_name ?: 'Not specified');
            }

            if (preg_match('/\b(address|saan nakatira|tirahan)\b/', $normalized) === 1) {
                $sections[count($sections) - 1] .= "\nHousehold address: "
                    .($household->address ?: 'Not specified');
            }
        }

        if ($canViewClinical && $showHealthRecord) {
            if (! Schema::hasTable('health_records')) {
                $sections[] = "HEALTH RECORD\n"
                    .'Health records are not available in the current database schema.';
            } else {
                $healthRecord = HealthRecord::where('resident_id', $resident->id)->first();

                $sections[] = "HEALTH RECORD\n"
                    .($healthRecord
                        ? 'Blood type: '.($healthRecord->blood_type ?: 'Not recorded')."\n"
                            .'Allergies: '.($healthRecord->allergies ?: 'Not recorded')."\n"
                            .'Chronic conditions: '.($healthRecord->chronic_conditions ?: 'Not recorded')."\n"
                            .'Medical history: '.($healthRecord->medical_history ?: 'Not recorded')."\n"
                            .'Current medications: '.($healthRecord->current_medications ?: 'Not recorded')."\n"
                            .'Notes: '.($healthRecord->notes ?: 'Not recorded')
                        : 'No health record is registered.');
            }
        }

        if ($canViewClinical && $showHealthVisits) {
            if (! Schema::hasTable('health_visits')) {
                $sections[] = "HEALTH VISITS\n"
                    .'Health visit records are not available in the current database schema.';
            } else {
                $visits = HealthVisit::where('resident_id', $resident->id)
                    ->orderByDesc('visit_date')->limit(10)->get();

                $sections[] = 'HEALTH VISITS (Total: '
                    .HealthVisit::where('resident_id', $resident->id)->count()
                    ."; showing up to 10)\n"
                    .($visits->isEmpty()
                        ? 'No health visits are registered.'
                        : $visits->map(fn ($visit) => '- '.$this->formatDate($visit->visit_date)
                            .' | Type: '.($visit->visit_type ?: 'Not specified')
                            .' | Complaint: '.($visit->chief_complaint ?: 'Not recorded')
                            .' | Assessment: '.($visit->assessment ?: 'Not recorded')
                            .' | Treatment: '.($visit->treatment ?: 'Not recorded')
                        )->implode("\n"));
            }
        }

        if ($canViewClinical && $showImmunizations) {
            $immunizations = Immunization::where('resident_id', $resident->id)
                ->orderByDesc('date_administered')->limit(10)->get();

            $sections[] = "IMMUNIZATIONS\n"
                .($immunizations->isEmpty()
                    ? 'No immunization records are registered.'
                    : $immunizations->map(fn ($item) => '- '.($item->vaccine_name ?: 'Vaccine not specified')
                        .' | Date: '.$this->formatDate($item->date_administered)
                        .' | Dose: '.($item->dose_number ?? 'Not specified')
                        .' | Next dose: '.$this->formatDate($item->next_dose_date)
                    )->implode("\n"));
        }

        if ($canViewClinical && $showMaternalCare) {
            $maternal = MaternalCare::where('resident_id', $resident->id)
                ->orderByDesc('id')->limit(5)->get();

            $sections[] = "MATERNAL CARE\n"
                .($maternal->isEmpty()
                    ? 'No maternal care records are registered.'
                    : $maternal->map(fn ($item) => '- Pregnancy status: '.($item->pregnancy_status ?: 'Not specified')
                        .' | Expected delivery: '.$this->formatDate($item->expected_delivery_date)
                        .' | Last prenatal visit: '.$this->formatDate($item->last_prenatal_visit)
                        .' | Prenatal visits: '.($item->prenatal_visit_count ?? 0)
                    )->implode("\n"));
        }

        if ($canViewClinical && $showChildHealth) {
            $children = ChildHealth::where('resident_id', $resident->id)
                ->orderByDesc('assessment_date')->limit(10)->get();

            $sections[] = "CHILD HEALTH\n"
                .($children->isEmpty()
                    ? 'No child health records are registered.'
                    : $children->map(fn ($item) => '- Date: '.$this->formatDate($item->assessment_date)
                        .' | Weight: '.($item->weight_kg ?? 'Not recorded').' kg'
                        .' | Height: '.($item->height_cm ?? 'Not recorded').' cm'
                        .' | Nutrition: '.($item->nutritional_status ?: 'Not recorded')
                        .' | Remarks: '.($item->remarks ?: 'None')
                    )->implode("\n"));
        }

        if ($canViewClinical && $showSeniorCitizen) {
            $senior = SeniorCitizen::where('resident_id', $resident->id)->first();

            if ($senior) {
                $sections[] = "SENIOR CITIZEN INFORMATION\n"
                    .'OSCA ID: '.($senior->osca_id_number ?: 'Not recorded')."\n"
                    .'Status: '.($senior->senior_status ?: 'Not recorded')."\n"
                    .'Classification: '.($senior->classification ?: 'Not recorded')."\n"
                    .'Medical conditions: '.($senior->medical_conditions ?: 'Not recorded');
            }
        }

        if ($canViewClinical && $showCertificates) {
            $certificates = Certificate::where('resident_id', $resident->id)
                ->orderByDesc('date_issued')->limit(10)->get();

            $sections[] = "CERTIFICATES\n"
                .($certificates->isEmpty()
                    ? 'No certificates are registered.'
                    : $certificates->map(fn ($item) => '- '.($item->certificate_type ?: 'Certificate')
                        .' | Number: '.($item->certificate_number ?: 'Not specified')
                        .' | Issued: '.$this->formatDate($item->date_issued)
                        .' | Status: '.($item->status ?: 'Not specified')
                    )->implode("\n"));
        }

        return $this->reply(
            'Database information for '.$this->residentName($resident)
            ."\n\n".implode("\n\n", $sections)
            ."\n\nSource: Current database records."
            .(! $canViewClinical
                ? "\nClinical details are restricted to authorized health personnel."
                : '')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Intent detection
    |--------------------------------------------------------------------------
    */

    private function isGreeting(string $message): bool
    {
        return $this->matchesConfiguredIntent($message, 'greeting')
            || preg_match(
                '/^(hi|hello|hey|good morning|good afternoon|good evening)[!. ]*$/i',
                trim($message)
            ) === 1;
    }

    private function normalizeMessage(string $message): string
    {
        $message = mb_strtolower(trim($message));
        $normalized = preg_replace('/\s+/u', ' ', $message);

        return is_string($normalized) ? $normalized : $message;
    }

    private function isTagalogMessage(string $message): bool
    {
        return preg_match(
            '/\b(ano|ilan|ilang|pila|saan|sino|may|ba|mga|ang|ng|sa|'
            .'para|kamusta|kumusta|ipakita|ilista|rehistrado|residente|'
            .'sambahayan|gamot|anunsyo|abiso|iskedyul|matatanda|'
            .'sertipiko|kawani)\b/u',
            $message
        ) === 1;
    }

    private function matchesConfiguredIntent(
        string $message,
        string $intent
    ): bool {
        $examples = config("database_assistant.intents.{$intent}.examples", []);

        foreach ($examples as $example) {
            $phrase = $this->normalizeMessage((string) $example);

            if (
                $phrase !== ''
                && preg_match(
                    '/(?<![\pL\pN])'
                    .preg_quote($phrase, '/')
                    .'(?![\pL\pN])/u',
                    $message
                ) === 1
            ) {
                return true;
            }
        }

        return false;
    }

    private function isHealthVisitCountQuestion(string $message): bool
    {
        return preg_match('/\b(health[\s-]*visits?|visits?|pagbisita)\b/', $message) === 1
            && preg_match('/\b(how many|count|number of|total|ilan|ilang|pila)\b/', $message) === 1;
    }

    private function isResidentCountQuestion(string $message): bool
    {
        return (
            $this->matchesConfiguredIntent($message, 'count_residents')
            || (
                preg_match('/\bresidents?\b/', $message) === 1
                && preg_match('/\b(how many|count|number of|total)\b/', $message) === 1
            )
        )
            && ! $this->isResidentProfileQuestion($message);
    }

    private function isHouseholdCountQuestion(string $message): bool
    {
        return $this->matchesConfiguredIntent($message, 'count_households')
            || (
                preg_match('/\bhouseholds?\b/', $message) === 1
                && preg_match('/\b(how many|count|number of|total)\b/', $message) === 1
            );
    }

    private function isStaffCountQuestion(string $message): bool
    {
        return preg_match(
            '/\b(staff|users?|accounts?|health workers?|officials?|kawani|empleyado)\b/',
            $message
        ) === 1
            && preg_match('/\b(how many|count|number of|total|ilan|ilang|pila)\b/', $message) === 1;
    }

    private function isEventLocationQuestion(string $message): bool
    {
        return preg_match('/\b(where|location|venue|saan|nasaan)\b/', $message) === 1
            && preg_match('/\b(event|activity|schedule|scheduled activity|iskedyul)\b/', $message) === 1;
    }

    private function isExpiredInventoryQuestion(string $message): bool
    {
        return preg_match(
            '/\b(inventory|medicine|medicines|medication|medications|supplies|vaccines|items|gamot|mga gamot)\b/',
            $message
        ) === 1
            && preg_match(
                '/\b(expired|already expired|past expiry|past expiration|expired na|nagre-expire na)\b/',
                $message
            ) === 1;
    }

    private function isExpiringInventoryQuestion(string $message): bool
    {
        return preg_match(
            '/\b(inventory|medicine|medicines|medication|medications|supplies|vaccines|items|gamot|mga gamot)\b/',
            $message
        ) === 1
            && (
                preg_match('/\b(expiring|expiry|expiration|expire|expires)\b/', $message) === 1
                || preg_match(
                    '/\b(malapit( na| nang)? mag.?expire|mag.?expire na|mag.?eexpire)\b/',
                    $message
                ) === 1
            )
            && ! $this->isExpiredInventoryQuestion($message);
    }

    private function isAnnouncementQuestion(string $message): bool
    {
        return $this->matchesConfiguredIntent($message, 'published_announcements')
            || (
                preg_match('/\b(announcements?|community notices?|anunsyo|abiso)\b/', $message) === 1
                && preg_match('/\b(show|list|latest|recent|published|what|display|view|get|ipakita|ilista|ano ang)\b/', $message) === 1
            );
    }

    private function isUpcomingScheduleQuestion(string $message): bool
    {
        return $this->matchesConfiguredIntent($message, 'upcoming_schedules')
            || (
                preg_match('/\b(schedules?|events?|activities|calendar events?)\b/', $message) === 1
                && (
                    preg_match('/\b(upcoming|next|show|list|display|what|view|get)\b/', $message) === 1
                    || preg_match('/\b(this week|sa linggong ito|ngayong linggo)\b/', $message) === 1
                )
            );
    }

    private function isHouseholdLookupQuestion(string $message): bool
    {
        return preg_match('/\b(household|households|household code|household head|sambahayan)\b/', $message) === 1
            && preg_match('/\b(find|search|look up|lookup|show|details|information|record|records|code|address|head|contact|phone|where|saan|nasaan|hanapin|ipakita|sino ang)\b/', $message) === 1
            && ! $this->isHouseholdCountQuestion($message);
    }

    private function isResidentProfileQuestion(string $message): bool
    {
        if ($this->isGeneralHelpQuestion($message)) {
            return false;
        }

        if (
            preg_match(
                '/\b(residents?|residentes?|health visits?|health records?|immunizations?|maternal care|child health|senior citizens?|certificates?|sertipiko)\b/',
                $message
            ) === 1
            && preg_match('/\b(how many|count|number of|total|ilan|ilang|pila)\b/', $message) === 1
        ) {
            return false;
        }

        $asksForProfile = preg_match(
            '/\b(give me|show me|show|tell me|find|search for|look up|get|display|provide|who is|information about|details about|profile of|records for|ipakita|hanapin|sino si|contact number of|phone number of|email of|address of|where does|where do)\b/',
            $message
        ) === 1;

        $asksForNamedInformation = preg_match(
            '/\b(information|details|profile|records|record|medical history|health visits|health records|immunizations|contact number|phone number|email|address|birthday|birth date)\b/',
            $message
        ) === 1;

        $mentionsResident = preg_match(
            '/\b(resident|residents|residentes?|resident record|resident records)\b/',
            $message
        ) === 1;

        return ($asksForProfile && $asksForNamedInformation)
            || ($mentionsResident && $asksForProfile)
            || (
                preg_match('/\bsino si\b/', $message) === 1
                && $asksForProfile
            );
    }

    private function isGeneralHelpQuestion(string $message): bool
    {
        return $this->matchesConfiguredIntent($message, 'help')
            || preg_match(
                '/\b(explain how|how can i ask|how do i ask|how to ask|'
                .'how can i use|how do i use|how to use|how does this work|'
                .'what can you do|what can i ask|help me use|how to search|'
                .'how can i search|how do i search|what questions can i ask)\b/',
                $message
            ) === 1;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function extractSearchTerm(string $message, array $keywords): string
    {
        $search = mb_strtolower(trim($message));

        foreach ($keywords as $keyword) {
            $search = str_ireplace($keyword, ' ', $search);
        }

        $search = preg_replace(
            '/\b(please|can you|could you|would you|show me|tell me|'
            .'give me|provide|all|list|listing|who|which|how many|count|'
            .'number of|members?|membership|people|residents?|miyembro|'
            .'kasapi|sino|ilan|ilang|pila|belong|lives in|about|'
            .'information|details|profile|'
            .'find|search for|search|look up|lookup|show|get|display|'
            .'the|a|an|is|are|in|from|database|records|record|'
            .'what is|who is|of|for|my|me|and|with)\b/i',
            ' ',
            $search
        );

        $search = preg_replace(
            '/\b(hanapin ang|ipakita ang|sino si|sino ang|saan nakatira|'
            .'nasaan si|para kay|mga|ang|kay)\b/i',
            ' ',
            $search
        );

        $search = preg_replace('/[?.,!]+/', ' ', $search);
        $search = preg_replace('/\s+/', ' ', $search);

        return trim($search);
    }

    private function residentName(Resident $resident): string
    {
        return trim(implode(' ', array_filter([
            $resident->first_name,
            $resident->middle_name,
            $resident->last_name,
            $resident->suffix,
        ], fn ($value) => filled($value))));
    }

    private function formatDate(mixed $date): string
    {
        if (! $date) {
            return 'Not recorded';
        }

        try {
            return Carbon::parse($date)->format('F j, Y');
        } catch (Throwable $exception) {
            return (string) $date;
        }
    }

    private function applyDateRangeToQuery(
        EloquentBuilder $query,
        string $message,
        string $column
    ): void {
        $today = Carbon::today();

        if (str_contains($message, 'last month')) {
            $start = $today->copy()->subMonthNoOverflow()->startOfMonth();
            $query->whereBetween($column, [$start, $start->copy()->endOfMonth()]);
        } elseif (str_contains($message, 'last year')) {
            $query->whereBetween($column, [
                $today->copy()->subYear()->startOfYear(),
                $today->copy()->subYear()->endOfYear(),
            ]);
        } elseif (str_contains($message, 'today')) {
            $query->whereDate($column, $today);
        } elseif (str_contains($message, 'yesterday')) {
            $query->whereDate($column, $today->copy()->subDay());
        } elseif (str_contains($message, 'this week')) {
            $query->whereBetween($column, [
                $today->copy()->startOfWeek(),
                $today->copy()->endOfWeek(),
            ]);
        } elseif (str_contains($message, 'this month')) {
            $query->whereBetween($column, [
                $today->copy()->startOfMonth(),
                $today->copy()->endOfMonth(),
            ]);
        } elseif (str_contains($message, 'this year')) {
            $query->whereBetween($column, [
                $today->copy()->startOfYear(),
                $today->copy()->endOfYear(),
            ]);
        }
    }

    private function dateRangeDescription(string $message): string
    {
        foreach (
            ['today', 'yesterday', 'this week', 'this month', 'last month', 'this year', 'last year'] as $range
        ) {
            if (str_contains($message, $range)) {
                return ' for '.$range;
            }
        }

        return '';
    }

    private function canViewClinicalRecords(): bool
    {
        return in_array(
            auth()->user()?->role,
            ['System Administrator', 'Official', 'Health Worker'],
            true
        );
    }

    private function canViewMedicalInventory(): bool
    {
        return in_array(
            auth()->user()?->role,
            ['System Administrator', 'Health Worker'],
            true
        );
    }

    private function reply(string $message): JsonResponse
    {
        return response()->json(['reply' => $message]);
    }

    private function decodeJsonObject(string $content): ?array
    {
        $content = trim($content);
        $decoded = json_decode($content, true);

        if (is_array($decoded)) {
            return $decoded;
        }

        $start = strpos($content, '{');
        $end = strrpos($content, '}');

        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        $decoded = json_decode(
            substr($content, $start, $end - $start + 1),
            true
        );

        return is_array($decoded) ? $decoded : null;
    }

    private function callOllama(
        array $messages,
        bool $jsonMode = false
    ): ?string {
        $baseUrl = rtrim(
            (string) config(
                'services.ollama.url',
                'http://127.0.0.1:11434'
            ),
            '/'
        );

        $model = (string) config(
            'services.ollama.model',
            'qwen2.5:3b'
        );

        try {
            $payload = [
                'model' => $model,
                'stream' => false,
                'messages' => $messages,
                'options' => ['temperature' => 0.1],
            ];

            if ($jsonMode) {
                $payload['format'] = 'json';
            }

            $response = Http::timeout(90)
                ->acceptJson()
                ->post($baseUrl.'/api/chat', $payload);

            if (! $response->successful()) {
                Log::warning('Ollama assistant request failed.', [
                    'status' => $response->status(),
                ]);

                return null;
            }

            $content = $response->json('message.content');

            return is_string($content) && trim($content) !== ''
                ? trim($content)
                : null;
        } catch (ConnectionException|\InvalidArgumentException $exception) {
            Log::warning('Ollama assistant is unavailable.', [
                'exception' => get_class($exception),
            ]);

            return null;
        }
    }
}
