@extends('layouts.app-2')
@section('tab-title', 'Add new Committee')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- tempus dominos --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>


    <!-- Font awesome is not required provided you change the icon options -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/solid.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/fontawesome.min.js"></script>
    <!-- end FA -->

    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.7/dist/js/tempus-dominus.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.7/dist/css/tempus-dominus.css" />
@endprepend
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 text-white m-0">New Committee Form</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('committee.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group d-none">
                    <label>Priority Number</label>
                    <input type="text" class="form-control" name="priority_number"
                        value="{{ old('priority_number', $priority_number) }}" readonly>
                    @error('priority_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Lead Committee</label>
                    <select type="text" class="form-select select2" name="lead_committee">
                        <option value="">No Lead Committee</option>
                        @foreach ($agendas as $agenda)
                            <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                        @endforeach
                    </select>
                    @error('lead_committee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Expanded Committee</label>
                    <select type="text" class="form-select" name="expanded_committee">
                        @foreach ($agendas as $agenda)
                            <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                        @endforeach
                    </select>
                    @error('expanded_committee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    {{-- <label class="form-label d-flex flex-row">
                        Schedule
                        <div class="form-check form-switch mx-3">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="with_guests">
                            <label class="form-check-label" for="flexSwitchCheckChecked">With Invited Guests</label>
                        </div>
                    </label> --}}
                    {{-- <div class="form-group mb-3">
                        <div class="input-group" id="datetimepicker1" data-td-target-input="nearest"
                            data-td-target-toggle="nearest">
                            <input id="schedule" readonly name="schedule" type="text" class="form-control"
                                data-td-target="#datetimepicker1" />
                            <span class="input-group-text" data-td-target="#datetimepicker1"
                                data-td-toggle="datetimepicker">
                                <span class="fa-solid fa-calendar"></span>
                            </span>
                        </div>
                    </div> --}}
                </div>




                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" name="file" id="file" class="form-control">
                    @error('file')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-primary float-end mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script>
            $('select[name="lead_committee"]').select2({
                placeholder: 'Select Lead Committee',
            });

            $('select[name="expanded_committee"]').select2({
                placeholder: 'Select Expanded Committee',

            });
        </script>

        <script>
            //using "window" is just for the stackblitz, you do not need to do this
            let datetimepicker = new tempusDominus.TempusDominus(
                document.getElementById('datetimepicker1'), {
                    restrictions: {
                        minDate: new Date()
                    },
                }
            );
        </script>
    @endpush
@endsection
