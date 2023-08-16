@extends('layouts.app-2')
@section('tab-title', 'Legislation\'s')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ asset('/assets-2/plugins/daterangepicker/daterangepicker.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endprepend
@section('content')
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
                    <div class="col-lg-3">
                        <label for="daterange" class="form-label">Date</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="daterange" id="daterange" value="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="author" class="form-label">Author</label>
                        <select name="author" class="form-select" style="width :100%;" id="author">
                            <option value="*">All</option>
                            @foreach ($spMembers as $sp_member)
                                <option value="{{ $sp_member->id }}">{{ $sp_member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="*">All</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ Str::upper($type->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="classification" class="form-label">Classification</label>
                        <select name="classification" id="classification" class="form-select">
                            <option value="*">All</option>
                            @foreach($classifications as $classification)
                                <option value="{{ $classification }}">{{ Str::upper($classification->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <label for="sponsors" class="form-label">Sponsors</label>
                        <select name="sponsors" id="sponsors" style="width: 100%;" multiple>
                            @foreach ($spMembers as $sp_member)
                                <option value="{{ $sp_member->id }}">{{ $sp_member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 h6 fw-medium">Ordinance <span class="text-lowercase">and</span> Resolution</h6>
            <a href="{{ route('legislation.create') }}" class="btn btn-dark shadow-lg"
               data-bs-toggle="tooltip" data-bs-placement="top">
                <i class="mdi mdi-file-plus"></i> Create Legislation
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="legislationTable" width="100%">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">No</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Title</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Type</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Author</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Sponsors</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Description</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Classification</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Session Date</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('/assets-2/js/daterange-picker.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#daterange').val('');

                $('#legislationTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    retrieve: true,
                    pagingType: "full_numbers",
                    ajax: 'legislation/list/*/*/*/*/*',
                    columns: [
                        {name: 'no', className: 'p-2 text-center'},
                        {name: 'title', className: 'p-2'},
                        {
                            name: 'legislable.record_type',
                            className: 'p-2 text-center',
                            render: data => `<span class="badge bg-primary">${data?.name}</span>`,
                        },
                        {
                            name: 'legislable.author_information',
                            className: 'p-2 text-truncate',
                            render: data => data?.fullname,
                        },
                        {
                            name: 'sponsors',
                            className: 'p-2 text-center',
                            render: data => {
                                if (data) {
                                    const sponsors = data.split("|");
                                    return sponsors.map(sponsor => `<span class="badge bg-primary mx-2 my-2">${sponsor}</span>`).join('');
                                }
                            },
                        },
                        {
                            name: 'description',
                            className: 'p-2'
                        },
                        {
                            name: 'classification',
                            className: 'p-2 text-center text-uppercase',
                            render: data => `<span class="badge ${data?.toLowerCase() === 'ordinance' ? 'bg-info' : 'bg-primary'}">${data}</span>`,
                        },
                        {
                            name: 'legislable.session_date',
                            className: 'p-2 text-center',
                            render: date => moment(date).format('MMMM Do YYYY'),
                        },
                        {
                            name: 'id',
                            className: 'p-2 text-center',
                            render: id => `
                                <a class="btn btn-success" href="${route('legislation.edit', id)}">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                            `,
                        }
                    ],
                });


                const filterLegislationTable = () => {
                    const dates = $('#daterange').val() || "*";
                    const convertedDates = dates.replace(/\//g, '-') || "*";
                    const author = $('#author').val() || "*";
                    const type = $('#type').val() || "*";
                    const classification = $('#classification').val() || "*";
                    const sponsors = $('#sponsors').val().length === 0 ? '*' : $("#sponsors").val();
                    $("#legislationTable").DataTable().ajax.url(`${route('legislation.list', [convertedDates, author, type, classification, sponsors])}`).load();
                }

                $(document).on('click', '.applyBtn', filterLegislationTable);
                $(document).on('click', '.cancelBtn', () => $('#daterange').val(''));

                $('#author').change(filterLegislationTable);
                $('#type').change(filterLegislationTable);
                $('#classification').change(filterLegislationTable);
                $('#sponsors').change(filterLegislationTable);


                $('select#author, select#sponsors').select2({});
            });
        </script>
    @endpush
@endsection
