@extends('layouts.app-2')
@section('tab-title', 'Ordered Business')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endprepend

@section('content')

    <div class="modal fade" tabindex="-1" id="viewLink">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title card-title h6">View Link</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center" style="overflow-y: hidden">
                    <a id="viewLinkText" class="fw-bold" target="_blank"></a>
                </div>
            </div>
        </div>
    </div>

    @if (count($settingsMissingStatus) !== 0)
        <div class="card bg-danger text-white mb-3">
            <div class="card-body alert-dismissible fade show" role="alert">
                Oops, it seems that some required <a class="text-white text-decoration-underline fw-bold"
                    href="{{ route('settings.index') }}">settings</a> are missing.
                Please make sure all the necessary settings
                (such as First Reading, Second Reading, Third Reading, Unassigned Business, and Announcement) are
                properly configured for the feature to work as expected.
            </div>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" id="filterHeader">
            <h6 class="card-title h6 fw-medium text-dark">What <span class="text-lowercase">are you looking for</span>?
            </h6>
            <button class="btn btn-dark shadow-dark" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-funnel-fill" viewBox="0 0 16 16">
                    <path
                        d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
                </svg>
            </button>
        </div>
        <div class="collapse" id="filterCollapse">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="availableSession" class="fw-bolder form-label h6 text-uppercase">Available
                            Sessions</label>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select name="availableSession" class="form-select" style="width: 100%" id="availableSession">
                                <option value="*">All</option>
                                @foreach ($availableRegularSessions as $availableRegularSession)
                                    <option value="{{ $availableRegularSession->id }}">
                                        {{ $availableRegularSession->number }}
                                        - Regular Session
                                        {{ $availableRegularSession->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="fw-medium h6 card-title">Ordered Business</h6>
            <a href="{{ route('board-sessions.create') }}" class="btn btn-dark fw-medium shadow-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
                New Ordered Business
            </a>
        </div>

        <div class="card-body">
            <div class="p-3">
                <table class="table table-bordered" id="order-business-table">
                    <thead>
                        <tr class="bg-light">
                            <th class="p-2 text-center text-uppercase text-dark">Order Business Title</th>
                            <th class="p-2 text-center text-uppercase text-dark">Regular Session</th>
                            <th class="p-2 text-center text-uppercase text-dark">Filename</th>
                            <th class="p-2 text-center text-uppercase text-dark">Created At</th>
                            <th class="p-2 text-center text-uppercase text-dark">Action</th>
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                let applicationType = document
                    .querySelector('meta[name="application-type"]')
                    .getAttribute("content");

                let networkFolder = document
                    .querySelector('meta[name="network-folder"]')
                    .getAttribute("content");

                let sourceFolder = document
                    .querySelector('meta[name="source-folder"]')
                    .getAttribute("content");


                $('select#availableSession').select2({});
                let removeTimestampPrefix = (fileName) => {
                    let timeStamp = fileName.split("_").shift() + "_";
                    return fileName.replace(timeStamp, "");
                };

                let tableUrl = route('board-sessions.list', '*');
                let table = $('#order-business-table').DataTable({
                    serverSide: true,
                    ajax: tableUrl,
                    destroy: true,
                    columns: [{
                            className: 'border text-start',
                            name: 'title',
                            render: function(data, type, row) {
                                let filePath = $(row[4]).attr('data-file-path');
                                let id = $(row[4]).attr('data-id');
                                return `<span class="text-decoration-underline mx-4 fw-medium text-capitalize text-primary cursor-pointer btn-view-file" data-path="${filePath}" data-id="${id}">${data}</span>`;
                            }
                        },
                        {
                            className: 'border text-center',
                            name: 'schedule',
                        },
                        {
                            className: 'border text-center',
                            name: 'file_path',
                            render: (data) => {
                                let fileName = data.split(["\\"]).pop();
                                return removeTimestampPrefix(fileName);
                            }
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

                $('#availableSession').change(function() {
                    tableUrl = route('board-sessions.list', $(this).val());
                    table.ajax.url(tableUrl).load(null, false);
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


                $(document).on('click', '.btn-published', function(e) {
                    let id = $(this).data('id');
                    let url = route('board-sessions.published', id);
                    showConfirmation(url, "POST", "Enter Password to Published");
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



                    if (applicationType) {
                        let path = $(this).attr('data-path');

                        socket.emit('EDIT_FILE', {
                            file_path: path
                        });
                    } else {
                        let path = $(this).attr('data-path').replace(/\\/g, '/').replace(
                            sourceFolder,
                            networkFolder
                        );
                        path = path.replace(/\//g, '\\');
                        localSocket.emit("EDIT_FILE", {
                            file_path : path,
                        });
                    }

                });

                $(document).on('click', '.view-schedule-information', function() {
                    const schedule = $(this).attr('data-id');
                    let endpoint = route('committee-schedule-information.show', schedule);
                    fetch(endpoint)
                        .then(response => response.json())
                        .then(data => {
                            let {
                                schedule
                            } = data;
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


                $(document).on('click', '.btn-inspect-link', function(event) {
                    document.querySelector("#viewLinkText").innerHTML = event.target.getAttribute(
                        "data-view-link");
                    $("#viewLink").modal("toggle");
                });
            });
        </script>
    @endpush

@endsection
