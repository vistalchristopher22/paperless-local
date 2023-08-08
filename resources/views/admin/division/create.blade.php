@extends('layouts.app-2')
@section('tab-title', 'Create Division')
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
        <div class="card-header bg-light">
            <div class="card-title">
                <h6 class="card-title m-0 text-dark h6">Create Division Form</h6>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('division.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Descrption</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2" id="description"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="select-board" class="form-label">Board Member</label>
                    <select name="board" class="form-select" id="select-board">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('board')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('division.index') }}" class="text-decoration-underline fw-bold
                    text-primary">Back</a>
                    <button class="btn btn-dark shadow-dark-lg fw-medium btn-md">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('select[name="board"]').select2({
                placeholder: 'Select members',
            });
        </script>
    @endpush
@endsection
