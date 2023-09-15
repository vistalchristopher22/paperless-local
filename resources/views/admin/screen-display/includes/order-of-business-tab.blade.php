@php use App\Enums\ScheduleType; @endphp
<div class="card">
    <div class="card-header bg-light">
        <div class="card-title">
            <span class="fw-medium h6 fw-bold">&nbsp;</span>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('screen-display.operate') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <h5 class="card-title text-dark">Displays</h5>
            <div class="form-group row mt-2">
                <div class="col-sm-11 ms-auto">
                    <div class="form-check">
                        <input type="radio"
                            {{ $settingRepository->getValueByName('screen_display') === 'committee_meeting' ? 'checked' : '' }}
                            name="screen_display" class="form-check-input" id="committeeMeeting"
                            value="committee_meeting">
                        <label class="form-check-label" for="committeeMeeting">Committee Meeting</label>
                    </div>
                    <p class="text-muted">This will display committee meeting on the screen.</p>
                </div>
            </div>

            <div class="form-group row mt-2">
                <div class="col-sm-11 ms-auto">
                    <div class="form-check">
                        <input type="radio"
                            {{ $settingRepository->getValueByName('screen_display') === 'question_of_hour' ? 'checked' : '' }}
                            name="screen_display" class="form-check-input" id="questionOfHour" value="question_of_hour">
                        <label class="form-check-label" for="questionOfHour">Question of Hour</label>
                    </div>
                    <p class="text-muted">This will display a banner for Question of Hour on the screen.</p>
                    <label for="prepared_by" class="">Guest</label>
                    <div class="col-md-10">
                        <input type="text" name="question_of_hour_guest" id="question_of_hour_guest"
                            class="form-control" placeholder="Enter Fullname"
                            value="{{ old('question_of_hour_guest', $settingRepository->getValueByName('question_of_hour_guest')) }}">
                    </div>

                </div>
            </div>

            <div class="form-group row mt-2">
                <div class="col-sm-11 ms-auto">
                    <div class="form-check">
                        <input type="radio"
                            {{ $settingRepository->getValueByName('screen_display') === 'privilege_hour' ? 'checked' : '' }}
                            name="screen_display" class="form-check-input" id="privilegeHour" value="privilege_hour">
                        <label class="form-check-label" for="privilegeHour">Privilege Hour</label>
                    </div>
                    <div class="col-md-10">
                        <label for="member" class="">Display Member</label>
                        <br>

                        <select name="member" class="form-select" style="width : 100%;" id="member">
                            @foreach ($sanggunianMembers as $sanggunianMember)
                                <option
                                    {{ $settingRepository->getValueByName('privilege_hour_member') == $sanggunianMember->id ? 'selected' : '' }}
                                    value="{{ $sanggunianMember->id }}">{{ $sanggunianMember->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-muted">This will display a banner for Privilege Hour on the screen.</p>
                </div>
            </div>

            <div class="float-end">
                <input type="submit" value="Update" class="btn btn-dark shadow-dark shadow-lg">
            </div>
        </form>
    </div>
</div>
