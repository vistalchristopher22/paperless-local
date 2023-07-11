@extends('layouts.app-2')
@section('tab-title', 'Ordered Business')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            <h6 class="fw-medium text-white h6 card-title">Ordered Business</h6>
            <a href="{{ route('board-sessions.create') }}" class="btn btn-light fw-bold shadow">New Ordered Business</a>
        </div>

        <div class="card-body">
            <div class="">
                <table class="table table-bordered" id="order-business-table">
                    <thead>
                    <tr class="bg-light">
                        <th class="fw-medium text-center border text-dark">
                            Order Business Title
                        </th>
                        <th class="fw-medium text-center border text-dark">Unassigned Title</th>
                        <th class="fw-medium text-center border text-dark">Announcement Title</th>
                        <th class="fw-medium text-center border text-dark">Announcement Content</th>
                        <th class="fw-medium text-center border text-dark">Publish Status</th>
                        <th class="fw-medium text-center border text-dark">Status</th>
                        <th class="fw-medium text-center border text-dark">Created At</th>
                        <th class="fw-medium text-center border text-dark">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                let tableUrl = route('board-sessions.list');
                $('#order-business-table').DataTable({
                    serverSide: true,
                    ajax: tableUrl,
                    columns: [{
                        className: 'border text-center',
                        data: 'title',
                        name: 'title',
                        render: function (data, _, row) {
                            return `<span class="text-decoration-underline fw-medium text-capitalize text-primary cursor-pointer btn-view-file" data-path="${row.file_path}" data-id="${row.id}">${data}</span>`;
                        }
                    },
                        {
                            className: 'border',
                            data: 'unassigned_title',
                            name: 'unassigned_title'
                        },
                        {
                            className: 'border',
                            data: 'announcement_title',
                            name: 'announcement_title'
                        },
                        {
                            className: 'border',
                            data: 'announcement_content',
                            name: 'announcement_content'
                        },
                        {
                            className: 'border text-center',
                            data: 'is_published',
                            name: 'is_published',
                            render: function (data) {
                                if (data == 1) {
                                    return `<span class="badge badge-soft-primary">Published</span>`;
                                }

                                return ``;
                            }
                        },
                        {
                            className: 'border text-center',
                            data: 'status',
                            name: 'status'
                        },
                        {
                            className: 'border text-center',
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            className: 'border text-center',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });

                let showConfirmation = (url, method, text) => {
                    alertify.prompt(text, "",
                        function (evt, value) {
                            $.ajax({
                                url: url,
                                type: method,
                                data: {
                                    password: value
                                },
                                success: function (response) {
                                    if (response.success) {
                                        alertify.success(response.message);
                                        $('#order-business-table').DataTable().ajax
                                            .reload(null, false);
                                    } else {
                                        alertify.error(response.message);
                                        showConfirmation(url, method, text);
                                    }
                                }
                            });
                        }).set({
                        labels: {
                            ok: 'Proceed',
                            cancel: 'Cancel',
                        }
                    }).setHeader('Confirmation').set('type', 'password');
                }


                $(document).on('click', '.btn-lock-session', function (e) {
                    let id = $(this).data('id');
                    let url = route('board-sessions.locked', id);
                    showConfirmation(url, "POST", "Enter Password to Lock Session");
                });


                $(document).on('click', '.btn-published', function (e) {
                    let id = $(this).data('id');
                    let url = route('board-sessions.published', id);
                    showConfirmation(url, "POST", "Enter Password to Published");
                });

                $(document).on('click', '.btn-unlock-session', function () {
                    let id = $(this).data('id');
                    let url = route('board-sessions.unlocked', id);
                    showConfirmation(url, "POST", "Enter Password to Unlock Session");
                })

                $(document).on('click', '.btn-delete-session', function () {
                    let id = $(this).data('id');
                    let url = route('board-sessions.destroy', id);
                    showConfirmation(url, "DELETE", "Enter Password to Delete Session");
                });

                $(document).on('click', '.btn-view-file', function () {
                    let path = $(this).attr('data-path');
                    socket.emit('EDIT_FILE', {
                        file_path: path
                    });
                });
            });
        </script>
    @endpush

@endsection
