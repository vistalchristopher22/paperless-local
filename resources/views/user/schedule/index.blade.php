@extends('layouts.app-2')
@section('tab-title', 'Modify Schedule')
@prepend('page-css')
@endprepend
@section('content')
    <div class="card">
        <div class="card-header m-0 py-0 px-1">
            <ul class="nav nav-tabs d-flex align-items-center m-0 border-0" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active h5" id="committee-tab" data-bs-toggle="tab"
                            data-bs-target="#committee"
                            type="button" role="tab" aria-controls="committee" aria-selected="true">Commmittee
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link h5" id="session-tab" data-bs-toggle="tab" data-bs-target="#session"
                            type="button" role="tab" aria-controls="session" aria-selected="false">Session
                    </button>
                </li>

                <li class="nav-item dropdown" role="presentation">
                    <a class="nav-link dropdown-toggle h5" data-bs-toggle="dropdown" href="#" role="button"
                       aria-expanded="false">
                        Actions
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" target="_blank" href="{{ route('committee-meeting-schedule.preview', $dates) }}">Preview</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" target="_blank"
                           href="{{ route('committee-meeting-schedule.print', $dates) }}">Print</a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="tab-panes">
            <div class="tab-pane fade show active" id="committee" role="tabpanel" aria-labelledby="committee-tab">
                <div class="card-body">
                    <div
                        class="header d-flex flex-row align-items-center justify-content-center border border-start-0 border-end-0 border-top-0 border-5 border-dark mb-3">
                        <img width="10%" src="{{ asset('session/logo.png') }}" alt="" class="me-auto">
                        <div class="d-flex flex-column align-items-center">
                            <h4 class="text-dark">Republic of the Philippines</h4>
                            <h4 class="fw-bold text-dark">PROVINCE OF SURIGAO DEL SUR</h4>
                            <h4 class="text-dark">Tandag City</h4>
                            <h3 class="fw-bold text-dark">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</h3>
                            <h5 class="text-dark">(Office of the Provincial Council)</h5>
                        </div>
                        <img width="11.5%" src="{{ asset('assets/tsp.png') }}" alt="" class="ms-auto">
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
                                    <h5 class="fw-medium text-uppercase text-center mt-3"
                                        style="letter-spacing : 1.8px;">
                                        COMMITTEE WITH INVITED GUESTS
                                    </h5>
                                    <div class="kanban-column w-100">
                                        <ol class="kanban-cards" id="{{ $schedule->id }}">
                                            @foreach ($schedule->committees as $committee)
                                                <li class="kanban-card shadow-lg" data-id="{{ $committee->id }}">
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
                                    <h5 class="fw-medium text-uppercase text-center mt-3"
                                        style="letter-spacing : 1.8px;">
                                        COMMITTEE WITHOUT INVITED GUESTS
                                    </h5>
                                    <div class="kanban-column w-100">
                                        <ol class="kanban-cards" id="{{ $schedule->id }}">
                                            @foreach ($schedule->committees as $committee)
                                                <li class="kanban-card shadow-lg" data-id="{{ $committee->id }}">
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
            <div class="tab-pane fade" role="tabpanel" aria-labelledby="session-tab" id="session">
                <div class="card-body">
                    <ul class="nav nav-pills nav-justified d-flex align-items-center" role="tablist">
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <button class="nav-link active h5" id="order-business-tab" data-bs-toggle="tab"
                                    data-bs-target="#order-business"
                                    type="button" role="tab" aria-controls="committee" aria-selected="true">Order
                                Business
                            </button>
                        </li>
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <button class="nav-link h5" id="unassigned-business-tab" data-bs-toggle="tab"
                                    data-bs-target="#unassigned-business"
                                    type="button" role="tab" aria-controls="session" aria-selected="false">Unassigned
                                Bussiness
                            </button>
                        </li>

                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <button class="nav-link h5" id="announcement-tab" data-bs-toggle="tab" data-bs-target="#announcements"
                                    type="button" role="tab" aria-controls="session" aria-selected="false">Announcements
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="session-tab-panes">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="order-business"
                             id="order-business">
                            <div class="d-flex align-items-center justify-content-center">
                                <embed src="{{ $boardSessionPathForView }}#zoom=196&toolbar=0&pagemode=thumbs" style="min-height : 100vh; min-width : 85vw;"></embed>
                            </div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="unassigned-business-tab"
                             id="unassigned-business">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                {{ $boardSession->unassigned_title }}
                                {!! $boardSession->unassigned_business !!}
                            </div>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="unassigned-business-tab"
                             id="announcements">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                {{ $boardSession->announcement_title }}
                                {!! $boardSession->announcement_content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('page-scripts')
    @endpush
@endsection
