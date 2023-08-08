
    @isset($committee?->schedule_information?->regular_session)
        <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasSchedule"
           data-id="{{ $committee?->schedule_id }}"
           class="cursor-pointer text-primary view-schedule-information text-decoration-underline fw-medium text-truncate">
        {{ $committee?->schedule_information?->regular_session?->number }} Regular Session
        - {{ $committee?->schedule_information?->regular_session?->year }}
        </a>
    @else
        <span class="badge bg-soft-danger">
            N/A
        </span>
    @endisset
