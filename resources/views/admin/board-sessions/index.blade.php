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
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="fw-medium h6 card-title">Ordered Business</h6>
            <a href="{{ route('board-sessions.create') }}" class="btn btn-dark fw-medium shadow-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                New Ordered Business
            </a>
        </div>

        <div class="card-body">
            <div class="p-3">
                <table class="table table-bordered" id="order-business-table">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-2 text-center">
                            Order Business Title
                        </th>
                        <th class="p-2 text-center">Unassigned Title</th>
                        <th class="p-2 text-center">Announcement Title</th>
                        <th class="p-2 text-center">Schedule</th>
                        <th class="p-2 text-center">Created At</th>
                        <th class="p-2 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom border-0" tabindex="-1" id="offCanvasSchedule"
         aria-labelledby="offCanvasScheduleTitle">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title mt-0" id="offcanvasExampleLabel">Schedule Information</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="scheduleInformationContent">
                </div>
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
                    columns: [
                        {
                            className: 'border text-center',
                            name: 'title',
                            render: function (data, type, row) {
                                let filePath = $(row[5]).attr('data-file-path');
                                let id = $(row[5]).attr('data-id');
                                return `<span class="text-decoration-underline fw-medium text-capitalize text-primary cursor-pointer btn-view-file" data-path="${filePath}" data-id="${id}">${data}</span>`;
                            }
                        },
                        {
                            className: 'border text-center',
                            name: 'unassigned_title',
                            render: function (data, type, row) {
                                let filePath = $(row[5]).attr('data-unassigned-file-path');
                                let id = $(row[5]).attr('data-id');
                                return `<span class="text-decoration-underline fw-medium text-capitalize text-primary cursor-pointer btn-view-file" data-path="${filePath}" data-id="${id}">${data}</span>`;
                            }
                        },
                        {
                            className: 'border mx-5',
                            name: 'announcement_title',
                        },
                        {
                            className: 'border text-center',
                            name: 'schedule',
                        },
                        {
                            className: 'border text-center',
                            name: 'created_at',
                        },
                        {
                            className: 'd-flex flex-row align-items-center justify-content-center',
                            name: 'action',
                            orderable: false,
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

                $(document).on('click', '.view-schedule-information', function () {
                    const schedule = $(this).attr('data-id');
                    let endpoint = route('committee-schedule-information.show', schedule);
                    fetch(endpoint)
                        .then(response => response.json())
                        .then(data => {
                            let {schedule} = data;
                            console.log(schedule);
                            $('#scheduleInformationContent').html(``);
                            $('#scheduleInformationContent').append(`
                                <div class="list-group">
                                    <div class="list-group-item align-middle">
                                        <strong>Name</strong> : ${schedule.name}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>Description</strong> : ${schedule.description}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>Date & Time</strong> : ${moment(schedule.date_and_time).format('MMMM Do YYYY')}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>Venue</strong> : ${schedule.venue}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>With Guest</strong> : ${schedule.with_invited_guest == 1 ? "Yes" : "No"}
                                    </div>
                                </div>
                            `);
                        })
                        .catch(error => console.error(error));
                });
            });
        </script>
    @endpush

@endsection
