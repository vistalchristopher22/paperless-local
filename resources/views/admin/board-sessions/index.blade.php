@extends('layouts.app-2')
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

    @if (session()->has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ session()->get('success') }}
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
                        <th class="p-3 text-center border text-dark">Unassigned Title</th>
                        <th class="p-3 text-center border text-dark">Unassigned Content</th>
                        <th class="p-3 text-center border text-dark">Announcement Title</th>
                        <th class="p-3 text-center border text-dark">Announcement Content</th>
                        <th class="p-3 text-center border text-dark">Published</th>
                        <th class="p-3 text-center border text-dark">Status</th>
                        <th class="p-3 text-center border text-dark">Created At</th>
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
                    ajax: tableUrl,
                    columns: [{
                            className: 'border text-center',
                            data: 'title',
                            name: 'title',
                            render: function(data, _, row) {
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

                let showConfirmation = (url, method, text) => {
                    alertify.prompt(text, "",
                        function(evt, value) {
                            $.ajax({
                                url: url,
                                type: method,
                                data: {
                                    password: value
                                },
                                success: function(response) {
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


                $(document).on('click', '.btn-lock-session', function(e) {
                    let id = $(this).data('id');
                    let url = route('board-sessions.locked', id);
                    showConfirmation(url, "POST", "Enter Password to Lock Session");
                });

                $(document).on('click', '.btn-unlock-session', function() {
                    let id = $(this).data('id');
                    let url = route('board-sessions.unlocked', id);
                    showConfirmation(url, "POST", "Enter Password to Unlock Session");
                })

                $(document).on('click', '.btn-delete-session', function() {
                    let id = $(this).data('id');
                    let url = route('board-sessions.destroy', id);
                    showConfirmation(url, "DELETE", "Enter Password to Delete Session");
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
