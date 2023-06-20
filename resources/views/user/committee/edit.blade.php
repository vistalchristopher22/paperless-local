@extends('layouts.app-2')
@section('tab-title', 'Commitee')
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
    @if($errors->any())
    {{ dd($errors->all()) }}
    @endif
    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title h6  text-white m-0">Committee Details</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.committee.update', $committee) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $committee->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Lead Committee</label>
                    <select type="text" class="form-select select2" name="lead_committee">
                        @foreach ($agendas as $agenda)
                            <option {{ old('lead_committee', $committee->lead_committee) == $agenda->id ? 'selected' : '' }}
                                value="{{ $agenda->id }}">{{ $agenda->title }}</option>
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
                            <option
                                {{ old('expanded_committee', $committee->expanded_committee) == $agenda->id ? 'selected' : '' }}
                                value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                        @endforeach
                    </select>
                    @error('expanded_committee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="form-label">File <a href="#"
                            class="fw-bold text-decoration-underline text-primary btn-edit"
                            data-id="{{ $committee->id }}">({{ basename($committee->file_path) }})</a></label>
                    <input type="file" name="file" id="file" class="form-control mt-1">
                    @error('file')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-success float-end mt-3">Update</button>
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

            document.addEventListener('click', event => {
                if (event.target.matches('.btn-edit')) {
                    const id = event.target.getAttribute('data-id');
                    fetch(`/committee-file/${id}/edit`)
                        .then(response => response.json())
                        .then(data => socket.emit('EDIT_FILE', data))
                        .catch(error => console.error(error));
                }
            });
        </script>
    @endpush
@endsection
