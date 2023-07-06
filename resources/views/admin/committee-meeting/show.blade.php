@extends('layouts.app-2')
@section('tab-title', 'Modify Schedule')
@prepend('page-css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .kanban-card {
            /* background-color: #ffffff; */
            background-color: #07073d;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 25px;
            cursor: move;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .kanban-card h3 {
            margin-top: 0;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .kanban-card p {
            margin-bottom: 0;
            font-size: 0.9rem;
            color: white;
        }

        .kanban-card-placeholder {
            border: 1px dashed #07073d;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 100px;
            margin-bottom: 10px;
            letter-spacing: 1.1px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #999;
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
                    <button type="button" class="btn btn-dark dropdown-toggle" id="uploadGroupDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="align-justify"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="uploadGroupDropdown">
                        <a class="dropdown-item d-flex flex-row align-items-center" target="_blank"
                            href="{{ route('committee-meeting-schedule.preview', $dates) }}">
                            <h6 class="text-dark fw-medium">Preview</h6>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" target="_blank"
                            href="{{ route('committee-meeting-schedule.print', $dates) }}">
                            <h6 class="text-dark fw-medium">Print</h6>
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
                            <h5 class="fw-medium text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
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
                                    <div style="pointer-events: none;"
                                        class="shadow-lg kanban-card-placeholder text-uppercase d-flex flex-column justify-content-center align-items-center">
                                        <span class="text-muted fw-medium">
                                            Drop committees here
                                        </span>
                                    </div>
                                </ol>
                            </div>
                        @else
                            <h5 class="fw-medium text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
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
                                    <div style="pointer-events: none;"
                                        class="shadow-lg kanban-card-placeholder d-flex flex-column justify-content-center align-items-center text-uppercase fw-medium">
                                        <div class="text-muted fw-medium">
                                            Drop committees here
                                        </div>
                                    </div>
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
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
            $(".kanban-cards").sortable({
                connectWith: ".kanban-cards",
                placeholder: "kanban-card-placeholder",
                forcePlaceholderSize: true,
                start: function(event, ui) {
                    ui.item.addClass("dragging");
                    let labelIndex = ui.item.data('index');
                    $(`#parent-index-${labelIndex}`).hide();
                },
                stop: function(event, ui) {
                    ui.item.removeClass("dragging");
                    let cardId = ui.item.data("id");
                    let columnId = ui.item.parent().attr("id");
                    let items = {};
                    let labelIndex = ui.item.data('index');
                    $(`#parent-index-${labelIndex}`).hide();

                    $('.kanban-card').each(function(index, element) {
                        let currentElementParentId = $(element).parent().attr('id');
                        if (!items[currentElementParentId]) {
                            items[currentElementParentId] = [];
                        }
                        items[currentElementParentId].push($(element).attr('data-id'));
                    });

                    $(ui.item.closest('.schedule-container')).find('li.kanban-card').each(function(index, element) {
                        $(element).find('.count-index').text(`${index + 1}. `);
                    });

                    $.ajax({
                        url: route('committee-meeting-schedule.store'),
                        method: 'POST',
                        data: {
                            parent: columnId,
                            id: cardId,
                            order: items,
                        },
                        success: function(response) {
                            notyf.success('Committee moved successfully!');
                        }
                    });
                }
            }).disableSelection();
        </script>
    @endpush
@endsection
