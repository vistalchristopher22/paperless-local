@extends('layouts.app-2')
@section('tab-title', 'Add new Committee')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <h6 class="card-title h6 text-white m-0">Committee Form</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.committee.store') }}" enctype="multipart/form-data">
                @csrf
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
                    <label for="file" class="form-label">File</label>
                    <input type="file" name="file" id="file" class="form-control">
                    @error('file')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-primary float-end mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
