@extends('layouts.app-2')
@section('tab-title', 'Modify Legislation')
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

        <div class="card-header bg-light p-3">
            <div class="card-title h6 fw-medium">
                Modify Legislation
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('legislation.update', $legislation->id) }}" method="POST"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="sessionDate" class="form-label">Session Date</label>
                    <input type="date" class="form-control  @error('sessionDate') is-invalid @enderror"
                           name="sessionDate" id="sessionDate"
                           value="{{ old('sessionDate', $legislation?->legislable?->session_date) }}">
                    @error('sessionDate')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-dark" for="classification">Classification</label>
                    <select name="classification" id="classification"
                            class="form-select @error('classification') is-invalid @enderror">
                        @foreach($classifications as $classification)
                            <option
                                {{ old('classification', $classification) == $legislation->classification ? 'selected' : '' }} value="{{ $classification }}">{{ ucfirst($classification) }}</option>
                        @endforeach
                    </select>
                    @error('classification')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                           value="{{ $legislation->title }}">
                    @error('title')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="form-label" for="type">Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" name="type" id="type">
                        @foreach ($types as $type)
                            <option
                                {{ old('type', $legislation?->legislable?->type) == $type->name ? 'selected' : '' }} value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('type')
                    <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                              name="description"
                              id="description">{{ old('description', $legislation->description) }}</textarea>
                    @error('description')
                    <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="form-label" for="author">Author</label>
                    <select name="author" id="author" class="form-select @error('author') is-invalid @enderror">
                        @foreach ($spMembers as $spMember)
                            <option
                                {{ old('author', $legislation->legislable->author) == $spMember->id ? 'selected' : '' }} value="{{ $spMember->id }}">
                                {{ $spMember->fullname }}
                            </option>
                        @endforeach
                    </select>
                    @error('author')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="sponsors">Sponsors</label>
                    <select name="sponsors[]" multiple id="sponsors"
                            class="form-select @error('sponsors') is-invalid @enderror">
                        @foreach ($spMembers as $sp_member)
                            <option value="{{ $sp_member->id }}">{{ $sp_member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('sponsors')
                    <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <img src="{{ getIconByFileName($legislation?->legislable->file) }}" width="100px" alt="No Image">
                <h6 class="fw-bold">{{ removeTimestampPrefix(removeFileExtension(basename($legislation?->legislable->file))) }}</h6>

                <div class="form-group mt-3">
                    <label class="text-dark">Attachment</label>
                    <input type="file" class="form-control form-control-md" name="attachment" id="attachment">
                    @error('attachment')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('legislation.index') }}"
                       class="text-decoration-underline fw-bold text-primary">Back</a>
                    <button type="submit" class="btn btn-dark shadow-lg-dark" id="btnUpdate">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            const sponsors = @json($sponsors);

            $('select#author').select2({});
            let legislateSponsorsSelect2 = $('select#sponsors').select2({});
            legislateSponsorsSelect2.val(sponsors).trigger('change');
        </script>
    @endpush
@endsection
