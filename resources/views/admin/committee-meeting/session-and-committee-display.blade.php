@php @endphp
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
            flex-basis: calc(33.33% - 20px);
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

    <div class="modal fade" tabindex="-1" id="previewModal">
        <div class="modal-dialog modal-xl modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title card-title h6">Preview Document</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 m-0" style="overflow-y: hidden">
                    <iframe src="" width="100%" height="110%"
                            style="position:absolute; top :0%;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-light">
            <div class="card-title fw-medium">List <span class="text-lowercase">of</span> <span class="fw-bolder">Sessions</span>
                <span class="text-lowercase">and</span> <span class="fw-bolder">Committees</span>
            </div>
        </div>
        <div class="card-body">
            @foreach($groupByDateAndType as $date => $record)
                <div class="accordion" style="max-width: 2000px;">
                    <div class="accordion-item border-top-0">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panel-{{ $date }}" aria-expanded="false"
                                    aria-controls="panel-{{ $date }}">


                                <div class="card-title text-capitalize">
                                    @isset($record?->first()?->first()?->regular_session)
                                        <span
                                            class="text-primary fw-bolder">{{ $record?->first()?->first()?->regular_session?->number }}</span>
                                        Regular
                                        Session <span
                                            class="text-lowercase">of</span> {{ $record?->first()?->first()?->regular_session?->year }}
                                        <span class="text-lowercase">is scheduled for</span> <span
                                            class="fw-bolder text-primary">{{ date('F d, Y', strtotime($date)) }}</span>
                                    @endisset
                                </div>
                            </button>
                        </h2>
                        <div id="panel-{{ $date }}" class="accordion-collapse collapse"
                             aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                @foreach($record as $typeAndVenue => $data)
                                    @if(Str::contains($typeAndVenue, 'session'))
                                        @php
                                            $id = Str::uuid();
                                        @endphp
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item border-top-0">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button bg-light p-3"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#session-{{ $id }}"
                                                            aria-expanded="false"
                                                            aria-controls="session-{{ $id }}">
                                                        <div
                                                            class="card-title d-flex flex-row align-items-center justify-content-between">
                                                    <span
                                                        class="me-1 text-dark text-capitalize fw-medium">{{ Str::replace('|', 'in', $typeAndVenue ) }}</span>
                                                            <span class="mx-2 badge bg-dark">{{ count($data) }}</span>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="session-{{ $id }}" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        @foreach($data as $key => $session)
                                                            <div class="card">
                                                                <div class="card-header bg-light p-3">
                                                                    <div class="card-title">
                                                                        {{ $session->name }}
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header mt-0 d-flex flex-row rounded-0">
                                                                            <button class="accordion-button collapsed"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#order-business-{{ $key . $id }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="order-business-{{ $key . $id }}">
                                                                                Order Business</span>
                                                                            </button>
                                                                            <button
                                                                                class="btn-sm btn btn-dark fw-medium btn-preview-document rounded-0 px-3 fw-medium d-flex align-items-center"
                                                                                data-url="{{ $session->board_sessions[0]->file_path_view }}"
                                                                            >
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                     width="16"
                                                                                     height="16" fill="currentColor"
                                                                                     class="bi bi-file-text me-2"
                                                                                     viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                                                                    <path
                                                                                        d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                                                                                </svg>
                                                                                Document
                                                                            </button>
                                                                        </h2>
                                                                        <div id="order-business-{{ $key . $id }}"
                                                                             class="accordion-collapse collapse"
                                                                             aria-labelledby="headingOne"
                                                                             data-bs-parent="#session-{{ $id }}"
                                                                             style="">
                                                                            <div class="accordion-body">
                                                                                @isset($session->board_sessions[0]->order_business_note)
                                                                                    {!! $session->board_sessions[0]->order_business_note !!}
                                                                                @endisset
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header mt-0 d-flex flex-row rounded-0">
                                                                            <button class="accordion-button collapsed"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#unassigned-business-{{ $key . $id }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="unassigned-business-{{ $key . $id }}">
                                                                                Unassigned Business</span>
                                                                            </button>

                                                                        </h2>
                                                                        <div id="unassigned-business-{{ $key . $id }}"
                                                                             class="accordion-collapse collapse"
                                                                             aria-labelledby="headingOne"
                                                                             data-bs-parent="#session-{{ $id }}"
                                                                             style="">
                                                                            <div class="accordion-body">
                                                                                @isset($session->board_sessions[0]->unassigned_content)
                                                                                    {!! $session->board_sessions[0]->unassigned_content !!}
                                                                                @else
                                                                                    Content Not Available
                                                                                @endisset
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header mt-0 d-flex flex-row rounded-0">
                                                                            <button class="accordion-button collapsed"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#announcement-{{ $key . $id }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="announcement-{{ $key . $id }}">
                                                                                Announcements</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="announcement-{{ $key . $id }}"
                                                                             class="accordion-collapse collapse"
                                                                             aria-labelledby="headingOne"
                                                                             data-bs-parent="#session-{{ $id }}"
                                                                             style="">
                                                                            <div class="accordion-body">
                                                                                @isset($session->board_sessions[0]->announcement_content)
                                                                                    {!! $session->board_sessions[0]->announcement_content !!}
                                                                                @else
                                                                                    Note Not Available
                                                                                @endisset
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                                @foreach($record as $typeAndVenue => $data)
                                    @if(Str::contains($typeAndVenue, 'committee'))
                                        @php
                                            $id = Str::uuid();
                                        @endphp
                                        <div class="accordion" id="committee-{{ $id }}">
                                            <div class="accordion-item border-top-0">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button bg-light" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#committee-{{ $id  . $loop->index }}"
                                                            aria-expanded="false"
                                                            aria-controls="committee-{{ $id  . $loop->index }}">
                                                        <div
                                                            class="card-title d-flex flex-row align-items-center justify-content-between">
                                                    <span
                                                        class="me-1 text-dark text-capitalize fw-medium">{{ Str::replace('|', 'in', $typeAndVenue ) }}</span>
                                                            <span class="mx-2 badge bg-dark">{{ count($data) }}</span>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="committee-{{ $id  . $loop->index }}"
                                                     class="accordion-collapse collapse"
                                                     aria-labelledby="headingOne"
                                                     data-bs-parent="#committee-{{ $id }}">
                                                    <div class="accordion-body">

                                                        <div class="card">
                                                            <div class="card-header m-0 py-0 px-0 bg-light">
                                                                <button
                                                                    class="nav-item dropdown btn btn-dark rounded-0 float-end"
                                                                    role="presentation">
                                                                    <a class="nav-link dropdown-toggle text-white"
                                                                       data-bs-toggle="dropdown" href="#" role="button"
                                                                       aria-expanded="false">
                                                                        Actions
                                                                        <i class="mdi mdi-chevron-down"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" target="_blank"
                                                                           href="{{ route('committee-meeting-schedule.preview', $date) }}">Preview</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" target="_blank"
                                                                           href="{{ route('committee-meeting-schedule.print', $date) }}">Print</a>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="card-body">

                                                                <div
                                                                    class="header d-flex flex-row align-items-center justify-content-center border border-start-0 border-end-0 border-top-0 border-5 border-dark mb-3">
                                                                    <img width="10%"
                                                                         src="{{ asset('session/logo.png') }}"
                                                                         alt=""
                                                                         class="me-auto">
                                                                    <div class="d-flex flex-column align-items-center">
                                                                        <h4 class="text-dark">Republic of the
                                                                            Philippines</h4>
                                                                        <h4 class="fw-bold text-dark">PROVINCE OF
                                                                            SURIGAO DEL
                                                                            SUR</h4>
                                                                        <h4 class="text-dark">Tandag City</h4>
                                                                        <h3 class="fw-bold text-dark">TANGGAPAN NG
                                                                            SANGGUNIANG
                                                                            PANLALAWIGAN</h3>
                                                                        <h5 class="text-dark">(Office of the Provincial
                                                                            Council)</h5>
                                                                    </div>
                                                                    <img width="11.5%"
                                                                         src="{{ asset('assets/tsp.png') }}"
                                                                         alt=""
                                                                         class="ms-auto">
                                                                </div>

                                                                <div class="text-center">
                                                                    <h4 class="fw-medium"
                                                                        style="letter-spacing : 1.8px;">
                                                                        SCHEDULE OF COMMITTEE MEETINGS
                                                                        <h4 class="fw-bold text-uppercase text-decoration-underline">
                                                                            {{ Str::replace('committee | ', '', $typeAndVenue ) }}
                                                                        </h4>
                                                                    </h4>
                                                                </div>

                                                                @php $countIndex = 1; @endphp

                                                                @foreach($data as $schedule)
                                                                    <h5 class="fw-medium text-center mt-5">
                                                                        @if($loop->index == 0)
                                                                            <span class="text-uppercase">
                                                                @if ($schedule->date_and_time->hour === 0)
                                                                                    {{ $schedule->date_and_time->format('F d, Y') }}
                                                                                @else
                                                                                    {{ $schedule->date_and_time->format('F d, Y @ h:i A') }}
                                                                                @endif
                                                        </span>
                                                                        @endif
                                                                        <p class="my-2">{{ $schedule->description }}</p>
                                                                    </h5>


                                                                    @if ($schedule->with_invited_guest == 1)
                                                                        <h5 class="fw-medium text-uppercase text-center mt-3"
                                                                            style="letter-spacing : 1.8px;">
                                                                            COMMITTEE WITH INVITED GUESTS
                                                                        </h5>
                                                                        <div class="kanban-column w-100">
                                                                            <ol class="kanban-cards"
                                                                                id="{{ $schedule->id }}">
                                                                                @foreach ($schedule->committees as $committee)
                                                                                    <li class="kanban-card shadow-lg"
                                                                                        data-id="{{ $committee->id }}">
                                            <span class="text-white">
                                                <span class="count-index">{{ $countIndex }}. </span>
                                                {{ $committee->lead_committee_information->title }} /
                                                {{ $committee->expanded_committee_information->title }} & {{ Str::remove('Committee on', $committee?->other_expanded_committee_information?->title) }}
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
                                                                        <h5 class="fw-medium text-uppercase text-center mt-3"
                                                                            style="letter-spacing : 1.8px;">
                                                                            COMMITTEE WITHOUT INVITED GUESTS
                                                                        </h5>
                                                                        <div class="kanban-column w-100">
                                                                            <ol class="kanban-cards"
                                                                                id="{{ $schedule->id }}">
                                                                                @foreach ($schedule->committees as $committee)
                                                                                    <li class="kanban-card shadow-lg"
                                                                                        data-id="{{ $committee->id }}">
                                            <span class="text-white">
                                                <span class="count-index">{{ $countIndex }}. </span>
                                                {{ $committee->lead_committee_information->title }} /
                                                  {{ $committee->expanded_committee_information->title }} & {{ Str::remove('Committee on', $committee?->other_expanded_committee_information?->title) }}
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
                                                                <div class="row">
                                                                    <div class="col-lg-4 offset-7">
                                                                        <h5 class="text-uppercase">
                                                                            prepared by:
                                                                        </h5>
                                                                    </div>

                                                                    <div class="col-lg-4 offset-8">
                                                                        <h5 class="text-uppercase"
                                                                            style="letter-spacing : 1.09px">
                                                                            {{ $settings->where('name', 'prepared_by')->first()->value }}
                                                                            <p class="text-start mx-5 fw-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LLSE
                                                                                II</p>
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
                                                                        <h5 class="text-uppercase"
                                                                            style="letter-spacing : 1.09px">
                                                                            {{ $settings->where('name', 'noted_by')->first()->value }}
                                                                            <p class="text-start mx-5 fw-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LLSO
                                                                                IV</p>
                                                                        </h5>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @push('page-scripts')
        <script>
            $(document).ready(function () {
                $(document).on('click', '.btn-preview-document', function () {
                    let url = $(this).attr('data-url');
                    $('#previewModal').find('iframe').attr('src', `${url}#zoom=190&toolbar=0`);
                    $('#previewModal').modal('show');
                })
            });
        </script>
    @endpush

    @push('page-scripts')
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
            $(".kanban-cards").sortable({
                connectWith: ".kanban-cards",
                placeholder: "kanban-card-placeholder",
                forcePlaceholderSize: true,
                start: function (event, ui) {
                    ui.item.addClass("dragging");
                    let labelIndex = ui.item.data('index');
                    $(`#parent-index-${labelIndex}`).hide();
                },
                stop: function (event, ui) {
                    ui.item.removeClass("dragging");
                    let cardId = ui.item.data("id");
                    let columnId = ui.item.parent().attr("id");
                    let items = {};
                    let labelIndex = ui.item.data('index');
                    $(`#parent-index-${labelIndex}`).hide();

                    $('.kanban-card').each(function (index, element) {
                        let currentElementParentId = $(element).parent().attr('id');
                        if (!items[currentElementParentId]) {
                            items[currentElementParentId] = [];
                        }
                        items[currentElementParentId].push($(element).attr('data-id'));
                    });

                    $(ui.item.closest('.schedule-container')).find('li.kanban-card').each(function (index, element) {
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
                        success: function (response) {
                            notyf.success('Committee moved successfully!');
                        }
                    });
                }
            }).disableSelection();
        </script>

        <script>
        </script>
    @endpush
@endsection
