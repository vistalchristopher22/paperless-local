@extends('layouts.app')
@section('page-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
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
        <div class="card-header">
            <h6>What are you looking for?</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-medium">Lead Committee</label>
                        <select id="filterLeadCommitee" class="form-select">
                            <option value="*">All</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-medium">Expanded Committee</label>
                        <select id="filterExpandedCommittee" class="form-select">
                            <option value="*">All</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Search by content</label>
                        <input id="filterByContent" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped border" id="committees-table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center text-dark">&nbsp;</th>
                        <th class="text-center text-dark">Priority Number</th>
                        <th class="text-dark">Name</th>
                        <th class="text-dark">Schedule</th>
                        <th class="text-dark">Lead Committee</th>
                        <th class="text-dark">Expanded Committee</th>
                        <th class="text-dark text-center">Created At</th>
                        <th class="text-center text-dark">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark">&nbsp;</th>
                        <th class="text-dark text-center">&nbsp;</th>
                        <th class="text-center text-dark">&nbsp;</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasCommittee" aria-labelledby="offCanvasCommitteeTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 class="offcanvas-title mb-3" id="offCanvasCommitteeTitle"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar-group me-4" id="pictures">
                        <span class="small fw-bolder ms-2 text-muted text-dark" id="picturesDescription"></span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close text-reset position-absolute top-20 end-5" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="leadCommitteeContent">
                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $('select#filterLeadCommitee, select#filterExpandedCommittee').select2({
                theme: "classic"
            });
        </script>

        <script>
            $('#filterByContent').val('');

            let limitString = (str, limit) => {
                if (str.length <= limit) {
                    return str;
                }

                return str.substr(0, limit) + '...';
            }


            /* Formatting function for row details - modify as you need */
            function format(d) {
                // `d` is the original data object for the row
                return (
                    '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>Content: </td>' +
                    '<td>' +
                    d.content +
                    '</td>' +
                    '</tr>' +
                    '</table>'
                );
            }


            let table = $('#committees-table').DataTable({
                order: [[0, "asc"]],
                destroy: true,
                serverSide: true,
                processing: true,
                language: {
                    processing: '<span class="sr-only mt-2">&nbsp;</span> '
                },
                ajax: `/user/committee`,
                columns: [
                    {
                        className: 'text-center dt-control',
                        name: 'id',
                        data: 'id',
                        render: () => ``,
                    },
                    {
                        className: 'text-center fw-bold',
                        name: 'priority_number',
                        data: 'priority_number',
                    },
                    {
                        name: 'name',
                        data: 'name',
                    },
                    {
                        name: 'session_schedule',
                        data: 'session_schedule',
                    },
                    {
                        name: 'lead_committee_information.title',
                        data: 'lead_committee_information.title',
                        render: function (rowData, _, row) {
                            return `
                                <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                aria-controls="offCanvasCommittee"
                                data-expanded-committee="${row.lead_committee}"
                                class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
                                    ${rowData || ''}
                                </a>
                            `;
                        }
                    },
                    {
                        name: 'expanded_committee_information.title',
                        data: 'expanded_committee_information.title',
                        render: function (rowData, _, row) {
                            return `
                                <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                aria-controls="offCanvasCommittee"
                                data-expanded-committee="${row.expanded_committee}"
                                class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
                                    ${rowData || ''}
                                </a>
                            `;
                        },
                    },
                    {
                        className: 'text-center',
                        name: 'created_at',
                        data: 'created_at',
                    },
                    {
                        name: 'id',
                        data: 'id',
                        render: function (id, _, row) {
                            return `
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                                    <li><a href="${route('committee-file.show', id)}"
                                            class="dropdown-item">Show File</a></li>

                                </ul>
                            </div>
                            `;
                        },
                    },
                ],
            });


            table.on('draw', function () {
                if ($('#filterByContent').val()) {
                    var rows = table.rows({ search: 'applied' }).nodes();

                    $.each(rows, function (index) {
                        var tr = $(this).closest('tr');
                        var row = table.row(tr);

                        row.child(format(row.data())).show();
                        tr.addClass('shown');
                    });
                }
            });


            // Add debounce for searching
            let searchTimeout;
            const searchInput = $('#committees-table_filter input');
            const delay = 300; // Set delay time in milliseconds

            searchInput.off().on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    table.search($(this).val()).draw();
                }, delay);
            });

            $('#filterLeadCommitee').change(function () {
                let lead = $('#filterLeadCommitee').val();
                let expanded = $('#filterExpandedCommittee').val();
                let content = $('#filterByContent').val();
                table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
            });

            $('#filterExpandedCommittee').change(function () {
                let lead = $('#filterLeadCommitee').val();
                let expanded = $('#filterExpandedCommittee').val();
                let content = $('#filterByContent').val();
                table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
            });

            $('#filterByContent').keyup(function (e) {
                if (e.keyCode == 13) {
                    let lead = $('#filterLeadCommitee').val();
                    let expanded = $('#filterExpandedCommittee').val();
                    let content = $(this).val();
                    table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
                }

            });


            // Add event listener for opening and closing details
            $('#committees-table tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
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
                    <picture class="avatar-group-img">
                        <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.chairman_information.profile_picture}" alt="${agenda.chairman_information.fullname}">
                    </picture>
                `);

                $('#pictures').prepend(`
                    <picture class="avatar-group-img">
                        <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" alt="${agenda.vice_chairman_information.fullname}">
                    </picture>
                `);

                if (agenda.members) {
                    $('#leadCommitteeContent').html(``);

                    $('#leadCommitteeContent').prepend(`
                        <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}"
                                    alt="${agenda.vice_chairman_information.fullname}">
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
                                    <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.chairman_information.profile_picture}"
                                    alt="${agenda.chairman_information.fullname}">
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
                            <picture class="avatar-group-img">
                                <img class="f-w-10 rounded-circle" src="/storage/user-images/${memberInformation.profile_picture}"
                                    alt="${memberInformation.fullname}">
                            </picture>
                        `);

                        $('#leadCommitteeContent').append(`
                            <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <img class="f-w-10 rounded-circle" src="/storage/user-images/${memberInformation.profile_picture}"
                                    alt="${memberInformation.fullname}">
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
            });

        </script>
    @endpush
@endsection
