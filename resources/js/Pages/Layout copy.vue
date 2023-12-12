<script>
import {Link} from "@inertiajs/vue3";
export default {
    components: {
        Link,
    },
    setup(props) {
    },
};
</script>

<template>
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
                        <a href="{{ route('legislation.index') }}">
                            <i data-feather="file" class="align-self-center menu-icon"></i>
                            <span>Legislations</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i data-feather="search" class="align-self-center menu-icon"></i>
                            <span>Legislative Tracking</span>
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
                @endfeature


                <hr class="hr-dashed hr-menu">
                <li class="menu-label my-2">Maintenance</li>
                @feature('user')
                    <li>

                        <a href="{{ route('user.committee.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                            </svg>
                            <span>Committees</span></a>
                    </li>
                    <li>
                        <a href="{{ route('user.sessions.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                            </svg>
                            Order of Business
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.agendas.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                class="bi bi-record me-2" viewBox="0 0 16 16">
                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                            </svg>
                            Chairmanship
                        </a>
                    </li>
                @endfeature
                @feature('administrator')
                    <li>
                        <a href="javascript: void(0);"><i data-feather="folder"
                                class="align-self-center menu-icon"></i><span>Maintenance</span><span class="menu-arrow">
                                <i class="mdi mdi-chevron-right"></i></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{ route('schedules.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" class="bi bi-record me-2" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                                    </svg>
                                    Schedules
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('committee.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" class="bi bi-record me-2" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                                    </svg>
                                    Committees
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('board-sessions.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" class="bi bi-record me-2" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                                    </svg>
                                    Order of Business
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('agendas.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" class="bi bi-record me-2" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                                    </svg>
                                    Chairmanship
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('division.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" class="bi bi-record me-2" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                                    </svg>
                                    Divisions
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('types.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" class="bi bi-record me-2" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                                    </svg>
                                    Types
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
                                class="align-self-center menu-icon"></i><span>Accounts</span><span class="menu-arrow"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{ route('account.index') }}"><i class="mdi mdi-shield-account"></i>Listing</a>
                                <a href="{{ route('account-access-control.index') }}"><i
                                        class="mdi mdi-shield-lock "></i>Committee In-charge</a>
                            </li>
                        </ul>
                    </li>

                    <hr class="hr-dashed hr-menu">
                    <li class="menu-label my-2">Archives</li>
                    <li>
                        <a href="{{ route('regular-session.index') }}">
                            <i data-feather="calendar" class="align-self-center menu-icon"></i>
                            <span>Regular Sessions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('invited-guests.index') }}">
                            <i data-feather="users" class="align-self-center menu-icon"></i>
                            <span>Invited Guests</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('files.index') }}"><i data-feather="layers"
                                class="align-self-center menu-icon"></i><span>File Manager</span></a>
                    </li>
                    <hr class="hr-dashed hr-menu">
                    <li>
                        <a href="{{ route('settings.index') }}"><i data-feather="settings"
                                class="align-self-center menu-icon"></i><span>Settings & Actions</span></a>
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
                                <span class="badge bg-danger rounded-pill noti-icon-badge"></span>
                            </a>
                        </li>
                    @endfeature
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <span class="ms-1 nav-user-name hidden-sm"></span>
                            <img src="{{ asset('/storage/user-images/' . auth()->user()->profile_picture) }}"
                                alt="profile-user" class="rounded-circle thumb-xs" />
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
            </div><!-- container -->

            <div id="offcanvasSubmittedAgenda" class="offcanvas offcanvas-end border-0" style="width : 380px;"
                data-bs-backdrop="false" data-bs-scroll="true" tabindex="-1"
                aria-labelledby="offcanvasSubmittedAgendaLabel">
                <div class="offcanvas-header position-relative">
                    <div class="d-flex flex-row w-100 justify-content-between align-items-center">
                        <h6 id="offcanvasSubmittedAgendaLabel"
                            class="offcanvas-title text-uppercase text-white fw-bold">
                            Approved Agenda</h6>
                        <a class="cursor-pointer text-danger" data-bs-dismiss="offcanvas" aria-label="Close">
                            <i class="mdi mdi-close mdi-24px"></i>
                        </a>
                    </div>

                </div>
                <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0 shadow">
                    <div class="overflow-auto py-4">
                        <div class="overflow-hidden">
                            <ol id="offcanvas-cards" class="kanban-cards" style="padding-left : 0px;"></ol>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer text-center text-sm-start">
                <!-- {{ date('Y', strtotime('-1 year', time())) }} - {{ date('Y') }} &copy; -->
                <!-- {{ config('app.name') }} -->
                 <span class="text-muted d-none d-sm-inline-block float-end">Powered by
                    : PADMO-ITU</span>
            </footer>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->
</template>


