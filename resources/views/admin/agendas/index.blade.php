@extends('layouts.app-2')
@section('tab-title', 'Complete Listing of Agendas')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
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
    @else
        <div class="card bg-primary text-white mb-3">
            <div class="card-body alert-dismissible fade show" role="alert">
                You can rearrange the order of the rows by dragging and dropping them. Simply click and hold on a row,
                then
                drag it to the desired position and release the mouse button to drop it. This allows you to easily
                customize
                the order of the rows to suit your needs.
            </div>
        </div>
    @endif
    <div class="form-group">
        <label for="filterBySanggunian" class="form-label">Filter By Sanggunian</label>
        <select id="filterBySanggunian" class="form-control">
            <option value="">All</option>
            @foreach ($sanggunians as $sanggunian)
                <option value="{{ $sanggunian }}">{{ addNumberSuffix($sanggunian) . ' Sanggunian Panlalawigan' }}</option>
            @endforeach
        </select>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-light p-3 justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 text-dark fw-medium">Complete Listing <span class="text-lowercase">of</span>
                Committees</h6>
            <div class="dropdown">
                <a href="{{ route('agendas.create') }}" class="btn btn-light btn-dark shadow-dark fw-medium">
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

            <div class="table-responsive">
                <table class="table table-striped border" id="agendas-table">
                    <thead>
                        <tr>
                            <th class="p-3 text-center bg-light border">Order</th>
                            <th class="p-3 text-center bg-light border">Title</th>
                            <th class="p-3 text-center bg-light border">Chairman</th>
                            <th class="p-3 text-center bg-light border">Vice Chairman</th>
                            <th class="p-3 text-center bg-light border">Sanggunian</th>
                            <th class="p-3 text-center bg-light border">Members</th>
                            <th class="p-3 text-center bg-light border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas as $agenda)
                            <tr class="align-middle draggable" data-id="{{ $agenda->id }}">
                                <td class="text-center">
                                    {{ $agenda->index }}
                                </td>
                                <td class="text-start">
                                    <span class="mx-3">
                                        {{ Str::limit($agenda->title, 50, '...') }}</span>
                                </td>
                                <td class="text-truncate">{{ $agenda?->chairman_information?->fullname }}</td>
                                <td>{{ $agenda?->vice_chairman_information?->fullname }}</td>
                                <td>
                                    @if (!is_null($agenda->sanggunian) && $agenda->sanggunian !== 0)
                                        {{ addNumberSuffix($agenda->sanggunian) . ' Sanggunian Panlalawigan' }}
                                    @else
                                        <span class="text-center">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($agenda->members->count() > 0)
                                        <a class="text-primary fw-medium view-lead-committees cursor-pointer text-decoration-underline"
                                            data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                            aria-controls="offCanvasCommittee" data-lead-committee="{{ $agenda->id }}">
                                            View Members</a>
                                    @endif

                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-success text-white" title="Edit Agenda" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-original-title="Edit Agenda"
                                        href="{{ route('agendas.edit', $agenda) }}">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" style="width:450px;" tabindex="-1" id="offCanvasCommittee"
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
        <script src="//cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
        <script>
            $(document).ready(function() {

                let table = $('#agendas-table').DataTable({
                    ordering: false,
                    pageLength: 100,
                    rowReorder: {
                        dataSrc: 'id',
                        update: false,
                        selector: 'tr',
                        snapX: 5,
                        scrollX: true
                    },
                });

                table.on('row-reorder', function(e, details, changes) {
                    details.forEach((row, index) => {
                        // Get the first cell of the row
                        let [orderCell] = row.node.children;
                        orderCell.innerText = `${row.newPosition + 1}`;

                        $.ajax({
                            url: '/re-order/agenda',
                            method: 'POST',
                            data: {
                                id: `${row.node.getAttribute('data-id')}`,
                                index: `${row.newPosition + 1}`,
                            }
                        });
                    });

                    if (changes.nodes.length !== 0) {
                        notyf.success('Re-order successfully!');
                    }
                });

                $('#filterBySanggunian').on('change', function() {
                    let selectedSanggunian = $(this).val();
                    if (selectedSanggunian !== "") {
                        table.column(4).search(selectedSanggunian).draw();
                    } else {
                        table.column(4).search('').draw();
                    }
                });

            });
        </script>

        <script>
            const loadCanvasContent = (response) => {
                let chairmanAndViceChairmanCount = 2;
                let {
                    agenda
                } = response;

                $('#offCanvasCommitteeTitle').text(agenda.title);
                $('#picturesDescription').html(`<br>${agenda.members.length + chairmanAndViceChairmanCount} Members`);

                $('#pictures').find('picture').remove();
                $('#pictures').prepend(`
                    <picture class="user-avatar user-avatar-group me-4">
                        <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.chairman_information.profile_picture}" >
                    </picture>
                `);

                $('#pictures').prepend(`
                    <picture class="user-avatar user-avatar-group">
                        <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" >
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
                if (event.target.matches('.view-lead-committees')) {
                    const agenda = event.target.getAttribute('data-lead-committee');
                    fetch(`/api/agenda-members/${agenda}`)
                        .then(response => response.json())
                        .then(data => loadCanvasContent(data))
                        .catch(error => console.error(error));
                }
            });
        </script>
    @endpush
@endsection
