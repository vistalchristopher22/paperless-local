@extends('layouts.app-2')
@section('tab-title', 'Create Legislation')
@section('content')
    <div class="card">
        @if (Session::has('success'))
            <div class="card mb-2 bg-success shadow-sm text-white">
                <div class="card-body">
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif

        <div class="card-header bg-light p-3">
            <div class="card-title h6 fw-medium">Create Legislation Form</div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('legislation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="sessionDate" class="form-label">Session Date</label>
                    <input type="date" class="form-control @error('sessionDate') is-invalid @enderror"
                           name="sessionDate" id="sessionDate" value="{{ old('sessionDate') }}">
                    @error('sessionDate')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="classification" class="form-label">Classification</label>
                    <select name="classification" id="classification"
                            class="form-select @error('classification') is-invalid @enderror">
                        @foreach($classifications as $classification)
                            <option value="{{ $classification }}">{{ ucfirst($classification->value) }}</option>
                        @endforeach
                    </select>
                    @error('classification')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                           placeholder="Enter title here" value="{{ old('title') }}">
                    @error('title')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" name="type" id="type">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                              name="description" id="description"
                              placeholder="Enter description here..">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="author">Author</label>
                    <select name="author" id="author" class="form-select @error('author') is-invalid @enderror">
                        @foreach ($spMembers as $sp_member)
                            <option value="{{ $sp_member->id }}">{{ $sp_member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('author')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Attachment</label>
                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment"
                           id="attachment">
                    @error('attachment')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('legislation.index') }}" class="text-decoration-underline fw-bold text-primary">Back</a>
                    <button type="submit" class="btn btn-dark" id="btnSave">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
