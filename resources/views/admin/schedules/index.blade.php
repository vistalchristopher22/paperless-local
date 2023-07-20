@php use App\Enums\ScheduleType; @endphp
@extends('layouts.app-2')
@section('tab-title', 'Schedules')
@prepend('page-css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.css'/>
@endprepend
@section('content')

    <div class="clearfix"></div>

    <div class="modal fade" tabindex="-1" id="modalVenue">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark">Create Venue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formVenue">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="venueName"
                                   placeholder="Enter the name of the venue">
                            <span class="text-danger error-field"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-md" id="btnSaveVenue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-send me-1" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                            </svg>
                            Submit Venue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of the venue modal --}}


    <div class="row">
        <div class="col-lg-2">

            <div class="card calendar-cta">
                <div class="card-header bg-light p-3">
                    <div class="card-title fw-medium">Sessions</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <img src="/assets-2/images/widgets/calendar.svg" alt="" class="" height="150">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h5 class="font-20 text-center">No Schedule Sessions</h5>
                            <hr>
                            <div id="calendar-events">
                                @forelse($upcomingSessions as $session)
                                    <div class='fc-event' data-id="{{ $session->id }}">{{ $session->title }}</div>
                                @empty
                                    <div class="d-grid">
                                        <a class="btn btn-dark fw-medium " href="{{ route('board-sessions.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                            Add New Session
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-light d-flex flex-row justify-content-between align-items-center">
                    <div class="card-title fw-medium">Schedules</div>
                    <div>
                        <button class="btn btn-dark fw-medium shadow-dark" data-bs-toggle="modal"
                                data-bs-target="#modalVenue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Add New Venue
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="p-2">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark fw-medium text-uppercase" id="addScheduleModalLabel">Add
                        Schedule</h5>
                    <a class="cursor-pointer btn-close" data-bs-dismiss="modal">
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label text-capitalize">Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label for="time" class="form-label text-capitalize">Time</label>
                        <input type="time" class="form-control" id="time">
                    </div>

                    <div class="form-group">
                        <label for="shortDescription" class="form-label text-capitalize">Short Description</label>
                        <textarea class="form-control" name="" id="shortDescription" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="venue" class="form-label text-capitalize">Venue</label>
                        <select name="venue" id="venue" class="form-control">
                            @foreach($venues as $venue)
                                <option value="{{ $venue->name }}">{{ $venue->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label text-capitalize">Type</label>
                        <select name="type" id="type" class="form-control text-capitalize" disabled>
                            @foreach(ScheduleType::values() as $schedule)
                                <option value="{{ $schedule }}">{{ $schedule }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input class="form-control" type="hidden" id="id" name="id">

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="withGuests" name="with_guests">
                            <label class="form-check-label" for="withGuests">With Invited Guests</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border">
                    <button type="button" class="btn btn-danger btn-md text-white shadow" id="btnDeleteSchedule">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                        </svg>

                        <span class="mx-2">
                            Delete
                        </span>
                    </button>
                    <button type="button" class="btn btn-dark btn-md align-middle shadow" id="btnSaveSchedule">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-save2-fill" viewBox="0 0 16 16">
                            <path
                                d="M8.5 1.5A1.5 1.5 0 0 1 10 0h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h6c-.314.418-.5.937-.5 1.5v6h-2a.5.5 0 0 0-.354.854l2.5 2.5a.5.5 0 0 0 .708 0l2.5-2.5A.5.5 0 0 0 10.5 7.5h-2v-6z"/>
                        </svg>
                        <span class="mx-2">
                            Save Changes
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        {{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>--}}
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function () {
                const SESSION_TYPE = "{{ ScheduleType::SESSION->value }}";
                const COMMITTEE_TYPE = "{{ ScheduleType::MEETING->value }}";

                let selectedDate = null;
                let selectedEvent = null;
                let droppedEventId = 0;
                let type = null;

                let selectedDates = [];

                $('#calendar-events .fc-event').each(function () {
                    // store data so the calendar knows to render an event upon drop
                    $(this).data('event', {
                        id: $(this).attr('data-id'),
                        title: $.trim($(this).text()), // use the element's text as the event title
                        stick: true // maintain when user navigates (see docs on the renderEvent method)
                    });

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 999,
                        revert: true,      // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });

                let calendar = $('#calendar').fullCalendar({
                    editable: true,
                    height: window.innerHeight - 250,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                    },
                    defaultView: 'month',
                    selectable: true,
                    droppable: true,
                    selectHelper: true,
                    eventAfterAllRender: function (view) {
                        let legend = `<div class="fc-legend">
                              <div class="fc-event">
                                    <div class="fc-bg" style="background:green"></div>
                               </div>
                              <span class="legend-label">Sessions</span>
                               <div class="fc-event">
                                    <div class="fc-bg" style="background:blue"></div>
                                </div>
                              <span class="legend-label">Committee</span>
                          </div>`;
                        $('.fc-header-toolbar').html(legend);
                    },
                    eventSources: [{
                        url: `/api/schedules`,
                        failure: function () {
                            alert(
                                'there was an error while fetching events try to reload the page.'
                            );
                        },
                    }],
                    drop: function (date) {
                        droppedEventId = $(this).attr('data-id');
                        $(this).remove();
                        selectedDate = $.fullCalendar.formatDate(date, "MM/DD/YYYY");
                        $('#type').val(SESSION_TYPE);
                        type = 'POST';
                        $('#addScheduleModalLabel').text('SESSION SCHEDULE');
                        $('#scheduleModal').modal('toggle');
                    },
                    eventClick: function (info) {
                        selectedDate = $.fullCalendar.formatDate(info.start, "MM/DD/YYYY");
                        selectedEvent = info;
                        $.ajax({
                            url: `/api/schedule/${info.id}`,
                            success: function (response) {
                                $('#withGuests').removeAttr('checked');
                                type = 'PUT';
                                $('#addScheduleModalLabel').text('EDIT SCHEDULE');
                                $('#name').val(response.name);
                                $('#time').val(response.time);
                                $('#shortDescription').val(response.description);
                                $('#venue').val(response.venue);
                                $('#type').val(response.type);
                                $('#id').val(response.id);
                                $("#withGuests").val(response.with_invited_guest === 1 ? "on" : "off");
                                if (response.with_invited_guest == 1) {
                                    $('#withGuests').attr('checked', true);
                                }
                                $('#scheduleModal').modal('toggle');
                            }
                        });
                    },
                    select: function (start, end, allDay) {
                        var allDates = [];
                        var currentDate = start.clone();
                        while (currentDate < end) {
                            allDates.push(currentDate.format('YYYY-MM-DD'));
                            currentDate.add(1, 'days');
                        }

                        if (allDates.length !== 1) {
                            window.location.href = `${route('committee-meeting-schedule.show', allDates.join('&'))}`
                            return false;
                        } else {
                            let date = $.fullCalendar.formatDate(start, "MM/DD/YYYY");
                            type = 'POST';
                            selectedDate = date;
                            $('#name').val('');
                            $('#time').val('');
                            $('#shortDescription').val('');
                            $('#venue').val('');
                            $('#withGuests').val('');
                            $('#type').val(COMMITTEE_TYPE);
                            $('#addScheduleModalLabel').text('ADD SCHEDULE');
                            $('#scheduleModal').modal('toggle');
                        }

                    },
                    eventDrop: function (event) {
                        let date = $.fullCalendar.formatDate(event.start, "MM/DD/YYYY");
                        $.ajax({
                            url: `/api/schedule-move/${event.id}`,
                            method: 'PUT',
                            data: {
                                moveDate: date,
                            },
                            success: function (response) {
                                if (response.success) {
                                    notyf.success('Schedule successfully moved!');
                                }
                            }
                        });
                    },
                    eventResize: function (info) {
                    },
                });

                $('#btnSaveSchedule').click(function () {
                    let schedule = {
                        id: $('#id').val(),
                        name: $('#name').val(),
                        time: $('#time').val(),
                        description: $('#shortDescription').val(),
                        venue: $('#venue').val(),
                        type: $('#type').val(),
                        guests: $('#withGuests').is(':checked') ? "on" : "off",
                        selected_date: selectedDate,
                    };

                    $.ajax({
                        url: '/api/schedule',
                        method: type,
                        data: schedule,
                        success: function (response) {
                            if (response.success) {
                                if (response.type === SESSION_TYPE) {
                                    $.ajax({
                                        url: '/api/board-session/add-schedule',
                                        method: 'PUT',
                                        data: {
                                            schedule_id: response.id,
                                            board_session_id: droppedEventId,
                                        },
                                        success: function (response) {
                                            notyf.success('Successfully set new committee meeting');
                                            $('#calendar').fullCalendar('removeEvents', droppedEventId);
                                            $('#calendar').fullCalendar('refetchEvents');
                                            $('#scheduleModal').modal('toggle');
                                        },
                                    });
                                } else {
                                    notyf.success('Successfully set new committee meeting');
                                    $('#calendar').fullCalendar('refetchEvents');
                                    $('#scheduleModal').modal('toggle');
                                }
                            }
                        }
                    });
                });

                $('#btnDeleteSchedule').click(function () {
                    alertify.confirm("Are you sure you want to delete this schedule?",
                        function () {
                            $.ajax({
                                url: `/api/schedule/${selectedEvent.id}`,
                                method: 'DELETE',
                                success: function (response) {
                                    if (response.success) {
                                        notyf.success('Committee Meeting deleted successfully');
                                        $('#calendar').fullCalendar('refetchEvents');
                                        $('#scheduleModal').modal('toggle');
                                    }
                                },
                            });
                        },
                        function () {
                        }).set({
                        title: 'Delete Record',
                        labels: {
                            ok: 'Yes',
                            cancel: 'No',
                        }
                    });

                });


                $('#btnSaveVenue').on('click', function () {

                    if (($("#venueName").val() === '')) {
                        $('#venueName').addClass('is-invalid');
                        return;
                    }

                    $.ajax({
                        url: route('venue.store'),
                        type: 'POST',
                        data: $('#formVenue').serialize(),
                        success: function (response) {
                            if (response.success) {
                                $('#modalVenue').modal('toggle');
                                notyf.success('Successfully added a venue!');
                                $('#venue').append(`<option value="${$("#venueName").val()}">${$('#venueName').val()}</option>`)
                                $("#venueName").val('');
                            }
                        },
                        error: function (response) {
                            const {errors} = response.responseJSON;
                            Object.keys(errors).forEach(field => {
                                const [$field] = $(`[name^='${field}']`).addClass('is-invalid').next('span.error-field');
                                const [message] = errors[field];
                                $($field).text(message);
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

delete
