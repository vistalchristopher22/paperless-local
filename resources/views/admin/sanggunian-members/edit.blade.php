@extends('layouts.app-2')
@section('tab-title', 'Edit Sangguniang Panlalawigan Member')
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
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 fw-medium">Edit {{ $member->fullname }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sanggunian-members.update', $member) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $member->fullname) }}"
                           autofocus class="form-control @error('fullname') is-invalid @enderror">
                    @error('fullname')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="district" class="form-label">District</label>
                    <input type="text" name="district" id="district" value="{{ old('district', $member->district) }}"
                           class="form-control @error('district') is-invalid @enderror">
                    @error('district')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sanggunian">Sanggunian</label>
                    <input type="text" name="sanggunian" id="sanggunian"
                           value="{{ old('sanggunian', $member->sanggunian) }}"
                           class="form-control @error('sanggunian') is-invalid @enderror">
                    @error('sanggunian')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <img class="img-thumbnail mb-3" src="{{ asset('storage/user-images/' . $member->profile_picture)  }}"
                     width="200px">

                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('sanggunian-members.index') }}" class="text-decoration-underline fw-bold text-primary">Back</a>
                    <button type="submit" class="btn btn-dark shadow-lg-dark text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
