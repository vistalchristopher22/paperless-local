@extends('layouts.app-2')
@section('tab-title', 'List of Committees')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    <div class="card mb-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" id="filterHeader">
            <h6 class="card-title h6 fw-medium text-dark fw-medium">What <span class="text-lowercase">are you looking
                    for</span>?</h6>
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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="fw-bolder text-dark form-label">Lead Committee</label>
                            <select id="filterLeadCommitee" class="form-control" style="width : 100%;">
                                <option value="*">All</option>
                                @foreach ($agendas as $agenda)
                                    <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="fw-bolder text-dark form-label">Expanded Committee</label>
                            <select id="filterExpandedCommittee" class="form-select" style="width : 100%;">
                                <option value="*">All</option>
                                @foreach ($agendas as $agenda)
                                    <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="fw-bolder text-dark form-label">Available Sessions</label>
                            <select id="availableSession" class="form-select" style="width : 100%;">
                                <option value="*">All</option>
                                @foreach ($availableRegularSessions as $availableSession)
                                    <option value="{{ $availableSession->id }}">{{ $availableSession->number }} Regular
                                        Session - {{ $availableSession->year }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label fw-bolder text-dark">Search by Content</label>
                            <input id="filterByContent" class="form-control" placeholder="Enter phrase or word">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="h6 card-title">Committees</h6>
            <div>
                <a href="{{ route('user.committee.create') }}" class="btn btn-dark fw-medium shadow-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    Add New Committee
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="p-3">
                <table class="table table-striped table-bordered" id="committees-table" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th class="p-3 border text-dark align-middle text-uppercase text-truncate">Name</th>
                            <th class="p-3 border text-dark text-center text-uppercase" style="width:180px;">Submitted By
                            </th>
                            <th class="p-3 border text-dark text-uppercase">Lead committee</th>
                            <th class="p-3 border text-dark text-uppercase">Expanded committee</th>
                            <th class="p-3 border text-dark text-uppercase">Other Expanded committee</th>
                            <th class="p-3 border text-dark text-uppercase">Regular Session</th>
                            <th class="p-3 border text-dark text-center text-uppercase">Status</th>
                            <th class="p-3 border text-dark text-center text-uppercase">Submitted At</th>
                            <th class="p-3 border text-center text-dark text-uppercase">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-end border-0" style="width:450px;" tabindex="-1" id="offCanvasCommittee"
        aria-labelledby="offCanvasCommitteeTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 class="offcanvas-title mb-3" id="offCanvasCommitteeTitle"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar-group me-4" id="pictures">
                        <span class="small fw-bolder ms-2 text-muted text-dark" id="picturesDescription"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="leadCommitteeContent">
                </div>
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
            $('select#filterLeadCommitee, select#filterExpandedCommittee').select2({
                theme: "classic"
            });
        </script>

        <script>
            let key = document
                .querySelector('meta[name="auth-key"]')
                .getAttribute("content");

            let applicationType = document
                .querySelector('meta[name="application-type"]')
                .getAttribute("content");

            let networkFolder = document
                .querySelector('meta[name="network-folder"]')
                .getAttribute("content");

            let sourceFolder = document
                .querySelector('meta[name="source-folder"]')
                .getAttribute("content");


            String.prototype.limit = function(limit) {
                let text = this.trim();
                if (text.length > limit) {
                    text = text.substring(0, limit).trim() + '...';
                }
                return text;
            };

            let table = $("#committees-table").DataTable({
                serverSide: true,
                ajax: {
                    url: "/api/committee-list/*/*/*/*",
                },
                processing: true,
                ordering: false,
                language: {
                    processing: '<div class="spinner-border text-info" role="status"></div>',
                },
                columns: [{
                        name: "name",
                        className: "text-truncate",
                        render: (data) => `<span class="mx-2">${data?.limit(30)}</span>`,
                    },
                    {
                        className: "text-center",
                        name: "submitted.fullname",
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        name: "lead_committee",
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        name: "expanded_committee",
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        name: "other_expanded_committee",
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        className: "text-center",
                        name: "schedule",
                        searchable: false,
                        orderable: false,
                    },
                    {
                        name: "status",
                        className: "text-center",
                        render: function(raw) {
                            if (raw == "review") {
                                return `<span class="badge badge-soft-primary text-uppercase">${raw}</span>`;
                            } else if (raw == "approved") {
                                return `<span class="badge badge-soft-success text-uppercase">${raw}</span>`;
                            } else if (raw == "returned") {
                                return `<span class="badge badge-soft-danger text-uppercase">${raw}</span>`;
                            } else {
                                return `<span class="badge badge-soft-warning text-uppercase">${raw}</span>`;
                            }
                        },
                    },
                    {
                        className: "text-center",
                        name: "created_at",
                    },
                    {
                        name: "user_action",
                        orderable: false,
                        searchable: false,
                        render: function(row) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(row, 'text/html');
                            const element = doc.querySelector('.dropdown');
                            const committeeID = element.getAttribute('data-committee-id');
                            const submittedBy = element.getAttribute('data-submitted-by');

                            if (submittedBy === key) {
                                const liElement = document.createElement('li');
                                const liEditFileElement = document.createElement('li');
                                liEditFileElement.classList.add('cursor-pointer');

                                const editFileElement = document.createElement('a');
                                editFileElement.classList.add('dropdown-item');
                                editFileElement.classList.add('btn-view-file');
                                editFileElement.setAttribute('data-path', element.querySelector('.btn-view-file').getAttribute('data-path'));
                                editFileElement.setAttribute('data-readonly', false);
                                editFileElement.textContent = 'Edit File';


                                liEditFileElement.appendChild(editFileElement);

                                liElement.appendChild(liEditFileElement);

                                const editCommitteeElement = document.createElement('a');
                                editCommitteeElement.href = route('user.committee.edit', committeeID);
                                editCommitteeElement.classList.add('dropdown-item');
                                editCommitteeElement.textContent = 'Edit Committee';

                                liElement.appendChild(editCommitteeElement);

                                element.querySelector('.dropdown-menu').appendChild(liElement);
                            }

                            return element.outerHTML;
                        }
                    },
                ],
            });


            // Add debounce for searching
            let searchTimeout;
            const searchInput = $('#committees-table_filter input');
            const delay = 300; // Set delay time in milliseconds

            searchInput.off().on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    table.search($(this).val()).draw();
                }, delay);
            });

            $("#filterLeadCommitee").change(function() {
                let lead = $("#filterLeadCommitee").val();
                let expanded = $("#filterExpandedCommittee").val();
                let session = $("#availableSession").val();
                table.ajax
                    .url(`/api/committee-list/${lead}/${expanded}/*/${session}`)
                    .load(null, false);
            });
            $("#filterExpandedCommittee").change(function() {
                let lead = $("#filterLeadCommitee").val();
                let expanded = $("#filterExpandedCommittee").val();
                let session = $("#availableSession").val();
                table.ajax
                    .url(`/api/committee-list/${lead}/${expanded}/*/${session}`)
                    .load(null, false);
            });

            $("#availableSession").change(function() {
                let lead = $("#filterLeadCommitee").val();
                let expanded = $("#filterExpandedCommittee").val();
                table.ajax
                    .url(`/api/committee-list/${lead}/${expanded}/*/${this.value}`)
                    .load(null, false);
            });

            $("#filterByContent").keyup(function(e) {
                if (e.keyCode == 13) {
                    let lead = $("#filterLeadCommitee").val();
                    let expanded = $("#filterExpandedCommittee").val();
                    let content = $(this).val();
                    if (content == "") {
                        table.ajax
                            .url(`/api/committee-list/${lead}/${expanded}/*/*`)
                            .load(null, false);
                    } else {
                        $.ajax({
                            url: "http://192.168.1.38/api/committee-content/search",
                            method: "POST",
                            data: {
                                key: content,
                                page: 1,
                            },
                            success: function(response) {
                                let ids = response.committees.map(
                                    (committee) => committee.id
                                );
                                if (ids.length === 0) {
                                    table.ajax
                                        .url(`/api/committee-list/-1/-1/*/*`)
                                        .load(null, false);
                                } else {
                                    table.ajax
                                        .url(
                                            `/api/committee-list/${lead}/${expanded}/${
                                    ids.join(",") || "*"
                                }/*`
                                        )
                                        .load(null, false);
                                }
                            },
                        });
                    }
                }
            });



            const loadCanvasContent = (response) => {
                let chairmanAndViceChairmanCount = 2;
                let {
                    agenda
                } = response;

                $('#offCanvasCommitteeTitle').text(agenda.title);
                $('#picturesDescription').text(`${agenda.members.length + chairmanAndViceChairmanCount} Members`);

                $('#pictures').find('picture').remove();
                $('#pictures').prepend(`
                    <picture class="user-avatar user-avatar-group">
                        <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.chairman_information.profile_picture}" >
                    </picture>
                `);

                $('#pictures').prepend(`
                    <picture class="user-avatar user-avatar-group">
                        <img class="thumb-lg rounded-circle" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" alt="${agenda.vice_chairman_information.fullname}">
                    </picture>
                `);

                if (agenda.members) {
                    $('#leadCommitteeContent').html(``);

                    $('#leadCommitteeContent').prepend(`
                        <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <div class="user-avatar">
                                        <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" alt="${agenda.vice_chairman_information.fullname}">
                                    </div>
                                    <span>${agenda.vice_chairman_information.fullname}</span>
                                    <br>
                                    <span>${agenda.vice_chairman_information.district}</span>
                                    <br>
                                    <span>${agenda.vice_chairman_information.sanggunian}</span>
                                </div>
                        </div>
                    `);

                    $('#leadCommitteeContent').prepend(`<span class="fw-bold">Vice Chairman</span>`);


                    $('#leadCommitteeContent').prepend(`
                        <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <div class="user-avatar">
                                        <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.chairman_information.profile_picture}" alt="${agenda.chairman_information.fullname}">
                                    </div>
                                    <span>${agenda.chairman_information.fullname}</span>
                                    <br>
                                    <span>${agenda.chairman_information.district}</span>
                                    <br>
                                    <span>${agenda.chairman_information.sanggunian}</span>
                                </div>
                        </div>
                    `);

                    $('#leadCommitteeContent').prepend(`<span class="fw-bold">Chairman</span>`);
                    $('#leadCommitteeContent').append(`<span class="fw-bold">Members</span>`);

                    agenda.members.forEach((member) => {
                        let {
                            sanggunian_member
                        } = member;
                        let [memberInformation] = sanggunian_member;
                        $('#pictures').prepend(`
                            <picture class="user-avatar user-avatar-group">
                                <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${memberInformation.profile_picture}" alt="${memberInformation.fullname}">
                            </picture>
                        `);

                        $('#leadCommitteeContent').append(`
                            <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <div class="user-avatar">
                                        <img class="thumb-lg rounded-circle" src="/storage/user-images/${memberInformation.profile_picture}" alt="${memberInformation.fullname}">
                                    </div>
                                    <span class="fw-medium">${memberInformation.fullname}</span>
                                    <br>
                                    <span>${memberInformation.district}</span>
                                    <br>
                                    <span>${memberInformation.sanggunian}</span>
                                </div>
                            </div>
                        `);
                    });
                }
            };


            document.addEventListener('click', event => {
                if (event.target.matches('.btn-edit')) {
                    const id = event.target.getAttribute('data-id');
                    fetch(`/committee-file/${id}/edit`)
                        .then(response => response.json())
                        .then(data => socket.emit('EDIT_FILE', data))
                        .catch(error => console.error(error));
                }

                if (event.target.matches('.view-lead-committees')) {
                    const agenda = event.target.getAttribute('data-lead-committee');
                    fetch(`/api/agenda-members/${agenda}`)
                        .then(response => response.json())
                        .then(data => loadCanvasContent(data))
                        .catch(error => console.error(error));
                }

                if (event.target.matches('.view-expanded-comittees')) {
                    const agenda = event.target.getAttribute('data-expanded-committee');
                    fetch(`/api/agenda-members/${agenda}`)
                        .then(response => response.json())
                        .then(data => loadCanvasContent(data))
                        .catch(error => console.error(error));
                }

                if (event.target.matches('.btn-view-file')) {
                    let isReadOnly = event.target.getAttribute("data-readonly");
                    let path = event.target.getAttribute('data-path').replace(/\\/g, '/').replace(
                        sourceFolder,
                        networkFolder
                    );
                    path = path.replace(/\//g, '\\');
                    localSocket.emit("EDIT_FILE", {
                        file_path: path,
                        read_only: isReadOnly,
                    });
                }

                if (event.target.matches(".view-schedule-information")) {
                    const schedule = event.target.getAttribute("data-id");
                    let endpoint = route("committee-schedule-information.show", schedule);
                    fetch(endpoint)
                        .then((response) => response.json())
                        .then((data) => {
                            let {
                                schedule
                            } = data;
                            $("#scheduleInformationContent").html(``);
                            $("#scheduleInformationContent").append(`
                                <div class="list-group">
                                    <div class="list-group-item align-middle">
                                        <strong>Name</strong> : ${schedule.name}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>Description</strong> : ${
                                            schedule.description
                                        }
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>Date & Time</strong> : ${moment(
                                            schedule.date_and_time
                                        ).format("MMMM Do YYYY")}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>Venue</strong> : ${schedule.venue}
                                    </div>

                                    <div class="list-group-item align-middle">
                                        <strong>With Guest</strong> : ${
                                            schedule.with_invited_guest == 1 ? "Yes" : "No"
                                        }
                                    </div>
                                </div>
                            `);
                        })
                        .catch((error) => console.error(error));
                }
            });
        </script>
    @endpush
@endsection
