@extends('layouts.app-2')
@section('tab-title', 'Schedules')
@prepend('page-css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.css'/>
@endprepend
@section('content')

    <button class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#modalVenue">Add Venue</button>
    <div class="clearfix"></div>

    <div class="modal fade" tabindex="-1" id="modalVenue">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Venue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formVenue">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="venueName"
                                   placeholder="Enter the name of the venue..">
                            <span class="text-danger error-field"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-md" id="btnSaveVenue">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of the venue modal --}}

    <div class="card">
        <div class="card-header bg-dark">
            <div class="card-title text-white h6">
                Schedules
            </div>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white h6 text-uppercase" id="addScheduleModalLabel">Add Schedule</h5>
                    <a class="cursor-pointer btn-close" data-bs-dismiss="modal">
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label text-capitalize">Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label class="form-label text-capitalize">Time</label>
                        <input type="time" class="form-control" id="time">
                    </div>

                    <div class="form-group">
                        <label class="form-label text-capitalize">Short Description</label>
                        <textarea class="form-control" name="" id="shortDescription" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-capitalize">Venue</label>
                        <select name="venue" id="venue" class="form-control">
                            @foreach($venues as $venue)
                                <option value="{{ $venue->name }}">{{ $venue->name }}</option>
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
                    <button type="button" class="btn btn-danger text-white shadow" id="btnDeleteSchedule">
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
                    <button type="button" class="btn btn-dark align-middle shadow" id="btnSaveSchedule">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script>
            $(document).ready(function () {
                let selectedDate = null;
                let selectedEvent = null;
                let type = null;

                let selectedDates = [];

                let calendar = $('#calendar').fullCalendar({
                    editable: true,
                    height: 'auto',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultView: 'month',
                    selectable: true,
                    selectHelper: true,
                    eventSources: [{
                        url: `/api/schedules`,
                        failure: function () {
                            alert(
                                'there was an error while fetching events try to reload the page.'
                            );
                        },
                    }],
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
                                $('#id').val(response.id);
                                $('#withGuests').val(response.with_invited_guest === 1 ? "on" : "off");
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
                        guests: $('#withGuests').is(':checked') ? "on" : "off",
                        selected_date: selectedDate,
                    };

                    $.ajax({
                        url: '/api/schedule',
                        method: type,
                        data: schedule,
                        success: function (response) {
                            if (response.success) {
                                notyf.success('Successfully set new committee meeting');
                                $('#calendar').fullCalendar('refetchEvents');
                                $('#scheduleModal').modal('toggle');
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
