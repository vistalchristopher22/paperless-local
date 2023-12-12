@extends('layouts.app-2')
@section('tab-title', 'Modify Legislation')
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

        <div class="card-header bg-light p-3">
            <div class="card-title h6 fw-medium">
                Modify Legislation
            </div>
        </div>

        <div class="card-body p-4">
            {{ route('legislation.update', $legislation->id) }}
            <form action="{{ route('legislation.update', $legislation->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="sessionDate" class="form-label">Session Date</label>
                    <input id="sessionDate" type="date" class="form-control  @error('sessionDate') is-invalid @enderror"
                        name="sessionDate" value="{{ old('sessionDate', $legislation?->legislable?->session_date) }}">
                    @error('sessionDate')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-dark" for="classification">Classification</label>
                    <select id="classification" name="classification"
                        class="form-select @error('classification') is-invalid @enderror">
                        @foreach ($classifications as $classification)
                            <option
                                {{ old('classification', $classification) == $legislation->classification ? 'selected' : '' }}
                                value="{{ $classification }}">{{ ucfirst($classification) }}</option>
                        @endforeach
                    </select>
                    @error('classification')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label id="resolution_no" class="form-label">No.</label>
                    <input id="reference_no" type="text" class="form-control @error('reference_no') is-invalid @enderror"
                        name="reference_no" value="{{ old('reference_no', $legislation->reference_no) }}">
                    @error('reference_no')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label class="form-label" for="title">Title</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ $legislation->title }}">
                    @error('title')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="form-label" for="type">Type</label>
                    <select id="type" class="form-select @error('type') is-invalid @enderror" name="type">
                        @foreach ($types as $type)
                            <option {{ old('type', $legislation?->legislable?->type) == $type->name ? 'selected' : '' }}
                                value="{{ $type->id }}">
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
                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description">{{ old('description', $legislation->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="form-label" for="author">Author</label>
                    <select id="author" name="author" class="form-select @error('author') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach ($spMembers as $spMember)
                            <option
                                {{ old('author', $legislation->legislable->author) == $spMember->id ? 'selected' : '' }}
                                value="{{ $spMember->id }}">
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
                    <label class="form-label" for="co_author">Co-Author</label>
                    <select id="co_author" name="co_author" class="form-select @error('co_author') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach ($spMembers as $sp_member)
                            <option
                                {{ old('author', $legislation->legislable->co_author) == $spMember->id ? 'selected' : '' }}
                                value="{{ $sp_member->id }}">{{ $sp_member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('co_author')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="sponsors">Sponsors</label>
                    <select id="sponsors" name="sponsors[]" multiple
                        class="form-select @error('sponsors') is-invalid @enderror">
                        <option value="">None</option>
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
                <h6 class="fw-bold">
                    {{ removeTimestampPrefix(removeFileExtension(basename($legislation?->legislable->file))) }}</h6>

                <div class="form-group mt-3">
                    <label class="text-dark">Attachment</label>
                    <input id="attachment" type="file" class="form-control form-control-md" name="attachment">
                    @error('attachment')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('legislation.index') }}"
                        class="text-decoration-underline fw-bold text-primary">Back</a>
                    <button id="btnUpdate" type="submit" class="btn btn-dark shadow-lg-dark">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            const sponsors = @json($sponsors);
            const coAuthor = @json($coAuthor);

            $('select#author').select2({});
            let legislateSponsorsSelect2 = $('select#sponsors').select2({});
            let legislateCoAuthorSelect2 = $('select#co_author').select2({});
            legislateSponsorsSelect2.val(sponsors).trigger('change');
            legislateCoAuthorSelect2.val(coAuthor).trigger('change');
        </script>
    @endpush
@endsection
