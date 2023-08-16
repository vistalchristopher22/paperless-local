@extends('layouts.app-2')
@section('tab-title', 'Settings')
@section('content')

    @if(session()->has('success'))
        <div class="card bg-success mb-3">
            <div class="card-body text-white">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-light py-3">
            <h6 class="fw-bold card-title h6 text-dark">Application Settings</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')
                <h5 class="card-title text-dark">Committee & Session</h5>
                <div class="card-text">
                    <div class="form-group row">
                        <label for="prepared_by" class="col-md-2 col-form-label text-md-right">Prepared By</label>
                        <div class="col-md-10">
                            <input type="text" name="prepared_by" id="prepared_by" class="form-control"
                                   placeholder="Enter Fullname"
                                   value="{{ $settingRepository->getValueByName('prepared_by') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="noted_by" class="col-md-2 col-form-label text-md-right">Noted By</label>
                        <div class="col-md-10">
                            <input type="text" name="noted_by" id="noted_by" class="form-control"
                                   value="{{ $settingRepository->getValueByName('noted_by') }}"
                                   placeholder="Enter Fullname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="current_session" class="col-md-2 col-form-label text-md-right">Current Regular
                            Session</label>
                        <div class="col-md-10">
                            <input type="number" name="current_session" id="current_session" class="form-control"
                                   value="{{ $settingRepository->getValueByName('current_session') }}"
                                   placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="current_session" class="col-md-2 col-form-label text-md-right">Max Current Regular
                            Session</label>
                        <div class="col-md-10">
                            <input type="number" name="current_session_increment" id="current_session_increment"
                                   class="form-control"
                                   value="{{ $settingRepository->getValueByName('current_session_increment') }}"
                                   placeholder="">
                        </div>
                    </div>

                </div>

                <hr class="border-dashed">

                <h5 class="card-title text-dark">Third-Parties</h5>
                <div class="form-group row">
                    <label for="libre_office_path" class="col-md-2 col-form-label text-md-right">Libreoffice
                        Path</label>
                    <div class="col-md-10">
                        <input type="text" name="libre_office_path" id="libre_office_path" class="form-control"
                               placeholder="C:\ProgramFiles\LibreOffice\"
                               value="{{ $settingRepository->getValueByName('libre_office_path') }}">
                    </div>
                </div>

                <hr class="border-dashed">

                <h5 class="card-title text-dark">File Reading</h5>
                {{-- <div class="form-group row mt-2">
                    <label for="first_reading" class="col-md-2 col-form-label text-md-right">First Reading Character
                        (Begin &
                        End)</label>
                    <div class="col-md-10">
                        <input type="text" name="first_reading" id="first_reading" class="form-control"
                               placeholder=""
                               value="{{ $settingRepository->getValueByName('first_reading') }}">
                    </div>
                </div> --}}

                {{-- <div class="form-group row mt-2">
                    <label for="second_reading" class="col-md-2 col-form-label text-md-right">Second Reading Character
                        (Begin &
                        End)</label>
                    <div class="col-md-10">
                        <input type="text" name="second_reading" id="second_reading" class="form-control"
                               placeholder=""
                               value="{{ $settingRepository->getValueByName('second_reading') }}">
                    </div>
                </div> --}}

                {{-- <div class="form-group row mt-2">
                    <label for="third_reading" class="col-md-2 col-form-label text-md-right">Third Reading Character
                        (Begin &
                        End)</label>
                    <div class="col-md-10">
                        <input type="text" name="third_reading" id="third_reading" class="form-control"
                               placeholder=""
                               value="{{ $settingRepository->getValueByName('third_reading') }}">
                    </div>
                </div> --}}

                <div class="form-group row mt-2">
                    <label for="unassigned_business" class="col-md-2 col-form-label text-md-right">Unassigned
                        Business</label>
                    <div class="col-md-10">
                        <input type="text" name="unassigned_business" id="unassigned_business" class="form-control"
                               placeholder=""
                               value="{{ $settingRepository->getValueByName('unassigned_business') }}">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="announcement" class="col-md-2 col-form-label text-md-right">Announcement (Begin &
                        End)</label>
                    <div class="col-md-10">
                        <input type="text" name="announcement" id="announcement" class="form-control"
                               placeholder=""
                               value="{{ $settingRepository->getValueByName('announcement') }}">
                    </div>
                </div>

                <hr class="border-dashed">

                <h5 class="card-title text-dark">Actions</h5>
                <div class="form-group row mt-2">
                    <label for="announcement" class="col-md-2 col-form-label text-md-right">Refresh Clients</label>
                    <div class="col-md-10">
                        <button class="btn btn-primary" id="refreshClients">Refresh Clients</button>
                        <p class="text-muted">
                            This feature allows you to instantly update all connected clients with the
                            latest data available on the server.
                        </p>
                    </div>
                </div>


                {{--                <h5 class="card-title text-dark">Notifications</h5>--}}
                {{--                <div class="form-group row mt-2">--}}
                {{--                    <div class="col-sm-10 ms-auto">--}}
                {{--                        <div class="form-check">--}}
                {{--                            <input type="checkbox"--}}
                {{--                                   {{ $settingRepository->getValueByName('smsAlerts') === 'on' ? 'checked' : '' }} name="smsAlerts"--}}
                {{--                                   class="form-check-input" id="smsAlerts">--}}
                {{--                            <label class="form-check-label" for="smsAlerts">SMS Alert</label>--}}
                {{--                        </div>--}}
                {{--                        <p class="text-muted">SMS Alerts is a feature that allows a system to send SMS notifications to--}}
                {{--                            its users. With this feature, each user will receive alerts via SMS whenever there is an--}}
                {{--                            update or important information related to their account or the system they are using. This--}}
                {{--                            feature ensures that users stay informed in real-time, regardless of their location or--}}
                {{--                            internet connectivity.</p>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="form-group row mt-2">--}}
                {{--                    <div class="col-sm-10 ms-auto">--}}
                {{--                        <div class="form-check">--}}
                {{--                            <input type="checkbox"--}}
                {{--                                   {{ $settingRepository->getValueByName('scheduleAlert') === 'on' ? 'checked' : '' }} name="scheduleAlert"--}}
                {{--                                   class="form-check-input" id="scheduleAlert">--}}
                {{--                            <label class="form-check-label" for="scheduleAlert">Schedule Alert</label>--}}
                {{--                        </div>--}}
                {{--                        <p class="text-muted">A Schedule Alert (SMS) is a feature that sends SMS notifications to users--}}
                {{--                            at a specific time or schedule. This feature is useful for reminding users of upcoming--}}
                {{--                            sessions. With Schedule Alert (SMS), users can receive notifications directly to their--}}
                {{--                            mobile devices, ensuring that they are always aware of important events.</p>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <hr class="border-dashed">
                <div class="form-group
                            row mb-0">
                    <div class="col-md-10 text-end offset-md-2">
                        <button type="submit" class="btn btn-primary btn-dark shadow-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-send mx-1" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                            </svg>
                            Save Setting
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script>
            $('#refreshClients').click(function (e) {
                e.preventDefault();
                socket.emit('TRIGGER_REFRESH');
            });
        </script>
    @endpush
@endsection
