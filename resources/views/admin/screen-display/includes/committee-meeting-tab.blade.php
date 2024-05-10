@php use App\Enums\ScheduleType; @endphp
<div class="card">
    <div class="card-header bg-light">
        <div class="card-title">
            <span class="fw-medium h6 fw-bold">Display</span>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('screen-display.operate') }}" method="POST">
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



<div class="float-end">
    <button id="nextGuest" class="btn btn-dark shadow-dark mb-2">Move next guest</button>
</div>
<div class="clearfix"></div>
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
        <div class="">
            <table id="screen-display-table" class="table table-hover border">
                <thead>
                    <tr>
                        <th class="p-3 text-center bg-light border text-uppercase">Order</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Session</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Title</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Chairman</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Vice Chairman</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Status</th>
                        {{-- <th class="p-3 text-center bg-light border text-uppercase">Duration</th>
                            <th class="p-3 text-center bg-light border text-uppercase">Start Time</th>
                            <th class="p-3 text-center bg-light border text-uppercase">End Time</th> --}}
                        <th class="p-3 text-center bg-light border text-uppercase">actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
