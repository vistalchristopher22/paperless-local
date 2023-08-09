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

    <div class="card">
        <div class="card-header bg-light">
            <h6 class="card-title fw-medium h6">What are you looking for?</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <label for="daterange" class="form-label">Search Date</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="daterange" id="daterange" value="">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="author" class="form-label">Author</label>
                    <select name="author" class="form-select" id="author">
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
                    <label class="form-label">Sponsors</label>
                    <div class="input-group">
                        <select name="sponsors" id="sponsors" class="form-select" multiple>
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
            <h6 class="card-title m-0 g6 fw-medium">Ordinance and Resolution</h6>
            <a href="{{ route('legislation.create') }}" class="btn btn-dark shadow-lg"
               data-bs-toggle="tooltip" data-bs-placement="top">
                <i class="mdi mdi-file-plus"></i> Create Legislation
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="legislationTable">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">No</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Title</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Type</th>
                        <th class="p-3 text-dark text-uppercase text-center fw-medium">Author</th>
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
                const dates = $('#daterange').val();
                $('#daterange').val('');

                const convertedDates = dates.replace(/\//g, '-');
                $('#legislationTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    retrieve: true,
                    pagingType: "full_numbers",
                    ajax: 'legislation/list/*/*/*/*',
                    columns: [
                        {
                            name: 'no',
                            className: 'p-2',
                        },
                        {
                            name: 'title',
                            className: 'p-2',
                        },
                        {
                            name: 'legislable.record_type',
                            className: 'p-2 text-center',
                            render: (data) => `<span class="badge bg-primary">${data?.name}</span>`,
                        },
                        {
                            name: 'legislable.author_information',
                            className: 'p-2',
                            render: (data) => data?.fullname,
                        },
                        {
                            name: 'description',
                            className: 'p-2',
                        },
                        {
                            name: 'classification',
                            className: 'p-2 text-center text-uppercase',
                            render: (data) => {
                                if (data?.toLowerCase() === 'ordinance') {
                                    return `<span class="badge bg-info">${data}</span>`;
                                } else {
                                    return `<span class="badge bg-primary">${data}</span>`;
                                }
                            },

                        },
                        {
                            name: 'legislable.session_date',
                            className: 'p-2 text-center',
                            render: function (date) {
                                return `${moment(date).format('MMMM Do YYYY')}`;
                            },
                        },
                        {
                            name: 'id',
                            className: 'p-2 text-center',
                            render: function (id) {
                                return `
                                    <a class="btn btn-success" href="${route('legislation.edit', id)}">
                                          <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                `;
                            }
                        }
                    ]
                });
            });


            $('#daterange').change(function () {
                const dates = $('#daterange').val() || "*";
                const convertedDates = dates.replace(/\//g, '-') || "*";
                const author = $('#author').val() || "*";
                const type = $('#type').val() || "*";
                const classification = $('#classification').val() || "*";
                $("#legislationTable").DataTable().ajax.url(`${route('legislation.list', [convertedDates, author])}`).load();
            });

            $('#author').change(function () {
                const dates = $('#daterange').val() || "*";
                const convertedDates = dates.replace(/\//g, '-') || "*";
                const author = $('#author').val() || "*";
                const type = $('#type').val() || "*";
                const classification = $('#classification').val() || "*";
                $("#legislationTable").DataTable().ajax.url(`${route('legislation.list', [convertedDates, author, type, classification])}`).load();
            });

            $('#type').change(function () {
                const dates = $('#daterange').val() || "*";
                const convertedDates = dates.replace(/\//g, '-') || "*";
                const author = $('#author').val() || "*";
                const type = $('#type').val() || "*";
                const classification = $('#classification').val() || "*";
                $("#legislationTable").DataTable().ajax.url(`${route('legislation.list', [convertedDates, author, type, classification])}`).load();
            });

            $('#classification').change(function () {
                const dates = $('#daterange').val() || "*";
                const convertedDates = dates.replace(/\//g, '-') || "*";
                const author = $('#author').val() || "*";
                const type = $('#type').val() || "*";
                const classification = $('#classification').val() || "*";
                $("#legislationTable").DataTable().ajax.url(`${route('legislation.list', [convertedDates, author, type, classification])}`).load();
            });


            $('select#author, select#sponsors').select2({});
        </script>
    @endpush
@endsection
