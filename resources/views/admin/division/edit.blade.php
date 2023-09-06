@extends('layouts.app-2')
@section('tab-title', 'Edit Division')
@prepend('page-css')
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
        <div class="card-header bg-light">
            <div class="card-title">
                <h6 class="card-title h6 m-0">Edit Division</h6>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('division.update', $division) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                           value="{{ old('name', $division->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Descrption</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="2"
                              id="description">{{ old('description', $division->description) }}</textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="select-board" class="form-label">Board Member</label>
                    <input type="text" class="form-control @error('select-board') is-invalid @enderror"
                           id="select-board" name="board" value="{{ old('board', $division->board) }}">
                    @error('board')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('board')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('division.index') }}" class="text-decoration-underline fw-bold
                    text-primary">Back</a>
                    <button class="btn btn-dark shadow-lg text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
    @endpush
@endsection
