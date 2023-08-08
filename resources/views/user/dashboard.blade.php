@extends('layouts.app-2')
@section('page-title', 'Dashboard')
@prepend('page-css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.css'/>
@endprepend
@section('content')
    <div class="card">
        <div class="card-header bg-dark">
            <h6 class="card-title text-white h6">
                Schedules
            </h6>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white h6 text-uppercase" id="addScheduleModalLabel">View Schedule</h5>
                    <a class="text-white cursor-pointer" dataf-bs-dismiss="modal">
                        <i class="fas fa-times fa-2x"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label text-capitalize">Name</label>
                        <input type="text" class="form-control" id="name" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-capitalize">Time</label>
                        <input type="time" class="form-control" id="time" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-capitalize">Short Description</label>
                        <textarea class="form-control" name="" id="shortDescription" rows="2" readonly></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-capitalize">Venue</label>
                        <select name="venue" id="venue" class="form-control" readonly>
                            <option value="Session Hall">Session Hall</option>
                            <option value="Second District">Second District</option>
                        </select>
                    </div>

                    <input class="form-control" type="hidden" id="id" name="id">

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="withGuests" name="with_guests" readonly>
                            <label class="form-check-label" for="withGuests">With Invited Guests</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script>
            let selectedDate = null;
            let selectedEvent = null;
            let type = null;

            let selectedDates = [];

            let calendar = $('#calendar').fullCalendar({
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
                            type = 'PUT';
                            $('#addScheduleModalLabel').text('VIEW SCHEDULE');
                            $('#name').val(response.name);
                            $('#time').val(response.time);
                            $('#shortDescription').val(response.description);
                            $('#venue').val(response.venue);
                            $('#id').val(response.id);
                            if (response.with_invited_guest == 1) {
                                $('#withGuests').attr('checked', true);
                                $('#withGuests').val(response.with_invited_guest);
                            } else {
                                $('#withGuests').removeAttr('checked');
                                $('#withGuests').val(0);
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
                        window.location.href = `/user/schedules/${allDates.join('&')}`;
                        return false;
                    }
                },
            });
        </script>
    @endpush
@endsection
