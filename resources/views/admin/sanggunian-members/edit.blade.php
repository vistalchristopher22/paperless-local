@extends('layouts.app')
@section('page-title', 'Edit Sangguniang Panlalawigan Member')
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0">Edit Sangguniang Panlalawigan Member</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sanggunian-members.update', $member) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $member->fullname) }}"
                        autofocus class="form-control">
                    @error('fullname')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" name="district" id="district" value="{{ old('district', $member->district) }}"
                        class="form-control">
                    @error('district')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sanggunian">Sanggunian</label>
                    <input type="text" name="sanggunian" id="sanggunian"
                        value="{{ old('sanggunian', $member->sanggunian) }}" class="form-control">
                    @error('sanggunian')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $member->username) }}"
                        class="form-control">
                    @error('username')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div> --}}


                {{-- <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" value="{{ old('password') }}"
                        class="form-control">
                    @error('password')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div> --}}


                <img class="img-thumbnail mt-2" src="{{ asset('storage/user-images/' . $member->profile_picture)  }}" width="200px">
                <br>
                <br>

                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('sanggunian-members.index') }}" class="text-decoration-underline fw-bold">Back</a>
                    <button type="submit" class="btn btn-success text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
