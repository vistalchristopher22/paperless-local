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

    <div class="card mb-3 d-none">
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
        <div class="card-header bg-dark d-flex flex-row justify-content-between align-items-center">
            <h6 class="card-title m-0 text-white h6">
                Committees
            </h6>
            <a class="btn btn-light fw-bold" href="{{ route('user.committee.create') }}">Submit Committee</a>
        </div>
        <div class="card-body">
            <table class="table table-striped border datatable" id="committees-table" width="100%">
                <thead>
                    <tr class="bg-light">
                        <th class="text-dark border">Name</th>
                        <th class="text-dark border">Submitted By</th>
                        <th class="text-dark border">Lead Committee</th>
                        <th class="text-dark border">Expanded Committee</th>
                        <th class="text-dark border">Status</th>
                        <th class="text-dark border text-center">Submitted At</th>
                        <th class="text-center border text-dark">Actions</th>
                    </tr>
                </thead>
            </table>
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
            let key = "{{ auth()->user()->id }}";

            String.prototype.limit = function(limit) {
                let text = this.trim();
                if (text.length > limit) {
                    text = text.substring(0, limit).trim() + '...';
                }
                return text;
            };


            let table = $('#committees-table').DataTable({
                order: [
                    [0, "asc"]
                ],
                destroy: true,
                serverSide: true,
                processing: true,
                language: {
                    processing: '<span class="sr-only mt-2">&nbsp;</span> '
                },
                ajax: route('user.committee.list'),
                columns: [{
                        name: 'name',
                        data: 'name',
                        render : function (raw) {
                            return `<span class"mx-5">&nbsp;${raw}</span>`;
                        }
                    },
                    {
                        className : 'text-center',
                        name: 'submitted_by',
                        data: 'submitted_by',
                        render: function (raw, _, data) {
                            if(data.submitted.id == key) {
                                return `<span class="badge badge-soft-primary">You</span>`;
                            } 
                            return raw;
                        }
                    },
                    {
                        name: 'lead_committee_information.title',
                        data: 'lead_committee_information.title',
                        render: function(rowData, _, row) {
                            return `
                                <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                aria-controls="offCanvasCommittee"
                                data-expanded-committee="${row.lead_committee}"
                                class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
                                    ${rowData.limit(50) || ''}
                                </a>
                            `;
                        }
                    },
                    {
                        name: 'expanded_committee_information.title',
                        data: 'expanded_committee_information.title',
                        render: function(rowData, _, row) {
                            return `
                                <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                aria-controls="offCanvasCommittee"
                                data-expanded-committee="${row.expanded_committee}"
                                class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
                                    ${rowData.limit(50) || ''}
                                </a>
                            `;
                        },
                    },
                    {
                        name: 'status',
                        className: 'text-center',
                        data: 'status',
                        render: function(raw) {
                            if (raw == 'review') {
                                return `<span class="badge badge-soft-primary text-uppercase">${raw}</span>`;
                            } else if (raw == 'approved') {
                                return `<span class="badge badge-soft-success text-uppercase">${raw}</span>`;
                            } else if (raw == 'returned') {
                                return `<span class="badge badge-soft-danger text-uppercase">${raw}</span>`;
                            } else {
                                return `<span class="badge badge-soft-warning text-uppercase">${raw}</span>`;
                            }
                        }
                    },
                    {
                        className: 'text-center',
                        name: 'submitted_at',
                        data: 'submitted_at',
                    },
                    {
                        className : 'text-center',
                        name: 'actions',
                        data: 'actions',
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

            $('#filterLeadCommitee').change(function() {
                let lead = $('#filterLeadCommitee').val();
                let expanded = $('#filterExpandedCommittee').val();
                let content = $('#filterByContent').val();
                table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
            });

            $('#filterExpandedCommittee').change(function() {
                let lead = $('#filterLeadCommitee').val();
                let expanded = $('#filterExpandedCommittee').val();
                let content = $('#filterByContent').val();
                table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
            });

            $('#filterByContent').keyup(function(e) {
                if (e.keyCode == 13) {
                    let lead = $('#filterLeadCommitee').val();
                    let expanded = $('#filterExpandedCommittee').val();
                    let content = $(this).val();
                    table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
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
            });
        </script>
    @endpush
@endsection