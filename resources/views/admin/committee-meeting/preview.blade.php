<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8"/>

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles.mine280.css?v=0eb413625a') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --ghost-accent-color: #04142c;
        }

        * {
            font-family: 'Inter', sans-serif;
            font-weight: normal;
        }


        .text-action {
            color: rgb(3, 79, 250) !important;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sidebar {
            width: 200px;
        }


        .sidebar-nav > ul > li > a {
            font-weight: normal;
            letter-spacing: 1.5px;
        }


        .card-body {
            padding: 1.25rem;
        }

        .text-center {
            text-align: center;
        }


        .fw-bold {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }

        .schedule-container {
            margin-top: 1.25rem;
        }

        .mt-5 {
            margin-top: 1.25rem !important;
        }

        .mt-3 {
            margin-top: 0.75rem !important;
        }


        ol {
            list-style: none;
        }

        .text-dark {
            color: #212529 !important;
        }


        .container {
            max-width: 1500px;
            padding: 50px;
            padding-bottom: 0px;
            background: white;
        }

        .header-logo {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            border: 1px solid #f2f3f6;
            border-left: 0;
            border-right: 0;
            border-top: 0;
            border-width: 3.5px;
        }

        .fs-2 {
            font-size: 1.1rem !important;
        }

        .shadow {
            box-shadow: 2px 0px 20px #f2f6fb;
        }

        .committee-details {
            display: flex;
            flex-direction: column;
            /* line-height: 23px; */
            transition: all 0.3s ease;
            /* add a transition */
        }


        .committee-details {
            display: flex;
            flex-direction: column;
            /* line-height: 23px; */
        }

        .highlight {
            background: #fff0a6;
            transition: background-color 0.3s ease-in;
            border-radius: 5px;
        }

        .member-clicked {
            border-left: 5px solid #f2f3f6;
            transition: all 0.2s ease;
            padding-left: 5px;
            font-weight: 500;
        }

        .agenda {
            transition: all 0.2s ease-in;
            border-radius: 5px;
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>


<body class="home-template">
<main>
    <aside class="sidebar no-image">
        <div style="display:flex; justify-content:center; align-items:center;">
            <div>
                <a class="btn" style="cursor:pointer; color:white;" id="btnMenu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                         class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="sidebar-inner" style="overflow-y: hidden;">
            <nav class="sidebar-nav ">
                <ul>
                    @foreach ($members as $member)
                        <li style="display:flex;" data-search-content="{{ Str::of($member->fullname)->snake() }}"
                            data-agenda-chairman="{{ $member->agenda_chairman }}"
                            data-agenda-vice-chairman="{{ $member->agenda_vice_chairman }}"
                            data-agenda-member="{{ $member->agenda_member }}"
                            data-expanded-agenda-chairman="{{ $member->expanded_agenda_chairman }}"
                            data-expanded-agenda-vice-chairman="{{ $member->expanded_agenda_vice_chairman }}"
                            data-expanded-agenda-member="{{ $member->expanded_agenda_member }}"
                            class="sanggunian-member-item list-group-members-item">
                            <img class="img-fluid" style="margin-right : 5px; border-radius : 5px;"
                                 src="{{ asset('storage/user-images/' . $member->profile_picture) }}" width="50px">
                            <a href="#" class="member-name">
                                hon. {{ $member->lastname }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </aside>

    <section class="content shadow" style="background: #f2f3f6; margin-left : 200px !important;">
        <nav class="site-nav" style="background: white;">
            <ul class="nav" role="menu">
                <li class="nav-home nav-current" role="menuitem"><a
                        href="{{ route('scheduled.committee-meeting.today', $dates) }}">Committee Meeting</a></li>
                <li class="nav-style-guide" role="menuitem"><a
                        href="{{ route('board-sessions-published.preview', $dates) }}">Session</a></li>
            </ul>
        </nav>


        <section class="site-title no-image">
            <div class="container" style="margin-top: 15px;">
                <div class="hero-content">
                    <div class="header-logo">
                        <img src="{{ asset('session/logo.png') }}" alt="" width="170px"
                             style="margin-right: auto;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <span style="color: #212529; font-size: 1.1rem;">Republic of the Philippines</span>
                            <br>
                            <span style="color: #212529; font-size: 1.1rem;">PROVINCE OF SURIGAO DEL SUR</span>
                            <br>
                            <span style="color: #212529; font-size: 1.1rem;">Tandag City</span>
                            <br>
                            <span style="color: #212529; font-size: 1.1rem;">TANGGAPAN NG SANGGUNIANG
                                    PANLALAWIGAN</span>
                            <br>
                            <span style="color: #212529; font-size: 1.1rem;">(Office of the Provincial
                                    Council)</span>
                            <br>
                        </div>
                        <img src="{{ asset('assets/tsp.png') }}" alt="" width="188px"
                             style="margin-left: auto;">
                    </div>
                </div>
            </div>
        </section>

        <main id="site-main" class="container">
            <div class="card" id="committeeDocuments">
                <div class="card-body">
                    <div class="text-center">
                            <span class="fs-2" style="letter-spacing : 1.8px;">
                                SCHEDULE OF COMMITTEE MEETINGS
                                <br>
                                <span class="text-uppercase fw-bold">
                                    {{ $schedules?->first()?->first()?->venue }}
                                </span>
                            </span>
                    </div>

                    <br>
                    <br>

                    @foreach ($schedules as $index => $grouppedSchedules)
                        <div id="{{ $index }}" class="schedule-container">
                            @foreach ($grouppedSchedules as $key => $schedule)
                                @if (
                                    $key === 0 ||
                                        $schedule->date_and_time->format('Y-m-d') !== $grouppedSchedules[$key - 1]->date_and_time->format('Y-m-d'))
                                    <div class="text-center">
                                            <span class="fw-bold text-center fs-2">
                                                <span class="text-uppercase">
                                                    @if ($schedule->date_and_time->hour === 0)
                                                        {{ $schedule->date_and_time->format('F d, Y') }}
                                                    @else
                                                        {{ $schedule->date_and_time->format('F d, Y @ h:i A') }}
                                                    @endif
                                                </span>
                                            </span>
                                    </div>
                                    @php $countIndex = 1; @endphp
                                @endif

                                @if ($schedule->with_invited_guest == 1)
                                    <p class="text-uppercase text-center mt-3 fs-2" style="letter-spacing : 2px;">
                                        <u>
                                            COMMITTEE WITH INVITED GUESTS
                                        </u>
                                    </p>
                                    <div class="">
                                        <ol class="committee-container" id="{{ $schedule->id }}">
                                            @foreach ($schedule->committees as $committee)
                                                <li style="font-size:1.2rem; margin-top : 25px;"
                                                    class="committee-agenda-item"
                                                    data-id="{{ $committee->lead_committee }}">
                                                    <a target="_blank"
                                                       href="{{ route('committee-file.show', $committee) }}"
                                                       class="">
                                                            <span class="text-dark">
                                                                <span class="count-index">{{ $countIndex }}. </span>
                                                                Committee on
                                                                <span class="agenda fw-bold"
                                                                      data-lead-committee="{{ $committee->lead_committee }}">
                                                                    {{ Str::remove('COMMITTEE ON', Str::upper($committee->lead_committee_information->title)) }}
                                                                </span>
                                                                @if (!is_null($committee->expanded_committee))
                                                                    <span>/</span>
                                                                @endif
                                                                <span class="agenda fw-bold"
                                                                      data-expanded-committee="{{ $committee?->expanded_committee }}">{{ Str::remove('COMMITTEE ON', Str::upper($committee?->expanded_committee_information?->title)) }}</span>
                                                            </span>
                                                    </a>
                                                    @php $countIndex++; @endphp
                                                </li>
                                                <div class="committee-details">
                                                    <div>
                                                        <div>
                                                            Chairman : <span
                                                                class="text-action">{{ $committee->lead_committee_information->chairman_information->fullname }}</span>
                                                        </div>
                                                        <div>
                                                            Vice Chairman : <span
                                                                class="text-action">{{ $committee->lead_committee_information->vice_chairman_information->fullname }}</span>
                                                        </div>
                                                    </div>
                                                    <span>
                                                            Members :
                                                            @foreach ($committee->lead_committee_information->members as $member)
                                                            <span
                                                                class="text-action">{{ Str::of($member->sanggunian_member->pluck('lastname')[0])->prepend('Hon. ') }}</span>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                        </span>
                                                </div>
                                                <br>
                                                <br>
                                            @endforeach
                                        </ol>
                                    </div>
                                    <br>
                                    <br>
                                @else
                                    <p class="text-uppercase text-center fs-2" style="letter-spacing : 2px;">
                                        <u>
                                            COMMITTEE WITHOUT INVITED GUESTS
                                        </u>
                                    </p>
                                    <div class="">
                                        <ol class="committee-container" id="{{ $schedule->id }}">
                                            @foreach ($schedule->committees as $committee)
                                                <li style="font-size:1.2rem; margin-top : 25px;"
                                                    data-id="{{ $committee->lead_committee }}"
                                                    class="committee-agenda-item">
                                                    <a target="_blank"
                                                       href="{{ route('committee-file.show', $committee) }}"
                                                       class="">
                                                            <span class="text-dark">
                                                                <span class="count-index">{{ $countIndex }}. </span>
                                                                Committee on
                                                                <span class="agenda fw-bold"
                                                                      data-lead-committee="{{ $committee->lead_committee }}">{{ Str::remove('COMMITTEE ON', Str::upper($committee->lead_committee_information->title)) }}</span>
                                                                @if (!is_null($committee->expanded_committee))
                                                                    <span>/</span>
                                                                @endif
                                                                <span class="agenda fw-bold"
                                                                      data-expanded-committee="{{ $committee?->expanded_committee }}">{{ Str::remove('COMMITTEE ON', Str::upper($committee?->expanded_committee_information?->title)) }}</span>
                                                            </span>
                                                    </a>
                                                    @php $countIndex++; @endphp
                                                </li>
                                                <div class="committee-details">
                                                    <div>
                                                        <div>
                                                            Chairman : <span
                                                                class="text-action">{{ $committee->lead_committee_information->chairman_information->fullname }}</span>
                                                        </div>
                                                        <div>
                                                            Vice Chairman : <span
                                                                class="text-action">{{ $committee->lead_committee_information->vice_chairman_information->fullname }}</span>
                                                        </div>
                                                    </div>
                                                    <span>Members :
                                                            @foreach ($committee->lead_committee_information->members as $member)
                                                            <span
                                                                class="text-action">{{ Str::of($member->sanggunian_member->pluck('lastname')[0])->prepend('Hon. ') }}</span>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                        </span>
                                                </div>
                                                <br>
                                                <br>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
        <br>
    </section>

    <div class="mainopShadow"></div>
    <div class="fab">
        <div class="mainop">
            <i id="addIcon" class="material-icons">add</i>
        </div>


        <div id="reset" class="minifab option-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                 class="bi bi-x" viewBox="0 0 16 16">
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </div>

        <div id="fullscreen" class="minifab option-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                 class="bi bi-arrows-angle-expand" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707z"/>
            </svg>
        </div>

        <div id="decrease-font-size" class="minifab option-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                 class="bi bi-dash" viewBox="0 0 16 16">
                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
            </svg>
        </div>

        <div id="increase-font-size" class="minifab option-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                 class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
            </svg>
        </div>
    </div>
</main>

<script type="text/javascript" src="{{ asset('scripts.mine280.js?v=0eb413625a') }}"></script>
<script>
    window.onload = function () {
        const savedSidebarState = localStorage.getItem('isSidebarOpen');
        if (savedSidebarState === 'false') {
            toggleSidebar();
        }
    };

    let memberItems = document.querySelectorAll('.sanggunian-member-item');

    const clearLocalStorageItems = (keys) => keys.forEach((key) => localStorage.removeItem(key));

    function highlightMatchingAgendaItems(e) {
        const {
            agendaChairman,
            agendaViceChairman,
            agendaMember,
            expandedAgendaChairman,
            expandedAgendaViceChairman,
            expandedAgendaMember
        } = e.currentTarget.dataset;

        const chairmanInAgendas = JSON.parse(agendaChairman).map(agenda => parseInt(agenda.id));
        const viceChairmanInAgendas = JSON.parse(agendaViceChairman).map(agenda => parseInt(agenda.id));
        const agendaMemberInAgendas = JSON.parse(agendaMember).map(agenda => parseInt(agenda.agenda_id));

        const committeeAgendaItems = Array.from(document.querySelectorAll('.committee-agenda-item'));
        document.querySelectorAll('span.highlight').forEach(item => item.classList.remove('highlight'));

        const matchingAgendaItems = committeeAgendaItems.filter(item => {
            const leadCommitteeId = parseInt(item.querySelector('*[data-lead-committee]').dataset
                .leadCommittee);
            const expandedCommitteeId = parseInt(item.querySelector('*[data-expanded-committee]').dataset
                .expandedCommittee);
            return chairmanInAgendas.includes(leadCommitteeId) || viceChairmanInAgendas.includes(
                    leadCommitteeId) || agendaMemberInAgendas.includes(leadCommitteeId) ||
                expandedAgendaChairman.includes(expandedCommitteeId) || expandedAgendaViceChairman.includes(
                    expandedCommitteeId) || expandedAgendaMember.includes(expandedCommitteeId);
        });

        matchingAgendaItems.forEach(item => {
            const leadCommitteeId = parseInt(item.querySelector('*[data-lead-committee]').dataset
                .leadCommittee);
            const expandedCommitteeId = parseInt(item.querySelector('*[data-expanded-committee]').dataset
                .expandedCommittee);

            if (chairmanInAgendas.includes(leadCommitteeId) || viceChairmanInAgendas.includes(
                leadCommitteeId) || agendaMemberInAgendas.includes(leadCommitteeId)) {
                item.querySelector(`span[data-lead-committee="${leadCommitteeId}"]`).classList.add('highlight');
            }

            if (expandedAgendaChairman.includes(expandedCommitteeId) || expandedAgendaViceChairman.includes(
                expandedCommitteeId) || expandedAgendaMember.includes(expandedCommitteeId)) {
                item.querySelector(`span[data-expanded-committee="${expandedCommitteeId}"]`).classList.add(
                    'highlight');
            }
        });
    }

    memberItems.forEach((item) => {
        item.addEventListener('mouseenter', (e) => {
            highlightMatchingAgendaItems(e);
        });

        item.addEventListener('mouseleave', () => {
            document.querySelectorAll('span.highlight').forEach(item => item.classList.remove(
                'highlight'));
        });
    });

    let isSidebarOpen = true;

    let toggleSidebar = () => {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');
        const nav = document.querySelector('.nav');

        if (isSidebarOpen) {
            sidebar.style.width = '0px';
            content.style.marginLeft = '50px';
            nav.style.marginLeft = '30px';
        } else {
            sidebar.style.width = '200px';
            content.style.marginLeft = '201px';
            nav.style.marginLeft = '181px';
        }

        isSidebarOpen = !isSidebarOpen;

        localStorage.setItem('isSidebarOpen', isSidebarOpen.toString());
    };

    document.querySelector('#btnMenu').addEventListener('click', toggleSidebar);
</script>
</body>

</html>
