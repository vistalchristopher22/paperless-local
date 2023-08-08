<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name') }} - @yield('page-title') @yield('tab-title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="" name="author"/>
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    @routes

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    @stack('page-css')

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- App css -->
    <link href="{{ asset('/assets-2/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/assets-2/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/assets-2/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">


    <!-- Google Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">


    <style>
        * {
            font-family: Inter, sans-serif !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            float: left;
            padding-right: .5rem;
            color: #7081b9;
            content: "" !important;
        }


        <
        style > .kanban-board {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .kanban-column {
            /* background-color: #f2f3f6; */
            padding: 10px;
            padding-right: 32px;
            border-radius: 5px;
            margin-bottom: 20px;
            flex-basis: calc(33.33% - 20px);
            /* max-width: calc(33.33% - 20px); */
        }

        .kanban-column h2 {
            margin-top: 0;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .kanban-card {
            /* background-color: #ffffff; */
            background-color: #07073d;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            cursor: move;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .kanban-card h3 {
            margin-top: 0;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kanban-card p {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .kanban-card-placeholder {
            border: 2px dashed #07073d;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 100px;
            margin-bottom: 10px;
            letter-spacing: 1.1px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.1rem;
            color: #999;
        }

        ol {
            list-stype: decimal;
        }

        .bg-dark {
            background-color: #07073d !important;
        }
    </style>


</head>

<body>
<!-- Left Sidenav -->
<div class="left-sidenav">
    <!-- LOGO -->
    <div class="brand bg-dark">
        <a href="{{ route('home') }}" class="logo">
                <span>
                    <img src="{{ asset('/paperless-logo.png') }}" alt="logo-large" width="36px;">
                </span>
            <span class="text-center">
                    <span class="h3 fw-bold text-white p-2 align-middle">
                        PAPERLESS
                    </span>
                </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="menu-label mt-0">Main</li>

            <li>
                <a href="{{ route('login') }}"> <i data-feather="home"
                                                   class="align-self-center menu-icon"></i><span>Dashboard</span></a>
            </li>

            @feature('administrator')
            <li>
                <a href="#">
                    <i data-feather="calendar" class="align-self-center menu-icon"></i>
                    <span>Regular Sessions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('legislation.index') }}">
                    <i data-feather="file" class="align-self-center menu-icon"></i>
                    <span>Legislations</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sanggunian-members.index') }}">
                    <i data-feather="users" class="align-self-center menu-icon"></i>
                    <span>Sanggunian Members</span>
                </a>
            </li>
            @endfeature

            @feature('user')
            <li>
                <a href="{{ route('user.sanggunian-members.index') }}"><i data-feather="users"
                                                                          class="align-self-center menu-icon"></i><span>Sanggunian Members</span></a>
            </li>
            <li>
                <a href="{{ route('user.divisions.index') }}">
                    <i class="mdi mdi-office-building "></i>
                    Divisions
                </a>
            </li>
            @endfeature


            <hr class="hr-dashed hr-menu">
            <li class="menu-label my-2">Documents</li>
            @feature('user')
            <li>

                <a href="{{ route('user.committee.index') }}">
                    <i class="mdi mdi-file-table-outline"></i>
                    <span>Committees</span></a>
            </li>
            <li>
                <a href="{{ route('user.agendas.index') }}">
                    <i class=" mdi mdi-table "></i>
                    Agendas
                </a>
            </li>
            <li>
                <a href="{{ route('user.sessions.index') }}">
                    <i class="mdi mdi-hospital-building"></i>
                    Sessions
                </a>
            </li>
            @endfeature
            @feature('administrator')
            <li>
                <a href="javascript: void(0);"><i data-feather="folder"
                                                  class="align-self-center menu-icon"></i><span>Maintenance</span><span
                        class="menu-arrow">
                                <i class="mdi mdi-chevron-right"></i></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('schedules.index') }}">
                            {{--                            <i class="mdi mdi-calendar"></i>--}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                 class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z"/>
                            </svg>
                            Schedules
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('committee.index') }}">
                            {{--                            <i class="mdi mdi-file-table-outline"></i>--}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                 class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z"/>
                            </svg>
                            Committees
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('board-sessions.index') }}">
                            {{--                            <i class="mdi mdi-hospital-building"></i>--}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                 class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z"/>
                            </svg>
                            Sessions
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('agendas.index') }}">
                            {{--                            <i class=" mdi mdi-table "></i>--}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                 class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z"/>
                            </svg>
                            Agendas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('division.index') }}">
                            {{--                            <i class="mdi mdi-office-building "></i>--}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                 class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z"/>
                            </svg>
                            Divisions
                        </a>
                    </li>
                    @endfeature
                </ul>
            </li>

            @feature('administrator')
            <hr class="hr-dashed hr-menu">
            <li class="menu-label my-2">User Management</li>

            <li>
                <a href="javascript: void(0);"><i data-feather="users"
                                                  class="align-self-center menu-icon"></i><span>Accounts</span><span
                        class="menu-arrow"><i
                            class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('account.index') }}"><i class="mdi mdi-shield-account"></i>Listing</a>
                        <a href="{{ route('account-access-control.index') }}"><i
                                class="mdi mdi-shield-lock "></i>Agenda Control</a>
                    </li>
                </ul>
            </li>

            <hr class="hr-dashed hr-menu">
            <li class="menu-label my-2">Archieves</li>

            <li>
                <a href="{{ route('files.index') }}"><i data-feather="layers"
                                                        class="align-self-center menu-icon"></i><span>File Manager</span></a>
            </li>
            <hr class="hr-dashed hr-menu">
            <li>
                <a href="{{ route('settings.index') }}"><i data-feather="settings"
                                                           class="align-self-center menu-icon"></i><span>Settings</span></a>
            </li>
            @endfeature

        </ul>

    </div>
</div>
<!-- end left-sidenav-->


<div class="page-wrapper">
    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- Navbar -->
        <nav class="navbar-custom">
            <ul class="list-unstyled topbar-nav float-end mb-0">
                @feature('administrator')
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"
                       data-bs-toggle="offcanvas" data-bs-target="#offcanvasSubmittedAgenda"
                       aria-controls="offcanvasSubmittedAgenda">
                        <i data-feather="list" class="topbar-icon"></i>
                        <span
                            class="badge bg-danger rounded-pill noti-icon-badge">{{ $onReviewData->count() }}</span>
                    </a>
                </li>
                @endfeature
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect"
                       data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                       aria-expanded="false">
                        <i data-feather="bell" class="align-self-center topbar-icon"></i>
                        <span class="badge bg-danger rounded-pill noti-icon-badge">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">

                        <h6
                            class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                            Notifications <span class="badge bg-primary rounded-pill">2</span>
                        </h6>
                        <div class="notification-menu" data-simplebar>
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">2 min ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i data-feather="shopping-cart" class="align-self-center icon-xs"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                        <small class="text-muted mb-0">Dummy text of the printing and
                                            industry.</small>
                                    </div>
                                    <!--end media-body-->
                                </div>
                                <!--end media-->
                            </a>
                            <!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">10 min ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <img src="assets/images/users/user-4.jpg" alt=""
                                             class="thumb-sm rounded-circle">
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Meeting with designers</h6>
                                        <small class="text-muted mb-0">It is a long established fact that a
                                            reader.</small>
                                    </div>
                                    <!--end media-body-->
                                </div>
                                <!--end media-->
                            </a>
                            <!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">40 min ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i data-feather="users" class="align-self-center icon-xs"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">UX 3 Task complete.</h6>
                                        <small class="text-muted mb-0">Dummy text of the printing.</small>
                                    </div>
                                    <!--end media-body-->
                                </div>
                                <!--end media-->
                            </a>
                            <!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">1 hr ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <img src="assets/images/users/user-5.jpg" alt=""
                                             class="thumb-sm rounded-circle">
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                        <small class="text-muted mb-0">It is a long established fact that a
                                            reader.</small>
                                    </div>
                                    <!--end media-body-->
                                </div>
                                <!--end media-->
                            </a>
                            <!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">2 hrs ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i data-feather="check-circle" class="align-self-center icon-xs"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Payment Successfull</h6>
                                        <small class="text-muted mb-0">Dummy text of the printing.</small>
                                    </div>
                                    <!--end media-body-->
                                </div>
                                <!--end media-->
                            </a>
                            <!--end-item-->
                        </div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                            View all <i class="fi-arrow-right"></i>
                        </a>
                    </div>
                </li>

                <li class="dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                       data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                       aria-expanded="false">
                            <span class="ms-1 nav-user-name hidden-sm">{{ auth()->user()->first_name }}
                                {{ auth()->user()->last_name }}</span>
                        <img src="{{ asset('/storage/user-images/' . auth()->user()->profile_picture) }}"
                             alt="profile-user" class="rounded-circle thumb-xs"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('information.edit') }}"><i data-feather="user"
                                                                                           class="align-self-center icon-xs icon-dual me-1"></i>
                            Profile</a>
                        <div class="dropdown-divider mb-0"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                <i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
            <!--end topbar-nav-->

            <ul class="list-unstyled topbar-nav mb-0">
                <li>
                    <button class="nav-link button-menu-mobile">
                        <i data-feather="menu" class="align-self-center topbar-icon"></i>
                    </button>
                </li>
            </ul>
        </nav>
        <!-- end navbar-->
    </div>
    <!-- Top Bar End -->

    <!-- Page Content-->
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="row">
                            <div class="col">
                                <h4 class="page-title">@yield('page-title')</h4>
                            </div>
                            <!--end col-->

                        </div>
                        <!--end row-->
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <!-- end page title end breadcrumb -->
            @yield('content')

        </div><!-- container -->

        <div class="offcanvas offcanvas-end border-0" style="width : 380px;" data-bs-backdrop="false"
             data-bs-scroll="true" tabindex="-1" id="offcanvasSubmittedAgenda"
             aria-labelledby="offcanvasSubmittedAgendaLabel">
            <div class="offcanvas-header position-relative">
                <div class="d-flex flex-row w-100 justify-content-between align-items-center">
                    <h6 class="offcanvas-title text-uppercase text-white fw-bold"
                        id="offcanvasSubmittedAgendaLabel">
                        Approved Agenda</h6>
                    </a>
                    <a class="cursor-pointer text-danger" data-bs-dismiss="offcanvas" aria-label="Close">
                        <i class="mdi mdi-close mdi-24px"></i>
                    </a>
                </div>

            </div>
            <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0 shadow">
                <div class="overflow-auto py-4">
                    <div class="overflow-hidden">
                        <ol class="kanban-cards" id="offcanvas-cards" style="padding-left : 0px;">
                            @foreach ($onReviewData as $committee)
                                <span class="text-dark submitted-by" style="pointer-events:none;"
                                      id="parent-index-{{ $loop->index }}">
                                        {{ $committee->submitted->last_name }},
                                        {{ $committee->submitted->first_name }}
                                    </span>
                                <span class="count-index"> </span>
                                <li class="kanban-card text-white" data-id="{{ $committee->id }}"
                                    data-index="{{ $loop->index }}">
                                    {{ $committee->lead_committee_information->title }}
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer text-center text-sm-start">
            {{ date('Y', strtotime('-1 year', time())) }} - {{ date('Y') }} &copy;
            {{ config('app.name') }} <span class="text-muted d-none d-sm-inline-block float-end">Powered by 4rrPADMO-ITU</span>
        </footer>
        <!--end footer-->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->


<!-- jQuery  -->
<script src="{{ asset('/assets-2/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets-2/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets-2/js/metismenu.min.js') }}"></script>
<script src="{{ asset('/assets-2/js/waves.js') }}"></script>
<script src="{{ asset('/assets-2/js/feather.min.js') }}"></script>
<script src="{{ asset('/assets-2/js/simplebar.min.js') }}"></script>
<script src="{{ asset('/assets-2/js/moment.js') }}"></script>
<script src="{{ asset('/assets-2/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.6.1/socket.io.min.js"
        integrity="sha512-AI5A3zIoeRSEEX9z3Vyir8NqSMC1pY7r5h2cE+9J6FLsoEmSSGLFaqMQw8SWvoONXogkfFrkQiJfLeHLz3+HOg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('/assets-2/plugins/tippy/tippy.all.min.js') }}"></script>
<!-- App js -->

<script src="{{ asset('/assets-2/js/jquery.core.js') }}"></script>
<script src="{{ asset('/assets-2/js/app.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
<script>
    let socket = io(`http://localhost:3030/`);

    let notyf = new Notyf({
        dismissible: true,
    });

    tippy('.tippy-btn');
    tippy('#myElement', {
        html: document.querySelector('#feature__html'), // DIRECT ELEMENT option
        arrow: true,
        animation: 'fade'
    });
</script>
<script>
    let notifications = {
        'committee_created': function (data) {
            console.log(data);
            $.ajax({
                url: '/api/notifications/push-notification',
                method: 'POST',
                data: data,
                success: function (response) {
                    notyf.success(response?.description);
                    $('#notification-content').prepend(`
                            <li class="d-flex py-2 align-items-start">
                                <button
                                    class="btn-icon bg-primary-faded text-primary fw-bolder me-3 p-3">${response?.sender?.first_name[0]}</button>
                                <div
                                    class="d-flex align-items-start justify-content-between flex-grow-1">
                                    <div>
                                        <p class="lh-1 mb-2 fw-semibold text-body">${response?.sender?.first_name} ${response?.sender?.last_name}</p>
                                        <p class="text-muted lh-1 mb-2 small">${response?.description}</p>
                                    </div>
                                    <small
                                        class="text-muted fw-bold fs-xs">${response?.created_at}</small>
                                </div>
                            </li>
                        `);

                    let currentNotificationCount = parseInt($('#notification-count').text());
                    $('#notification-number').text(++currentNotificationCount);
                },
            });
        },
        'committee_update': function (data) {
            $.ajax({
                url: '/api/notifications/push-notification',
                method: 'POST',
                data: data,
                success: function (response) {
                    notyf.success(response?.description);

                    $('#notification-content').prepend(`
                            <li class="d-flex py-2 align-items-start">
                                <button
                                    class="btn-icon bg-primary-faded text-primary fw-bolder me-3 p-3">${response?.sender?.first_name[0]}</button>
                                <div
                                    class="d-flex align-items-start justify-content-between flex-grow-1">
                                    <div>
                                        <p class="lh-1 mb-2 fw-semibold text-body">${response?.sender?.first_name} ${response?.sender?.last_name}</p>
                                        <p class="text-muted lh-1 mb-2 small">${response?.description}</p>
                                    </div>
                                    <small
                                        class="text-muted fw-bold fs-xs">${response?.created_at}</small>
                                </div>
                            </li>
                        `);

                    let currentNotificationCount = parseInt($('#notification-count').text());
                    $('#notification-number').text(++currentNotificationCount);
                },
            });
        },
    };
    socket.on('NOTIFY_ADMINISTRATOR', (data) => {
        notifications[data.event](data);
    });
</script>
@feature('user')
<script>
    $(document).ready(function () {
        let notyf = new Notyf({
            duration: 0,
            dismissible: true,
        });


        socket.on('NOTIFY_USER', (data) => {
            $.ajax({
                url: '/api/notifications/user/push-notification',
                method: 'POST',
                data: data,
                success: function (response) {
                    notyf.success(response?.description);
                    $('#notification-content').prepend(`
                            <li class="d-flex py-2 align-items-start">
                                <button class="btn-icon bg-primary-faded text-primary fw-bolder me-3 p-3">${response?.sender?.first_name[0]}</button>
                                <div class="d-flex align-items-start justify-content-between flex-grow-1">
                                    <div>
                                        <p class="lh-1 mb-2 fw-semibold text-body">${response?.sender?.first_name} ${response?.sender?.last_name}</p>
                                        <p class="text-muted lh-1 mb-2 small">${response?.description}</p>
                                    </div>
                                    <small class="text-muted fw-bold fs-xs">${response?.created_at}</small>
                                </div>
                            </li>
                        `);
                }
            });

        });

    });
</script>
@endfeature
@stack('page-scripts')

</body>


</html>
