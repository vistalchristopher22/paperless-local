@extends('layouts.app')
@section('page-title', 'Ordered Business')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">Ordered Business</span>
            <a href="{{ route('board-sessions.create') }}" class="btn btn-primary">New Ordered Business</a>
        </div>

        <div class="card-body">
            <table class="table border" id="order-business-table">
                <thead>
                    <tr>
                        <th class="p-3 text-center border text-dark">
                            <small>
                                Order Business Title
                            </small>
                        </th>
                        <th class="p-3 text-center border text-dark"><small>Unassigned Title</small></th>
                        <th class="p-3 text-center border text-dark"><small>Unassigned Content</small></th>
                        <th class="p-3 text-center border text-dark"><small>Announcement Title</small></th>
                        <th class="p-3 text-center border text-dark"><small>Announcement Content</small></th>
                        <th class="p-3 text-center border text-dark"><small>Published</small></th>
                        <th class="p-3 text-center border text-dark"><small>Status</small></th>
                        <th class="p-3 text-center border text-dark"><small>Created At</small></th>
                        <th class="p-3 text-center border text-dark"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>


    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                let tableUrl = route('board-sessions.list');
                $('#order-business-table').DataTable({
                    serverSide: true,
                    ajax: tableUrl,
                    columns: [{
                            className: 'border text-center',
                            data: 'title',
                            name: 'title',
                            render: function(data,_, row) {
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
                            data: 'unassigned_business',
                            name: 'unassigned_business'
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
                            data: 'published',
                            name: 'published'
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


                $(document).on('click', '.btn-lock-session', function(e) {
                    let id = $(this).data('id');
                    let url = route('board-sessions.locked', id);
                    swal({
                        text: "Enter Password to Lock Session",
                        content: {
                            element: "input",
                            attributes: {
                                placeholder: "Password",
                                type: "password",
                            },
                        },
                        buttons: {
                            cancel: "Cancel",
                            confirm: "Lock",
                        },
                    }).then((value) => {
                        if (value) {
                            $.ajax({
                                url: url,
                                type: "POST",
                                data: {
                                    password: value
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#order-business-table').DataTable().ajax
                                            .reload(null, false);
                                    } else {
                                        swal({
                                            text: response.message,
                                            icon: "error",
                                            buttons: false,
                                            timer: 5000,
                                        });
                                    }
                                }
                            });
                        }
                    });

                });

                $(document).on('click', '.btn-unlock-session', function() {
                    let id = $(this).data('id');
                    let url = route('board-sessions.unlocked', id);
                    swal({
                        text: "Enter Password to Unlock Session",
                        content: {
                            element: "input",
                            attributes: {
                                placeholder: "Password",
                                type: "password",
                            },
                        },
                        buttons: {
                            cancel: "Cancel",
                            confirm: "Unlock",
                        },
                    }).then((value) => {
                        if (value) {
                            $.ajax({
                                url: url,
                                type: "POST",
                                data: {
                                    password: value
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#order-business-table').DataTable().ajax
                                            .reload(null, false);
                                    } else {
                                        swal({
                                            text: response.message,
                                            icon: "error",
                                            buttons: false,
                                            timer: 5000,
                                        });
                                    }
                                }
                            });
                        }
                    });
                })

                $(document).on('click', '.btn-delete-session', function() {
                    let id = $(this).data('id');
                    let url = route('board-sessions.destroy', id);
                    swal({
                        text: "Enter Password to Delete Session",
                        content: {
                            element: "input",
                            attributes: {
                                placeholder: "Password",
                                type: "password",
                            },
                        },
                        buttons: {
                            cancel: "Cancel",
                            confirm: "Delete",
                        },
                        dangerMode: true,
                    }).then((value) => {
                        if (value) {
                            $.ajax({
                                url: url,
                                type: "DELETE",
                                data: {
                                    password: value
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#order-business-table').DataTable().ajax
                                            .reload(null, false);
                                    } else {
                                        swal({
                                            text: response.message,
                                            icon: "error",
                                            buttons: false,
                                            timer: 5000,
                                        });
                                    }
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.btn-view-file', function() {
                    let id = $(this).attr('data-id');
                    let path = $(this).attr('data-path');
                    socket.emit('EDIT_FILE', { file_path : path});
                });
            });
        </script>
    @endpush

@endsection
