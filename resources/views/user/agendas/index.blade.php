@extends('layouts.app')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
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
    @else
        <div class="card bg-primary text-white mb-3">
            <div class="card-body alert-dismissible fade show" role="alert">
                You can reorder the rows by dragging and dropping them.
            </div>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card border-0 m-0 ">Complete Listing of Agendas</h6>

        </div>
        <div class="card-body">

            <!-- User Listing Table-->
            <div class="table-responsive">
                <table class="table table-striped border" id="agendas-table">
                    <thead>
                        <tr>
                            <th class="text-center">Order</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Chairman</th>
                            <th class="text-center">Vice Chairman</th>
                            <th class="text-center">Members</th>
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
                                {{-- <td class="text-truncate">{{ $agenda->chairman_information->fullname }}</td> --}}
                                <td class="text-truncate">{{ $agenda->fullname }}</td>
                                {{-- <td>{{ $agenda->vice_chairman_information->fullname }}</td> --}}
                                <td>{{ $agenda->fullname }}</td>
                                <td class="text-center">
                                    @if ($agenda->members->count() > 0)
                                        <a class="text-primary fw-medium view-lead-committees cursor-pointer text-decoration-underline" data-bs-toggle="offcanvas"
                                            data-bs-target="#offCanvasCommittee" aria-controls="offCanvasCommittee"
                                            data-lead-committee="{{ $agenda->id }}">
                                            View Members</a>
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                            },
                        });
                    })
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
