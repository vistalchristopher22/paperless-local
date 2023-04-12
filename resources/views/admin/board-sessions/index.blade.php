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
                        <th class="p-3 text-center border text-dark">Order Business Title</th>
                        <th class="p-3 text-center border text-dark">Order Business Content</th>
                        <th class="p-3 text-center border text-dark">Unassigned Title</th>
                        <th class="p-3 text-center border text-dark">Unassigned Content</th>
                        <th class="p-3 text-center border text-dark">Announcement Title</th>
                        <th class="p-3 text-center border text-dark">Announcement Content</th>
                        <th class="p-3 text-center border text-dark">Published</th>
                        <th class="p-3 text-center border text-dark">Status</th>
                        <th class="p-3 text-center border text-dark">Action</th>
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
                    processing : true,
                    ajax: tableUrl,
                    columns: [{
                            className: 'border',
                            data: 'title',
                            name: 'title'
                        },
                        {
                            className: 'border',
                            data: 'content',
                            name: 'content'
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
                        dangerMode : true,
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

            });
        </script>
    @endpush

@endsection
