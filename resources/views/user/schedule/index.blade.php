@extends('layouts.app-2')
@section('tab-title', 'Schedules')
@prepend('page-css')
    <style>
        .user-kanban-column {
            /* background-color: #f2f3f6; */
            padding: 10px;
            padding-right: 32px;
            border-radius: 5px;
            margin-bottom: 20px;
            flex-basis: calc(33.33% -20px);
            /* max-width: calc(33.33% - 20px); */
        }

        .user-kanban-column h2 {
            margin-top: 0;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .user-kanban-card {
            /* background-color: #ffffff; */
            background-color: #07073d;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-kanban-card h3 {
            margin-top: 0;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .user-kanban-card p {
            margin-bottom: 0;
            font-size: 0.9rem;
            color: white;
        }


        ol {
            list-style-type: none;
            margin-left: 20px;
        }
    </style>
@endprepend
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="btn-group float-end" role="group">

                <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" id="uploadGroupDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="align-justify"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="uploadGroupDropdown">
                        <a class="dropdown-item d-flex flex-row align-items-center" target="_blank"
                            href="{{ route('display.published.meeting', $dates) }}">
                            <i class="mdi mdi-eye mdi-18px mx-2"></i>
                            View
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" target="_blank" href="{{ route('user.schedules.print', $dates) }}">
                            <i class="mdi mdi-printer mdi-18px mx-2"></i>
                            Print
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div
                class="header d-flex flex-row align-items-center justify-content-center border border-start-0 border-end-0 border-top-0 border-5 border-dark mb-3">
                <img width="10%" src="{{ asset('session/logo.png') }}" alt="" class="me-auto">
                <div class="d-flex flex-column align-items-center">
                    <h5 class="text-dark">Republic of the Philippines</h5>
                    <h5 class="fw-bold text-dark">PROVINCE OF SURIGAO DEL SUR</h5>
                    <h5 class="text-dark">Tandag City</h5>
                    <h3 class="fw-bold text-dark">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</h3>
                    <h5 class="text-dark">(Office of the Provincial Council)</h5>
                </div>
                <img width="11.5%" src="{{ asset('assets/tsp.png') }}" alt="" class="ms-auto">
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
                            <div class="user-kanban-column w-100">
                                <ol class="user-kanban-cards" id="{{ $schedule->id }}">
                                    @foreach ($schedule->committees as $committee)
                                        <li class="user-kanban-card shadow-lg" data-id="{{ $committee->id }}">
                                            <span class="text-white">
                                                <span class="count-index">{{ $countIndex }}. </span>
                                                {{ $committee->lead_committee_information->title }} /
                                                {{ $committee->expanded_committee_information->title }}
                                            </span>
                                            @php $countIndex++; @endphp
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @else
                            <h5 class="fw-medium text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
                                COMMITTEE WITHOUT INVITED GUESTS
                            </h5>
                            <div class="user-kanban-column w-100">
                                <ol class="user-kanban-cards" id="{{ $schedule->id }}">
                                    @foreach ($schedule->committees as $committee)
                                        <li class="user-kanban-card shadow-lg" data-id="{{ $committee->id }}">
                                            <span class="text-white">
                                                <span class="count-index">{{ $countIndex }}. </span>
                                                {{ $committee->lead_committee_information->title }} /
                                                {{ $committee->expanded_committee_information->title }}
                                            </span>
                                            @php $countIndex++; @endphp
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            <div class="row">
                <div class="col-lg-4 offset-7">
                    <h5 class="text-uppercase">
                        prepared by:
                    </h5>
                </div>

                <div class="col-lg-4 offset-8">
                    <h5 class="text-uppercase" style="letter-spacing : 1.09px">
                        {{ $settings->where('name', 'prepared_by')->first()->value }}
                        <p class="text-start mx-5 fw-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LLSE II</p>
                    </h5>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-11 offset-1">
                    <h5 class="text-uppercase">
                        noted by:
                    </h5>
                </div>

                <div class="col-lg-4 offset-2">
                    <h5 class="text-uppercase" style="letter-spacing : 1.09px">
                        {{ $settings->where('name', 'noted_by')->first()->value }}
                        <p class="text-start mx-5 fw-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LLSO IV</p>
                    </h5>
                </div>
            </div>


        </div>
    </div>
    @push('page-scripts')
    @endpush
@endsection
