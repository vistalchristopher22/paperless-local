@extends('layouts.app-2')

@section('page-title', 'Create Legislation')

@section('content')
    <div class="card">

        @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
        @endif

        <div class="card-header bg-light">
            Create Legislation
        </div>

        <div class="card-body p-4">
            <form action="{{ route('legislation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Session Date</label>
                    <input type="date" class="form-control form-control-md" name="sessionDate" id="sessionDate">
                </div>
                <div class="form-group">
                    <label class="text-dark">Type</label>
                    <select name="type" id="type" class="form-select form-select-md">
                        @foreach($types as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="text-dark">Title</label>
                    <input type="text" class="form-control form-control-md" name="title" id="title" placeholder="Enter title here..">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="text-dark">Description</label>
                    <input type="text" class="form-control form-control-md" name="description" id="description" placeholder="Enter description here..">
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-dark">Author</label>
                    <select name="author" id="author" class="form-select form-select-md">
                        @foreach ($sp_members as $sp_member)
                            <option value="{{ $sp_member->id }}">{{ $sp_member->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="text-dark">Attachment</label>
                    <input type="file" class="form-control form-control-md" name="attachment" id="attachment">
                    @error('attachment')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('legislation.index') }}" class="text-decoration-underline fw-bold text-primary fs-4">Back</a>
                    <button type="submit" class="btn btn-success" id="btnSave">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
