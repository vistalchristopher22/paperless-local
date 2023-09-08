@extends('layouts.app-2')
@section('tab-title', 'Ordered Business')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endprepend

@section('content')
    @if (session()->has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h6 class="card-title h6 text-white m-0 fw-medium">Ordered Business</h6>
        </div>

        <div class="card-body">
            <table class="table table-striped datatable border" id="order-business-table">
                <thead>
                    <tr class="bg-light">
                        <th class="text-center border text-dark">Order Business Title</th>
                        <th class="text-center border text-dark">Published</th>
                        <th class="text-center border text-dark">Filename</th>
                        <th class="text-center border text-dark">Created At</th>
                        <th class="text-center border text-dark">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#order-business-table').DataTable({
                    serverSide: true,
                    ajax: route('user.sessions.list'),
                    columns: [{
                            className: 'border text-center',
                            data: 'title',
                            name: 'title',
                            render: function(data, _, row) {
                                return `<span class="text-decoration-underline fw-medium text-capitalize text-primary cursor-pointer btn-view-file" data-path="${row.file_path}" data-id="${row.id}">${data}</span>`;
                            }
                        },
                       {
                            className: 'text-center',
                            data: 'status',
                            name: 'status'
                        },
                        {
                            className: 'text-center',
                            data: 'status',
                            name: 'status'
                        },
                        {
                            className: 'text-center',
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });



                $(document).on('click', '.btn-view-file', function() {
                    let id = $(this).attr('data-id');
                    let path = $(this).attr('data-path');
                    socket.emit('EDIT_FILE', {
                        file_path: path
                    });
                });
            });
        </script>
    @endpush

@endsection
