@extends('layouts.app')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endprepend
@section('page-title', 'Commitee')
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0">Commitee</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('committee.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Priority Number</label>
                    <input type="text" class="form-control" name="priority_number"
                        value="{{ old('priority_number', $priority_number) }}" readonly>
                    @error('priority_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Lead Committee</label>
                    <select type="text" class="form-select select2" name="lead_committee">
                        @foreach ($agendas as $agenda)
                            <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                        @endforeach
                    </select>
                    @error('lead_committee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Expanded Committee</label>
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
                    <label>Schedule</label>
                    <input type="text" class="form-control" name="schedule" value="{{ old('schedule') }}">
                    @error('schedule')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
    @endpush
@endsection
