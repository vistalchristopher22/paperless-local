@extends('layouts.app')

@section('content')

    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h6 class="card-title m-0">Create Division</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('division.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Descrption</label>
                    <textarea name="description" class="form-control" rows="2" id="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('division.index') }}" class="text-decoration-underline fw-bold">Back</a>
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
