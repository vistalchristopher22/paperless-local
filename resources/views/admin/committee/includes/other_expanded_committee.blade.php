    @if (isset($committee->other_expanded_committee_information))
        <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee" aria-controls="offCanvasCommittee"
            data-expanded-committee="{{ $committee->expanded_committee_2 }}"
            class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
            {{ Str::remove('Committee on', $committee->other_expanded_committee_information->title) }}
        </a>
    @endif
