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
    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 h6">Edit Commitee</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.committee.update', $committee) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" readonly class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                        value="{{ old('name', $committee->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Lead Committee</label>
                    <div class="@error('lead_committee') border border-danger rounded @enderror">
                        <select type="text" class="form-select select2" name="lead_committee">
                            @foreach ($agendas as $agenda)
                                <option
                                    {{ old('lead_committee', $committee->lead_committee) == $agenda->id ? 'selected' : '' }}
                                    value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('lead_committee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Expanded Committee</label>
                    <div class="@error('expanded_committee') border border-danger rounded @enderror">
                        <select type="text" class="form-select" name="expanded_committee[]" multiple>
                            @foreach ($agendas as $agenda)
                                @if (old('expanded_committee') !== null)
                                    <option {{ in_array($agenda->id, old('expanded_committee')) ? 'selected' : '' }}
                                        value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                                @else
                                    <option
                                        {{ old('expanded_committee', $committee->expanded_committee) == $agenda->id ? 'selected' : '' }}
                                        {{ $committee->expanded_committee_2 == $agenda->id ? 'selected' : '' }}
                                        value="{{ $agenda->id }}">{{ $agenda->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('expanded_committee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>File
                        <a href="#" class="fw-bold text-decoration-underline text-primary btn-edit"
                            data-id="{{ $committee->id }}">({{ basename($committee->file_path) }})</a>
                    </label>

                    <input type="file" name="file" id="file"
                        class="form-control mt-1 @error('file') is-invalid @enderror">

                    @error('file')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
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

            $('select[name="expanded_committee[]"]').select2({
                placeholder: 'Select Expanded Committee',
                maximumSelectionLength: 2,
            });

              $('select[name="lead_committee"]').change(function () {
                $('#name').val($(this).find('option:selected').text().toUpperCase().replace('COMMITTEE ON', ''));
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
