@extends('layouts.app-2')
@section('tab-title', 'New Sangguniang Member')
@section('content')
    @if (session()->has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-between p-3 align-items-center d-flex bg-light">
            <h6 class="card-title h6 fw-medium">New Sangguniang Member</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sanggunian-members.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" name="fullname" id="fullname"
                           value="{{ old('fullname') }}" autofocus
                           class="form-control @error('fullname') is-invalid @enderror">
                    @error('fullname')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="district" class="form-label">District</label>
                    <input type="text" name="district" id="district" value="{{ old('district') }}"
                           class="form-control @error('district') is-invalid @enderror">
                    @error('district')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sanggunian" class="form-label">Sanggunian</label>
                    <input type="text" name="sanggunian" id="sanggunian" value="{{ old('sanggunian') }}"
                           class="form-control @error('sanggunian') is-invalid @enderror">
                    @error('sanggunian')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <label for="image" class="form-label">Image</label>
                <div class="form-group">
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                           id="image">
                    @error('image')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('sanggunian-members.index') }}"
                       class="text-decoration-underline fw-bold text-primary">Back</a>
                    <button type="submit" class="btn btn-dark btn-md shadow-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
