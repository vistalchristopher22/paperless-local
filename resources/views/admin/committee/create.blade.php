@extends('layouts.app-2')
@section('tab-title', 'Add new Committee')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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
        <div class="card-header bg-light p-3 justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 text-dark m-0">New Committee Form</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('committee.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" readonly type="text"
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           name="name" value="{{ old('name') }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lead_committee" class="form-label">Lead Committee</label>
                    <div class="{{ $errors->has('lead_committee') ? 'border border-danger rounded' : '' }}">
                        <select id="lead_committee" data-type="text" class="form-select select2" name="lead_committee">
                            <option value="">No Lead Committee</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('lead_committee')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expanded_committee" class="form-label">Expanded Committee</label>
                    <div class="{{ $errors->has('expanded_committee') ? 'border border-danger rounded' : '' }}">
                        <select id="expanded_committee" class="form-select" multiple name="expanded_committee[]">
                            <option value="">Select Exanpaded Committee</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('expanded_committee')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="file">File</label>
                    <div class="{{ $errors->has('file') ? 'border border-danger rounded' : '' }}">
                        <input type="file" name="file" id="file" class="form-control">
                    </div>

                    @error('file')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-dark btn-md shadow-dark float-end mt-3">Submit</button>
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

            $('select[name="lead_committee"]').change(function () {
                $('#name').val($(this).find('option:selected').text().toUpperCase().replace('COMMITTEE ON', ''));
            });


            $('select[name="expanded_committee[]"]').select2({
                placeholder: 'Select Expanded Committee',
                maximumSelectionLength: 2,
            });
        </script>
    @endpush
@endsection
