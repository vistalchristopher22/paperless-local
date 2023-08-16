<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
        }

        .d-flex {
            display: flex !important;
            display: -webkit-box;
            display -webkit-flex;
            display: -ms-flexbox;
        }

        .flex-row {
            flex-direction: row !important;
        }

        .flex-column {
            flex-direction: column !important;
        }

        .flex-wrap {
            flex-wrap: wrap !important;
        }

        .justify-content-start {
            justify-content: flex-start !important;
        }

        .justify-content-end {
            justify-content: flex-end !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .justify-content-around {
            justify-content: space-around !important;
        }

        .align-items-start {
            align-items: flex-start !important;
        }

        .align-items-end {
            align-items: flex-end !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .align-items-baseline {
            align-items: baseline !important;
        }

        .align-items-stretch {
            align-items: stretch !important;
        }

        .align-content-start {
            align-content: flex-start !important;
        }

        .align-content-end {
            align-content: flex-end !important;
        }

        .align-content-center {
            align-content: center !important;
        }

        .align-content-between {
            align-content: space-between !important;
        }

        .align-content-around {
            align-content: space-around !important;
        }

        .align-content-stretch {
            align-content: stretch !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .flex-grow-1 {
            flex-grow: 1 !important;
        }

        .flex-shrink-0 {
            flex-shrink: !important;
        }

        .flex-shrink-1 {
            flex-shrink: 1 !important;
        }

        .flex-fill {
            flex: 1 1 auto !important;
        }

        .flex-nowrap {
            flex-wrap: nowrap !;
        }

        .order-0 {
            order: 0 !important;
        }

        .order-1 {
            order: 1 !important;
        }

        .order-2 {
            order: 2 !important;
        }

        .order-3 {
            order: 3 !important;
        }

        .order-4 {
            order: 4 !important;
        }

        .order-5 {
            order: 5 !important;
        }

        .order-last {
            order: 999 !important;
        }

        .ms-flexbox {
            display: -ms-flexbox !important;
        }


        body {
            font-family: Inter, sans-serif;
        }

        .header-text {
            font-size: 1.5vw;
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .mt-1 {
            margin-top: 0.25rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }


        .mt-0 {
            -top: 0 !important;
        }

        .mt-1 {
            margin-top: 0.25rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mb-1 {
            margin-bottom: 0.25rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .ml-0 {
            margin-left: 0 !important;
        }

        .ml-1 {
            margin-left: 0.25rem !important;
        }

        .ml-2 {
            margin-left: 0.5rem !important;
        }

        .ml-3 {
            margin-left: 1rem !important;
        }

        .ml-4 {
            margin-left: 1.5rem !important;
        }

        .ml-5 {
            margin-left: 3rem !important;
        }

        .mr-0 {
            margin-right: 0 !important;
        }

        .mr-1 {
            margin-right: 0.25rem !important;
        }

        .mr-2 {
            margin-right: 0.5rem !important;
        }

        .mr-3 {
            margin-right: 1rem !important;
        }

        .mr-4 {
            margin-right: 1.5rem !important;
        }

        .mr-5 {
            margin-right: 3rem !important;
        }

        .mx-0 {
            margin-right: 0 !important;
            margin-left: 0 !important;
        }

        .mx-1 {
            margin-right: 0.25rem !important;
            margin-left: 0.25rem !important;
        }

        .mx-2 {
            margin-right: 0.5rem !important;
            margin-left: 0.5rem !important;
        }

        .mx-3 {
            margin-right: 1rem !important;
            margin-left: 1rem !important;
        }

        .mx-4 {
            margin-right: 1.5rem !important;
            margin-left: 1.5rem !important;
        }

        .mx-5 {
            margin-right: 3rem !important;
            margin-left 3rem !important;
        }

        .my-0 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .my-1 {
            margin-top: 0.25rem !important;
            margin-bottom: 0.25rem !important;
        }

        .my-2 {
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .my-3 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .my-5 {
            margin-top: 3rem !important;
            margin-bottom 3rem !important;
        }

        .m-auto {
            margin: auto !important;
        }

        ol {
            list-style-type: none;
        }


        /* Generate classes for large screens */
        .col-lg-1 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 1);
        }

        .col-lg-2 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) *);
        }

        .col-lg-3 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 3);
        }

        .col-lg-4 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 4);
        }

        .col-lg-5 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 5);
        }

        .col-lg-6 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 6);
        }

        .col-lg-7 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 7);
        }

        .col-lg-8 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 8);
        }

        .col-lg-9 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 9);
        }

        .col-lg-10 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 10);
        }

        .col-lg-11 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: calc((100% / 12) * 11);
        }

        .col-lg-12 {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
        }

        /* Generate classes for medium screens */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .col-md-1 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 1);
            }

            .col-md-2 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 2);
            }

            .col-md-3 {
                flex-basis: 0;
                flex-grow: 1;
                -width: calc((100% / 12) * 3);
            }

            .col-md-4 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 4);
            }

            .col-md-5 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 5);
            }

            .col-md-6 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 6
            }

            .col-md-7 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 7);
            }

            .col-md-8 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 8
            }

            .col-md-9 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 9);
            }

            .col-md-10 {
                -basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 10);
            }

            .col-md-11 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc100% / 12) * 11);
            }

            .col-md-12 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: 100%;
            }
        }

        /* Generate classes for small screens */
        @media (max-width: 767.98px) {
            .col-sm-1 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 1);
            }

            .col-sm-2 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 2);
            }

            .col-sm-3 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 3
            }

            .col-sm-4 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 4);
            }

            .col-sm-5 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) 5);
            }

            .col-sm-6 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 6);
            }

            .col-sm-7 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 7);
            }

            .col-sm-8 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100%12) * 8);
            }

            .col-sm-9 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 9);
            }

            .col-sm-10 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) * 10);
            }

            .col-sm-11 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: calc((100% / 12) *);
            }

            .col-sm-12 {
                flex-basis: 0;
                flex-grow: 1;
                max-width: 100%;
            }
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-decoration-underline {
            position: relative;
        }

        .text-decoration-underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 2px;
            background-color: black;
        }
    </style>
</head>

<body>
<br>
<div>
    <div class="text-center">
        <p style="letter-spacing : 1.8px;" class="fw-bold">
            SCHEDULE OF COMMITTEE MEETINGS
            <br>
            <span class="text-uppercase text-decoration-underline">
                    {{ $schedules?->first()?->first()?->venue }}
                </span>
        </p>
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
                    <p class="text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
                            <span class="text-decoration-underline fw-bold">
                                COMMITTEE WITH INVITED GUESTS
                            </span>
                    </p>
                    <div class="">
                        <ol class="" id="{{ $schedule->id }}">
                            @foreach ($schedule->committees as $committee)
                                <li class="my-4" data-id="{{ $committee->id }}">
                                        <span class="text-white">
                                            <span class="count-index">{{ $countIndex }}. </span>
                                            Committee on
                                            <span class="fw-bold">
                                                {{ $committee->lead_committee_information->title }}
                                            </span>
                                            /
                                            <span class="fw-bold">
                                                {{ $committee->expanded_committee_information->title }} & {{ Str::remove('Committee on', $committee?->other_expanded_committee_information?->title) }}
                                            </span>
                                        </span>
                                    @php $countIndex++; @endphp
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @else
                    <p class="fw-medium text-uppercase text-center mt-3" style="letter-spacing : 1.8px;">
                            <span class="fw-bold text-decoration-underline">
                                COMMITTEE WITHOUT INVITED GUESTS
                            </span>
                    </p>
                    <div class="">
                        <ol class="" id="{{ $schedule->id }}">
                            @foreach ($schedule->committees as $committee)
                                <li class="my-4" data-id="{{ $committee->id }}">
                                        <span class="text-white">
                                            <span class="count-index">{{ $countIndex }}. </span>
                                            Committee on
                                            <span class="fw-bold ">
                                                {{ str_replace('Committee on', '', $committee->lead_committee_information->title) }}
                                            </span>
                                            /
                                            <span class="fw-bold ">
                                                {{ $committee->expanded_committee_information->title }} & {{ Str::remove('Committee on', $committee?->other_expanded_committee_information?->title) }}
                                            </span>
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
    <br>
    <br>
    <br>
    <div style="width: 47.5%; float:right;">
        <p class="text-uppercase">
            prepared by:
        </p>
        <div class="text-center">
            <p class="fw-bold text-uppercase">
                {{ $settings->where('name', 'prepared_by')->first()->value }}
            </p>
            <p class="text-center mx-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LLSE II</p>
        </div>
    </div>

    <div style="clear:both;"></div>

    <div style="width : 41%;">
        <p class="text-uppercase">
            noted by:
        </p>
        <br>
        <div class="text-center">
            <p class="text-uppercase fw-bold" style="letter-spacing : 1.09px; line-height : 0.3px">
            {{ $settings->where('name', 'noted_by')->first()->value }}
            <p class="">LLSO IV</p>
            </p>
        </div>
    </div>
    {{-- <div class="col-lg-11 offset-1">

        <br>

    </div> --}}


</div>
</body>

</html>
