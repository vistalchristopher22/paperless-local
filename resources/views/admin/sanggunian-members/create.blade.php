@extends('layouts.app')
@section('page-title', 'New Sangguniang Member')
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
            <h6 class="card-title m-0">New Sangguniang Member</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sanggunian-members.store') }}">
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


                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control">
                    @error('username')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" value="{{ old('password') }}"
                        class="form-control">
                    @error('password')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-primary float-end mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
