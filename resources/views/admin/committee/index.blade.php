@extends('layouts.app')
@section('page-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }
    </style>
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
        <div class="card-header">
            <h6>What are you looking for?</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-medium">Lead Committee</label>
                        <select id="filterLeadCommitee" class="form-select">
                            <option value="*">All</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-medium">Expanded Committee</label>
                        <select id="filterExpandedCommittee" class="form-select">
                            <option value="*">All</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Search by content</label>
                        <input id="filterByContent" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6>Committees</h6>
            <a href="{{ route('committee.create') }}" class="btn btn-primary btn-sm">
                Add New Committee
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped border" id="committees-table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center text-dark">&nbsp;</th>
                        <th class="text-center text-dark">Priority Number</th>
                        <th class="text-dark">Name</th>
                        <th class="text-dark">Schedule</th>
                        <th class="text-dark">Lead Committee</th>
                        <th class="text-dark">Expanded Committee</th>
                        <th class="text-dark text-center">Created At</th>
                        <th class="text-center text-dark">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark text-center">&nbsp;</th>
                        <th class="text-center text-dark">&nbsp;</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasCommittee" aria-labelledby="offCanvasCommitteeTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 class="offcanvas-title mb-3" id="offCanvasCommitteeTitle"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar-group me-4" id="pictures">
                        <span class="small fw-bolder ms-2 text-muted text-dark" id="picturesDescription"></span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close text-reset position-absolute top-20 end-5" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="leadCommitteeContent">
                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/custom/committee.js') }}"></script>
        <script src="{{ asset('assets/js/custom/sbmCommittee.js') }}"></script>
        <script>
            $('select#filterLeadCommitee, select#filterExpandedCommittee').select2({
                theme: "classic"
            });
        </script>
    @endpush
@endsection
