@extends('layouts.app-2')
@section('tab-title', 'New Sangguniang Member')
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-between align-items-center d-flex bg-dark">
            <h6 class="card-title h6 text-white">New Sangguniang Member Form</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sanggunian-members.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}" autofocus
                        class="form-control">
                    @error('fullname')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" name="district" id="district" value="{{ old('district') }}" class="form-control">
                    @error('district')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sanggunian">Sanggunian</label>
                    <input type="text" name="sanggunian" id="sanggunian" value="{{ old('sanggunian') }}"
                        class="form-control">
                    @error('sanggunian')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <label for="">Image</label>
                <div class="form-group">
                    <input type="file" class="form-control" name="image" id="image">
                </div>


                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('sanggunian-members.index') }}" class="text-decoration-underline fw-bold">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
