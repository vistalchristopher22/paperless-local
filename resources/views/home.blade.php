@extends('layouts.app-2')
@section('page-title', 'Dashboard')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endprepend
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-0 fw-semibold">Review Committees</p>
                            <h3 class="m-0">{{ $reviewCommittees }}</h3>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-0 fw-semibold">Returned Committees</p>
                            <h3 class="m-0">{{ $returnedCommittees }}</h3>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-0 fw-semibold">Today's Schedule</p>
                            <h3 class="m-0">{{ $todaysSchedule }}</h3>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path
                                        d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                    <path fill-rule="evenodd"
                                        d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-0 fw-semibold">Online Users</p>
                            <h3 class="m-0">{{ $activeUsers }}</h3>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path
                                        d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 text-white h6">Submitted Committees</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover datatable border" id="committees-table" width="100%">
                <thead>
                    <tr class="bg-light">
                        <th class="border text-dark">
                            <span class="ms-5">Name</span>
                        </th>
                        <th class="border text-dark">Lead Committee</th>
                        <th class="border text-dark">Expanded Committee</th>
                        <th class="border text-dark text-center text-capitalize">submitted by</th>
                        <th class="border text-dark text-center text-capitalize">submitted at</th>
                        <th class="border text-center text-dark">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($committees as $committee)
                        <tr id="row-{{ $committee->id }}">
                            <td class="border text-center text-dark">{{ $committee->name }}</td>
                            <td class="border text-dark">{{ $committee->lead_committee_information->title }}</td>
                            <td class="border text-dark">{{ $committee->expanded_committee_information->title }}</td>
                            <td class="text-dark text-center">{{ $committee->created_at->format('F d, Y h:i A') }}</td>
                            <td class="border text-dark text-center">{{ $committee->submitted->last_name }}
                                {{ $committee->submitted->first_name }}</td>
                            <td class="border text-center text-dark">
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                                        <li><a class="dropdown-item"
                                                href="{{ route('committee.edit', $committee->id) }}">Edit</a></li>
                                        <li><a class="dropdown-item btn-approve cursor-pointer"
                                                data-id="{{ $committee->id }}">Approve</a></li>
                                        <li><a class="dropdown-item btn-disapprove cursor-pointer"
                                                data-id="{{ $committee->id }}">Return</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a href="{{ route('committee-file.show', $committee->id) }}"
                                                class="dropdown-item">Show
                                                File</a></li>
                                        <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">Edit
                                                File</button></li>
                                        <li><a class="dropdown-item" target="_blank" download
                                                href="/storage/committees/{{ basename($committee->file_path) }}">Download
                                                File</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $('.datatable').DataTable({});

            let userID = "{{ auth()->user()->id }}";

            $(document).on('click', '.btn-approve', function() {
                let id = $(this).attr('data-id');
                $.ajax({
                    url: '/api/committee-approved',
                    method: 'PUT',
                    data: {
                        id: id,
                        user: userID,
                    },
                    success: function(response) {
                        notyf.success('Committee successfully approved!');
                        $(`#row-${id}`).remove();

                        socket.emit('NOTIFY_APPROVED_COMMITTEE', {
                            committee: response.committee,
                            administrator: userID,
                        })
                    }
                });
            });

            $(document).on('click', '.btn-disapprove', function() {
                let committeeID = $(this).attr('data-id');
                alertify.prompt("Reason", "Short Message",
                    (evt, message) => {
                        if (message) {
                            $.ajax({
                                url: '/api/committee-returned',
                                method: 'PUT',
                                data: {
                                    id: committeeID,
                                    message: message,
                                },
                                success: function(response) {
                                    if (response.success) {
                                        notyf.success(
                                            'Successfully returned to the user who submit it.');
                                        $(`#row-${committeeID}`).remove();

                                        // socket emit for return
                                        socket.emit('NOTIFY_RETURNED_COMMITTEE', {
                                            committee: committeeID,
                                            administrator: userID,
                                        })
                                    }
                                }
                            });
                        }
                    }).set({
                    title: 'Disapprove a committee'
                });
            });

            $(document).on('click', '.btn-edit', function() {
                const id = $(this).attr('data-id');
                fetch(`/committee-file/${id}/edit`)
                    .then(response => response.json())
                    .then(data => socket.emit('EDIT_FILE', data))
                    .catch(error => console.error(error));
            });
        </script>
    @endpush
@endsection
