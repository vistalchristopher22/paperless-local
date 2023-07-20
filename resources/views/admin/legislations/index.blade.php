@extends('layouts.app-2')

@section('page-title', 'Legislations')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endprepend

@section('content')

    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 text-white">Ordinance and Resolution</h6>
            <div class="dropdown">
                <a href="{{ route('legislation.create') }}" class="btn btn-light fw-bold" title="Add New User"
                    data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="mdi mdi-file-plus"></i> Create Resolution
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table border" id="legislationTable">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-dark text-center fw-medium">No</th>
                            <th class="text-dark text-center fw-medium">Title</th>
                            <th class="text-dark text-center fw-medium">Author</th>
                            <th class="text-dark text-center fw-medium">Description</th>
                            <th class="text-dark text-center fw-medium">Type</th>
                            <th class="text-dark text-center fw-medium">Session Date</th>
                            <th class="text-dark text-center fw-medium">Action</th>
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

        <script>
            $(document).ready(function() {

                $('#legislationTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    retrieve: true,
                    pagingType: "full_numbers",
                    ajax: 'legislation/list',
                    columns: [
                        {
                            className: 'text-center',
                            data: 'no',
                            name: 'no',
                            searchable: true,
                            sortable: false,
                            visible: true,
                        },
                        {
                            className: 'text-center',
                            data: 'title',
                            name: 'title',
                            searchable: true,
                            sortable: false,
                            visible: true,
                        },
                        {
                            className: 'text-center',
                            data: 'fullname',
                            name: 'fullname',
                            searchable: true,
                            sortable: false,
                            visible: true,
                        },
                        {
                            className: 'text-center',
                            data: 'description',
                            name: 'description',
                            searchable: true,
                            sortable: false,
                            visible: true,
                        },
                        {
                            className: 'text-center',
                            data: 'type',
                            name: 'type',
                            searchable: true,
                            sortable: false,
                            visible: true,
                        },
                        {
                            className: 'text-center',
                            data: 'session_date',
                            name: 'session_date',
                            render: function (data, type, row) {
                                return moment(data).format('dddd D MMMM YYYY');
                            },
                            searchable: true,
                            sortable: false,
                            visible: true,
                        },

                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action',
                        }
                    ]
                });

            });


        </script>
    @endpush
@endsection
