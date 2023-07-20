<a data-bs-toggle="offcanvas" data-bs-target="#offCanvasSchedule"
   data-id="{{ $committee?->schedule_id }}"
   class="cursor-pointer text-primary view-schedule-information text-decoration-underline fw-medium">
    {{ $committee?->schedule_information?->date_and_time->format('F d, Y') }}
</a>
