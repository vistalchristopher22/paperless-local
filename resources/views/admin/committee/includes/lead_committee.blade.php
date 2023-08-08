<a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee" aria-controls="offCanvasCommittee"
    data-expanded-committee="{{ $committee->lead_committee }}"
   class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
    {{ Str::remove('Committee on', $committee->lead_committee_information->title) }}
</a>
