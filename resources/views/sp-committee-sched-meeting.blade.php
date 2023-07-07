<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SP-Committee Sched Meeting</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css"/>

    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/theme.bundle.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"
    />
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        .kanban-board {
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
            border-radius: 5px;
            padding: 10px;
            margin-top: 30px;
            margin-bottom: 25px;
            cursor: pointer;
            font-size: 18px;
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
            color: white;
        }

        ol {
            list-style: none;
        }


        body {
            box-sizing: border-box;
            padding: 0px;
            margin: 0px;
        }

        .simplebar-content-wrapper {
            background: #07073d;
        }

        .simplebar-track {
            border-radius: 0px;
        }

        .simplebar-thumb {
            border-radius: 0px;
        }

        .simplebar-scrollbar {
            border-radius: 0px;
        }

        .simplebar-scrollbar:before,
        .simplebar-scrollbar:after {
            border-radius: 0px;
            background-color: #07073d;
            padding: 0px;
            margin: 0px;
        }

    </style>
</head>
<body>
{{--<nav class="navbar navbar-expand-lg bg-dark">--}}
{{--    <div class="container-fluid">--}}
{{--        <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--            <ul class="navbar-nav me-auto mb-2 mb-lg-0">--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link active text-light" aria-current="page" href="#">Home</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"--}}
{{--                       aria-expanded="false">--}}
{{--                        Sessions--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a class="dropdown-item text-dark" href="#">Action</a></li>--}}
{{--                        <li><a class="dropdown-item text-dark" href="#">Another action</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}


<div class="row">
    <div class="col-lg-2 pe-0 d-sm-none d-none d-lg-block d-md-block">
        <div data-simplebar style="height:100vh;" data-simplebar-auto-hide="false">
            <div class="list-group list-group-flush border-bottom scrollarea">
                <div class="input-group my-2 rounded-0">
                    <span class="input-group-text" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-search" viewBox="0 0 16 16">
                          <path
                              d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </span>
                    <input type="text" class="form-control border-0 rounded-0" placeholder="Search..." id="searchField">
                </div>

                <div class="list-group-item list-group-item-action py-3 lh-tight" id="noResults" style="display:none;">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="text-muted text-center">Sorry, we couldn't find any matches for your search.</span>
                    </div>
                </div>

                @foreach($members as $member)
                    <a href="#" class="list-group-item list-group-item-action list-group-members-item py-3 lh-tight"
                       aria-current="true"
                       data-search-content="{{ Str::of($member->fullname)->snake() }}">
                        <div class="d-flex align-items-center justify-content-start">
                            <img class="img-fluid rounded-circle"
                                 src="{{ asset('storage/user-images/' . $member->profile_picture) }}"
                                 width="50px">
                            <strong class="mb-1 mx-2">{{ $member->fullname }}</strong>
                        </div>
                        <div class="ms-2">
                            @foreach($member->agenda_chairman as $chairman)
                                <div class="col-10 mb-1 mt-1 small">Chairman of {{ $chairman->title }}</div>
                            @endforeach
                            @foreach($member->agenda_vice_chairman as $vice_chairman)
                                <div class="col-10 mb-1 mt-1 small">Vice Chairman of {{ $vice_chairman->title }}</div>
                            @endforeach
                            @foreach($member->agenda_member as $agendaMember)
                                <div class="col-10 mb-1 mt-1 small">Member of {{ $agendaMember->agenda->title }}</div>
                            @endforeach
                            @foreach($member->expanded_agenda_chairman as $expandedAgendaChairman)
                                <div class="col-10 mb-1 mt-1 small">Chairman of Expanded
                                    Committee {{ $expandedAgendaChairman->title }}</div>
                            @endforeach
                            @foreach($member->expanded_agenda_vice_chairman as $expandedAgendaViceChairman)
                                <div class="col-10 mb-1 mt-1 small">Vice Chairman of Expanded
                                    Committee {{ $expandedAgendaViceChairman->title }}</div>
                            @endforeach
                            @foreach($member->expanded_agenda_member as $expandedMember)
                                <div class="col-10 mb-1 mt-1 small">Member of Expanded
                                    Committee {{ $expandedMember->agenda->title }}</div>
                            @endforeach
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-10 p-0 col-sm-12">
        <div class="card rounded-0 border-0 min-vh-100 p-0">
            <div class="card-body">
                <div
                    class="header d-flex flex-row align-items-center justify-content-center border border-start-0 border-end-0 border-top-0 border-5 border-dark mb-3">
                    <img width="13%" src="{{ asset('session/logo.png') }}" alt="" class="me-auto">
                    <div class="d-flex flex-column align-items-center">
                        <h5 class="text-dark">Republic of the Philippines</h5>
                        <h5 class="fw-bold text-dark">PROVINCE OF SURIGAO DEL SUR</h5>
                        <h5 class="text-dark">Tandag City</h5>
                        <h3 class="fw-bold text-dark">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</h3>
                        <h5 class="text-dark">(Office of the Provincial Council)</h5>
                    </div>
                    <img width="14.5%" src="{{ asset('assets/tsp.png') }}" alt="" class="ms-auto">
                </div>
                <div class="text-center">
                    <h4 class="fw-medium" style="letter-spacing : 1.8px;">
                        SCHEDULE OF COMMITTEE MEETINGS
                        <h4 class="fw-bold text-uppercase text-decoration-underline">
                            {{ $schedules?->first()?->first()?->venue }}
                        </h4>
                    </h4>
                </div>

                @foreach ($schedules as $index => $grouppedSchedules)
                    <div id="{{ $index }}" class="schedule-container">
                        @foreach ($grouppedSchedules as $key => $schedule)
                            @if (
                                $key === 0 ||
                                    $schedule->date_and_time->format('Y-m-d') !== $grouppedSchedules[$key - 1]->date_and_time->format('Y-m-d'))
                                <h5 class="fw-medium text-center mt-5">
                                    <span class="text-uppercase">
                                        @if ($schedule->date_and_time->hour === 0)
                                            {{ $schedule->date_and_time->format('F d, Y') }}
                                        @else
                                            {{ $schedule->date_and_time->format('F d, Y @ h:i A') }}
                                        @endif
                                    </span>
                                    <p class="">{{ $schedule->description }}</p>
                                </h5>
                                @php $countIndex = 1; @endphp
                            @endif

                            @if ($schedule->with_invited_guest == 1)
                                <h5 class="fw-medium text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
                                    COMMITTEE WITH INVITED GUESTS
                                </h5>
                                <div class="kanban-column w-100">
                                    <ol class="kanban-cards" id="{{ $schedule->id }}">
                                        @foreach ($schedule->committees as $committee)
                                            <li class="kanban-card" data-id="{{ $committee->id }}">
                                                <a target="_blank"
                                                   href="{{ route('committee-file.show', $committee) }}">
                                                    <span class="text-dark">
                                                        <span class="count-index">{{ $countIndex }}. </span>
                                                        {{ $committee->lead_committee_information->title }} /
                                                        {{ $committee->expanded_committee_information->title }}
                                                    </span>
                                                </a>
                                                @php $countIndex++; @endphp
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @else
                                <h5 class="fw-medium text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
                                    COMMITTEE WITHOUT INVITED GUESTS
                                </h5>
                                <div class="kanban-column w-100">
                                    <ol class="kanban-cards" id="{{ $schedule->id }}">
                                        @foreach ($schedule->committees as $committee)
                                            <li class="kanban-card" data-id="{{ $committee->id }}">
                                                <a target="_blank"
                                                   href="{{ route('committee-file.show', $committee) }}">
                                                    <span class="text-dark">
                                                        <span class="count-index">{{ $countIndex }}. </span>
                                                        {{ $committee->lead_committee_information->title }} /
                                                        {{ $committee->expanded_committee_information->title }}
                                                    </span>
                                                </a>
                                                @php $countIndex++; @endphp
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script>
    const searchField = document.querySelector('#searchField');
    const listItems = document.querySelectorAll('.list-group-members-item');
    const noResults = document.querySelector('#noResults');

    searchField.addEventListener('input', () => {
        const searchTerm = searchField.value.trim().toLowerCase();
        let foundMatch = false;
        listItems.forEach((item) => {
            const searchContent = item.getAttribute('data-search-content');
            if (searchContent.indexOf(searchTerm) !== -1) {
                item.style.display = 'block';
                foundMatch = true;
            } else {
                item.style.display = 'none';
            }
        });
        if (foundMatch) {
            noResults.style.display = 'none';
        } else {
            noResults.style.display = 'block';
        }
    });
</script>
</body>
</html>
