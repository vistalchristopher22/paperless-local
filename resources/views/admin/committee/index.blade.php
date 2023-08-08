@extends('layouts.app-2')
@section('tab-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endprepend
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" id="filterHeader">
            <h6 class="card-title h6 fw-medium text-dark fw-medium">What <span class="text-lowercase">are you looking
                    for</span>?</h6>
            <button class="btn btn-dark shadow-dark" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filterCollapse"
                    aria-expanded="false" aria-controls="filterCollapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-funnel-fill" viewBox="0 0 16 16">
                    <path
                        d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/>
                </svg>
            </button>
        </div>
        <div class="collapse" id="filterCollapse">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="fw-bolder text-dark form-label">Lead Committee</label>
                            <select id="filterLeadCommitee" class="form-control" style="width : 100%;">
                                <option value="*">All</option>
                                @foreach ($agendas as $agenda)
                                    <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="fw-bolder text-dark form-label">Expanded Committee</label>
                            <select id="filterExpandedCommittee" class="form-select" style="width : 100%;">
                                <option value="*">All</option>
                                @foreach ($agendas as $agenda)
                                    <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="fw-bolder text-dark form-label">Available Sessions</label>
                            <select id="availableSession" class="form-select" style="width : 100%;">
                                <option value="*">All</option>
                                @foreach ($availableRegularSessions as $availableSession)
                                    <option value="{{ $availableSession->id }}">{{ $availableSession->number }} Regular Session - {{ $availableSession->year }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label fw-bolder text-dark">Search by Content</label>
                            <input id="filterByContent" class="form-control" placeholder="Enter phrase or word">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="h6 card-title">Committees</h6>
            <div>
                <a href="{{ route('committee.create') }}" class="btn btn-dark fw-medium shadow-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Add New Committee
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="p-3">
                <table class="table table-striped table-bordered" id="committees-table" width="100%">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-3 border text-dark align-middle" style="width:130px;">Name</th>
                        <th class="p-3 border text-dark text-center" style="width:180px;">Submitted By</th>
                        <th class="p-3 border text-dark">Lead Committee</th>
                        <th class="p-3 border text-dark">Expanded Committee</th>
                        <th class="p-3 border text-dark">Other Expanded Committee</th>
                        <th class="p-3 border text-dark">Regular Session</th>
                        <th class="p-3 border text-dark text-center">Status</th>
                        <th class="p-3 border text-dark text-center">Submitted At</th>
                        <th class="p-3 border text-center text-dark">Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end border-0" style="width:450px;" tabindex="-1" id="offCanvasCommittee"
         aria-labelledby="offCanvasCommitteeTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 class="offcanvas-title mb-3" id="offCanvasCommitteeTitle"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar-group me-4" id="pictures">
                        <span class="small fw-bolder ms-2 text-muted text-dark" id="picturesDescription"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="leadCommitteeContent">
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom border-0" tabindex="-1" id="offCanvasSchedule"
         aria-labelledby="offCanvasScheduleTitle">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title mt-0" id="offcanvasExampleLabel">Schedule Information</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="scheduleInformationContent">
                </div>
            </div>

        </div>
    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/custom/committee.js') }}"></script>
        <script>
            $('select#filterLeadCommitee, select#filterExpandedCommittee, select#availableSession').select2({});
        </script>
    @endpush
@endsection
