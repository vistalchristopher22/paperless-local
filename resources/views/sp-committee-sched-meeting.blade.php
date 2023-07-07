<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SP-Committee Sched Meeting</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/theme.bundle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
            flex-basis: calc(33.33% -20px);
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
    </style>
</head>
<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
          {{-- <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button> --}}
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active text-light" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Sessions
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item text-dark" href="#">Action</a></li>
                  <li><a class="dropdown-item text-dark" href="#">Another action</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled text-light">Disabled</a>
              </li>
            </ul>

          </div>
        </div>
      </nav>


      <div class="p-5">
        <div class="card">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
