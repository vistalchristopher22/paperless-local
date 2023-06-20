@extends('layouts.app-2')
@section('tab-title', 'Edit Division')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        <div class="card-header bg-dark">
            <h6 class="card-title text-white h6 m-0">Edit Division</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('division.update', $division) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ old('name', $division->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Descrption</label>
                    <textarea name="description" class="form-control" rows="2" id="description">{{ old('description', $division->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Board</label>
                    <select name="board" class="form-select" id="select-board">
                        @foreach ($members as $member)
                            <option {{ old('board', $division->board) == $member->id ? 'selected' : '' }}
                                value="{{ $member->id }}">{{ $member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('board')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('division.index') }}" class="text-decoration-underline fw-bold">Back</a>
                    <button class="btn btn-success text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script>
            $('select[name="board"]').select2({
                placeholder: 'Select members',
                theme: "classic",
            });
        </script>
    @endpush
@endsection
