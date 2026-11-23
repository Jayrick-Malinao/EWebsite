<div class="record-actions">
    <button type="button" class="clay-action-menu-trigger flex h-10 w-10 items-center justify-center rounded-full text-[#6D817A] transition hover:text-[#164238]" aria-label="{{ $label }}" aria-expanded="false" data-menu-trigger>
        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <circle cx="10" cy="5" r="1.5" />
            <circle cx="10" cy="10" r="1.5" />
            <circle cx="10" cy="15" r="1.5" />
        </svg>
    </button>
    <div class="clay-action-menu record-actions-panel hidden" data-menu-panel hidden>
        {{ $slot }}
    </div>
</div>
