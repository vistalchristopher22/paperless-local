@php use App\Enums\ScheduleType; @endphp
@extends('layouts.app-2')
@section('tab-title', 'Complete Listing of Agendas')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }
    </style>
@endprepend
@section('content')

    <div class="float-end">
        <button class="btn btn-dark shadow-dark mb-2" id="refreshClients">Refresh all the clients</button>
        <button class="btn btn-dark shadow-dark mb-2" id="nextGuest">Move next guest</button>
    </div>
    <div class="clearfix"></div>

    <div class="card">
        <div class="card-header bg-light">
            <div class="card-title">
                <span class="fw-medium h6 fw-bold">Display</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('announcements.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="announcement">Font-size <span class="fw-bold">(vw)</span></label>
                    <input type="text" class="form-control" name="screen_font_size"
                        placeholder="Enter font size this must be (VW) not pixels e.g 30"
                        value="{{ old('screen_font_size', $settingRepository->getValueByName('screen_font_size')) }}">
                </div>

                <div class="float-end">
                    <input type="submit" value="Update" class="btn btn-dark shadow-dark shadow-lg">
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <div class="card-title">
                <span class="fw-medium h6 fw-bold">Announcements</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('announcements.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="announcement">Speed <span class="fw-bold">(seconds)</span></label>
                    <input type="text" class="form-control" name="announcement_running_speed"
                        placeholder="Enter speed e.g 5"
                        value="{{ old('announcement_running_speed', $settingRepository->getValueByName('announcement_running_speed')) }}">
                </div>

                <div class="form-group">
                    <label for="announcement">Announcement</label>
                    <textarea name="announcement" class="form-control" cols="30" rows="10">{{ old('announcement', $settingRepository->getValueByName('display_announcement')) }}</textarea>
                </div>

                <div class="float-end">
                    <input type="submit" value="Update" class="btn btn-dark shadow-dark shadow-lg">
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-light p-3 justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 text-dark fw-medium">Complete Listing <span class="text-lowercase">of</span>
                <span class="fw-bold">Sessions</span> <span class="text-lowercase">and</span> <span
                    class="fw-bold">Committees</span>
                <span class="text-lowercase">to</span> <span class="text-lowercase">be</span> <span
                    class="text-lowercase">displayed</span>
            </h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover border" id="screen-display-table">
                    <thead>
                        <tr>
                            <th class="p-3 text-center bg-light border text-uppercase">Order</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Session</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Title</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Chairman</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Vice Chairman</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Status</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Duration</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Start Time</th>
                            <th class="p-3 text-center bg-light border text-uppercase">End Time</th>
                            <th class="p-3 text-center bg-light border text-uppercase">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $record)
                            <tr data-id="{{ $record->id }}">
                                <td
                                    class="p-3 text-center fw-bold {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                    {{ $record->index }}</td>
                                <td
                                    class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border-primary text-white' : '' }}">
                                    {{ $record?->reference_session?->number }}
                                    Regular Session
                                    - {{ $record?->reference_session?->year }}</td>
                                <td
                                    class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border-primary text-white' : '' }}">
                                    @if ($record?->type === ScheduleType::MEETING->value)
                                        {{ $record->screen_displayable?->lead_committee_information->title }}
                                        / {{ $record->screen_displayable?->expanded_committee_information?->title }}
                                        {{ $record->screen_displayable?->other_expanded_committee_information?->title }}
                                    @else
                                        ORDER OF BUSINESS
                                    @endif
                                </td>
                                <td
                                    class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                    @if ($record?->type === ScheduleType::MEETING->value)
                                        {{ $record->screen_displayable?->lead_committee_information?->chairman_information?->fullname }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td
                                    class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                    @if ($record?->type === ScheduleType::MEETING->value)
                                        {{ $record->screen_displayable?->lead_committee_information?->vice_chairman_information?->fullname }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td
                                    class="p-3 text-center fw-bold text-uppercase {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                    {{ Str::headline($record->status) }}</td>
                                <td
                                    class="p-3 text-center {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                    {{ $record->duration }}</td>
                                <td class="text-center">{{ $record?->start_time?->format('h:i A') }}</td>
                                <td class="text-center">{{ $record?->end_time?->format('h:i A') }}</td>
                                <td class="text-center">
                                    @if ($record?->type === ScheduleType::MEETING->value && $record?->screen_displayable?->committee_invited_guests)
                                        <a href="{{ route('committee.invited-guest', $record?->screen_displayable?->id) }}"
                                            class="btn btn-info" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                                <path
                                                    d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($record->status === \App\Enums\ScreenDisplayStatus::ON_GOING->value)
                                        <a class="btn btn-primary btn-play shadow-lg shadow-dark">
                                            <i class="mdi mdi-play" style="pointer-events:none;"></i>
                                        </a>
                                        <a class="btn btn-danger btn-stop shadow-lg shadow-dark">
                                            <i class="mdi mdi-stop" style="pointer-events:none;"></i>
                                        </a>
                                    @elseif($record->status === \App\Enums\ScreenDisplayStatus::DONE->value)
                                        <a class="btn btn-dark btn-repeat shadow-lg shadow-dark"
                                            data-id="{{ $record->id }}">
                                            <i class="mdi mdi-refresh" style="pointer-events:none;"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="//cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
        <script>
            $('.button-menu-mobile').trigger('click');

            let table = $('#screen-display-table').DataTable({
                ordering: false,
                pageLength: 100,
            });

            $(document).on('click', '.btn-play', function() {
                socket.emit("START_TIMER");
                $(this).html('<i class="mdi mdi-pause" style="pointer-events:none;"></i>');
            });

            $(document).on('click', '.btn-stop', function() {
                socket.emit("END_TIMER");
                setTimeout(() => location.reload(), 500);
            });

            $(document).on('click', '.btn-repeat', function() {
                let id = $(this).attr('data-id');
                $.ajax({
                    url: `/api/screen/repeat/${id}`,
                    method: 'PUT',
                    success: function(response) {
                        if (response.success) {
                            socket.emit('TRIGGER_REFRESH');
                            setTimeout(() => location.reload(), 500);
                        }
                    }
                });
            });
            $('#refreshClients').click(function(e) {
                e.preventDefault();
                socket.emit('TRIGGER_REFRESH');
            });

            $('#nextGuest').click(function(e) {
                e.preventDefault();
                socket.emit('TRIGGER_MOVE_TOP');
            });
        </script>
    @endpush
@endsection
