@extends('layouts.app-2')
@section('tab-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
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
    <div class="card mb-3 d-none">
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
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title text-white h6">Committees</h6>
            <a href="{{ route('committee.create') }}" class="btn btn-light fw-bold">
                Add New Committee
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="committees-table" width="100%">
                <thead>
                    <tr class="bg-light">
                        <th class="p-3 border text-dark">Name</th>
                        <th class="p-3 border text-dark">Submitted By</th>
                        <th class="p-3 border text-dark">Lead Committee</th>
                        <th class="p-3 border text-dark">Expanded Committee</th>
                        <th class="p-3 border text-dark text-center">Status</th>
                        <th class="p-3 border text-dark text-center">Submitted At</th>
                        <th class="p-3 border text-center text-dark">Actions</th>
                    </tr>
                </thead>

            </table>
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

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/custom/committee.js') }}"></script>
        <script>
            $('select#filterLeadCommitee, select#filterExpandedCommittee').select2({
                theme: "classic"
            });
        </script>
    @endpush
@endsection
