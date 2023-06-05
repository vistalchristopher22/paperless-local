@extends('layouts.app')
@section('page-title', 'Complete Listing of Committees')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endprepend
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    <div class="accordion accordion-flush mb-3">
        <div class="accordion-item mb-2 shadow">
            <h2 class="accordion-header" id="committee-filter">
                <button class="accordion-button collapsed bg-white bg-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#accordion-filter" aria-expanded="false" aria-controls="accordion-filter">
                    <div class="text-dark d-flex flex-row align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search mx-2" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                        <span class="h6 text-dark fw-boldi mb-0">
                            What are you looking for?
                        </span>
                    </div>
                </button>
            </h2>
            <div id="accordion-filter" class="accordion-collapse collapse" aria-labelledby="committee-filter">
                <div class="accordion-body">
                    <div class="d-flex flex-column">
                        <label class="form-label">Lead Committee</label>
                        <select id="filterLeadCommitee" class="form-select">
                            <option value="">-</option>
                            <option value="*">All</option>
                            @foreach ($agendas as $agenda)
                                <option {{ request()->query('l') == $agenda->id ? 'selected' : '' }}
                                    value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="d-flex flex-column mt-3">
                        <label class="form-label">Expanded Committee</label>
                        <select id="filterExpandedCommittee" class="form-select">
                            <option value="">-</option>
                            <option value="*">All</option>
                            @foreach ($agendas as $agenda)
                                <option {{ request()->query('e') == $agenda->id ? 'selected' : '' }}
                                    value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="d-flex flex-column mt-3">
                        <label class="form-label">Chairman</label>
                        <select class="form-select" id="filterChairman">
                            <option value="">-</option>
                            <option value="*">All</option>
                            @foreach ($sangguniangMembers as $sangguniangMember)
                                <option value="{{ $sangguniangMember->id }}">{{ $sangguniangMember->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column mt-3">
                        <label class="form-label">Vice Chairman</label>
                        <select class="form-select" id="filterViceChairman">
                            <option value="">-</option>
                            <option value="*">All</option>
                            @foreach ($sangguniangMembers as $sangguniangMember)
                                <option value="{{ $sangguniangMember->id }}">{{ $sangguniangMember->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column mt-3">
                        <label class="form-label">Year</label>
                        <select class="form-select" id="filterYear">
                            <option value="">-</option>
                            @foreach (range($minYear, $maxYear) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3 float-end">
                        <button class="btn btn-primary" id="btnApplyFilters">Apply Filters</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($committees as $committee)
        <div class="accordion accordion-flush">
            <div class="accordion-item mb-3 border">
                <h2 class="accordion-header bg-" id="committee-{{ $committee->id }}">
                    <button class="accordion-button collapsed bg-white bg-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accordion-{{ $committee->priority_number }}" aria-expanded="false"
                        aria-controls="accordion-{{ $committee->priority_number }}">
                        <div class="text-dark d-flex flex-row justify-content-center align-items-center">
                            <div class="me-4">
                                <span class="h3 fw-bold text-muted">
                                    {{ $committee->priority_number }}
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h4 @class([
                                    'text-muted' => $committee->invited_guests == 0,
                                    'text-success' => $committee->invited_guests == 1,
                                ])>
                                    {{ $committee->name }}
                                </h4>
                                <div class="mb-2">
                                    <span class="fw-bold">Lead Committee:</span>
                                    <span class="text-primary">{{ $committee->lead_committee_information->title }}</span>
                                </div>

                                {{-- <div class="mb-2">
                                    <span class="fw-bold">Expanded Committee:</span>
                                    <span
                                        class="text-primary">{{ $committee->expanded_committee_information->title }}</span>
                                </div> --}}

                                <div class="mb-2">
                                    <span class="fw-medium text-muted">
                                        <span class="fw-bold text-dark">Leads:</span>
                                    </span>
                                    <span class="badge bg-primary mb-0 pb-0 align-middle ms-5">
                                        <h6 class="mb-1">
                                            {{ $committee->lead_committee_information->chairman_information->fullname }}
                                        </h6>
                                    </span>
                                    <span class="badge bg-primary mb-0 pb-0 align-middle ms-2">
                                        <h6 class="mb-1">
                                            {{ $committee->lead_committee_information->vice_chairman_information->fullname }}
                                        </h6>
                                    </span>
                                </div>
                                {{-- <div class="mb-2">
                                    <span class="fw-bold text-dark">Expanded:</span>
                                    <span class="badge bg-primary mb-0 pb-0 align-middle ms-3">
                                        <h6 class="mb-1">
                                            {{ $committee->expanded_committee_information->chairman_information->fullname }}
                                        </h6>
                                    </span>
                                    <span class="badge bg-primary mb-0 pb-0 align-middle ms-2">
                                        <h6 class="mb-1">
                                            {{ $committee->expanded_committee_information->vice_chairman_information->fullname }}
                                        </h6>
                                    </span>
                                </div> --}}
                                {{-- <div class="">
                                    <span class="fw-medium">
                                        <span class="fw-bold me-3">Members:</span>
                                        @foreach ($committee->lead_committee_information->members as $member)
                                            <span class="badge bg-primary mb-0 pb-0 align-middle ms-2">
                                                <h6 class="mb-1">
                                                    {{ $member?->sanggunian_member?->pluck('fullname')[0] ?? '' }}</h6>
                                            </span>
                                        @endforeach
                                    </span>
                                </div> --}}
                                {{-- <div class="mt-3">
                                    <span class="fw-medium text-muted">
                                        <span class="me-3">
                                            {{ $committee->session_schedule->format('h:i A') }}
                                        </span>
                                    </span>
                                </div> --}}
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="accordion-{{ $committee->priority_number }}" class="accordion-collapse collapse"
                    aria-labelledby="committee-{{ $committee->id }}">
                    <div class="accordion-body">
                        No Available Content
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-2 d-flex flex-row justify-content-center align-items-center">
        <div class="text-dark">
            {{ $committees->links() }}
        </div>
    </div>



    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        {{-- <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/custom/committee.js') }}"></script>
        <script src="{{ asset('assets/js/custom/sbmCommittee.js') }}"></script>
        <script>
            $('select#filterLeadCommitee, select#filterExpandedCommittee, select#filterChairman, select#filterViceChairman')
                .select2({
                    theme: "classic"
                });

            $('#btnApplyFilters').click(function() {
                const params = new URLSearchParams();

                if ($('#filterLeadCommitee').val() !== '*' && $('#filterLeadCommitee').val()) {
                    params.set('l', $('#filterLeadCommitee').val());
                }

                if ($('#filterExpandedCommittee').val() !== '*' && $('#filterExpandedCommittee').val()) {
                    params.set('e', $('#filterExpandedCommittee').val());
                }

                if ($('#filterChairman').val() !== '*' && $('#filterChairman').val()) {
                    params.set('c', $('#filterChairman').val());
                }

                if ($('#filterViceChairman').val() !== '*' && $('#filterViceChairman').val()) {
                    params.set('vc', $('#filterViceChairman').val());
                }

                if ($('#filterYear').val() !== '*' && $('#filterYear').val()) {
                    params.set('y', $('#filterYear').val());
                }

                const url = `committee?${params.toString()}`;
                window.location.href = url;
            });
        </script>
    @endpush
@endsection
