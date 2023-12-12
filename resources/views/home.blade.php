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
                            <h3 id="returnedCommitteesCount" class="m-0">{{ $returnedCommittees }}</h3>
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

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-dark">
                    <h6 class="card-title text-white h6">
                        Committees
                    </h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div id="pieChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-dark">
                    <h6 class="card-title text-white h6">
                        New Committees Past 7 Days
                    </h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div id="barChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 text-white h6">Submitted Committees
                <span class="text-warning">
                    <small>(review)</small>
                </span>
            </h6>
        </div>
        <div class="card-body">
            <table id="committees-table" class="table table-hover border" width="100%">
                <thead>
                    <tr class="bg-light">
                        <th class="border text-dark">Name</th>
                        <th class="border text-dark">Lead Committee</th>
                        <th class="border text-dark">Expanded Committee</th>
                        <th class="border text-dark text-center text-capitalize">submitted at</th>
                        <th class="border text-dark text-center text-capitalize">submitted by</th>
                        <th class="border text-center text-dark">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 text-white h6">Login History</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped datatable table-bordered border">
                    <thead>
                        <tr class="bg-light">
                            <th class="fw-medium text-center">&nbsp;</th>
                            <th class="fw-medium text-center">User</th>
                            <th class="fw-medium text-center">Account Type</th>
                            <th class="fw-medium text-center">IP Address</th>
                            <th class="fw-medium text-center">Type</th>
                            <th class="fw-medium text-center">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loginHistories as $history)
                            <tr>
                                <td class="text-center">
                                    <img class="rounded-circle thumb-lg"
                                        src="{{ asset('/storage/user-images/' . $history->user->profile_picture) }}"
                                        alt="Profile Picture">
                                </td>
                                <td class="text-dark text-center">
                                    <span class="mx-1"></span>{{ $history->user->fullname }}
                                </td>
                                <td class="text-dark text-center">
                                    <span class="badge badge-soft-primary">
                                        {{ $history->user->account_type }}
                                    </span>
                                </td>
                                <td class="text-dark text-center">
                                    {{ $history->ip_address }}
                                </td>
                                <td class="text-dark text-center">
                                    <span @class([
                                        'badge badge-soft-danger' => $history->type === 'logged_out',
                                        'badge badge-soft-primary' => $history->type === 'logged_in',
                                    ])>
                                        {{ Str::headline($history->type) }}
                                    </span>
                                </td>
                                <td class="text-dark text-center">
                                    <span class="mx-1"></span>{{ $history->logged_in_at->format('F d, Y h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="offCanvasCommittee" class="offcanvas offcanvas-end border-0" style="width:450px;" tabindex="-1"
        aria-labelledby="offCanvasCommitteeTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 id="offCanvasCommitteeTitle" class="offcanvas-title mb-3"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div id="pictures" class="avatar-group me-4">
                        <span id="picturesDescription" class="small fw-bolder ms-2 text-muted text-dark"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div id="leadCommitteeContent" class="overflow-hidden">
                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/apex-charts/apexcharts.min.js') }}"></script>
        <script>
            $('.datatable').DataTable({});
            let table = $('#committees-table').DataTable({
                serverSide: true,
                ajax: {
                    url: '/submitted-committee/list',
                },
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"></div>'
                },
                columns: [{
                        name: 'name',
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        name: 'lead_committee',
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        name: 'expanded_committee',
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        name: 'created_at',
                        className: 'text-center',
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        className: 'text-center',
                        name: 'submitted.fullname',
                        searchable: false,
                        orderable: false,
                        render: (data) => `<span class="mx-2">${data}</span>`,
                    },
                    {
                        className: 'text-center',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ]
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


            let userID = "{{ auth()->user()->id }}";
            let committeeStatus = @json($committeeStatus);
            let committeeStatusValues = @json($committeeStatusValues);

            committeeStatus = committeeStatus.map((value) => value.toUpperCase());
            committeeStatusValues = committeeStatusValues.map((value) => parseInt(value));

            let committeePastSevenDaysLabels = @json($committeePastSevenDaysLabels);
            let committeePastSevenDaysValues = @json($committeePastSevenDaysValues);

            let options = {
                series: committeeStatusValues,
                chart: {
                    fontFamily: 'Inter, sans-serif',
                    width: 500,
                    height: 500,
                    type: 'pie',
                },
                labels: committeeStatus,
            };

            let chart = new ApexCharts(document.querySelector("#pieChart"), options);
            chart.render();

            let barChartOptions = {
                series: [{
                    name: 'Committees',
                    data: committeePastSevenDaysValues,
                }],
                chart: {
                    height: 333,
                    width: 1150,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: false,
                    formatter: function(val) {
                        return parseInt(val);
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: committeePastSevenDaysLabels,
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function(val) {
                            return parseInt(val);
                        }
                    }

                },
                title: {
                    text: 'Committees in Past 7 Days',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                },
            };

            let barChart = new ApexCharts(document.querySelector("#barChart"), barChartOptions);
            barChart.render();

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

                        table.ajax.reload();

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

                                        table.ajax.reload();

                                        let currentCountOfReturnedCommittees = $(
                                            '#returnedCommitteesCount').text()
                                        $('#returnedCommitteesCount').text(++
                                            currentCountOfReturnedCommittees);

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
