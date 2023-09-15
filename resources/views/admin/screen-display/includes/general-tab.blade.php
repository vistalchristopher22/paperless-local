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
            <h5 class="card-title text-dark">Announcements</h5>
            <div class="card-text">
                <div class="form-group row mt-3">
                    <label for="prepared_by" class="col-md-2 col-form-label text-md-right">Running Text Speed</label>
                    <div class="col-md-10">
                        <input type="text" name="announcement_running_speed" id="announcement_running_speed" class="form-control"
                               placeholder="Enter speed e.g 5"
                               value="{{ old('announcement_running_speed', $settingRepository->getValueByName('announcement_running_speed')) }}">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="prepared_by" class="col-md-2 col-form-label text-md-right">Content</label>
                    <div class="col-md-10">
                        <textarea name="announcement" class="form-control" cols="30" rows="10">{{ old('announcement', $settingRepository->getValueByName('display_announcement')) }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="border-dashed">


            <h5 class="card-title text-dark">Connectivity</h5>
            <div class="card-text">
                <div class="form-group row mt-2">
                    <label for="announcement" class="col-md-2 col-form-label text-md-right">Refresh Clients</label>
                    <div class="col-md-10">
                        <button class="btn bg-dark text-white fw-medium" type="button" id="refreshClients">Refresh Clients</button>
                        <p class="text-muted">
                            This feature allows you to instantly update all connected clients with the
                            latest data available on the server.
                        </p>
                    </div>
                </div>


            </div>

            <div class="float-end">
                <input type="submit" value="Update" class="btn btn-dark shadow-dark shadow-lg">
            </div>
        </form>
    </div>
</div>
