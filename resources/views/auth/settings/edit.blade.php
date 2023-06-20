@extends('layouts.app-2')
@section('tab-title', 'Edit Information')
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @else
        <div class="card mb-2 bg-info shadow-sm text-white">
            <div class="card-body">
                Skip password field to keep your current password.
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 h6 text-white">Edit Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('information.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name">Firstname</label>
                    <input type="text" name="first_name" id="first_name"
                        value="{{ old('first_name', $account->first_name) }}" autofocus class="form-control">
                    @error('first_name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div class="form-group">
                    <label for="middle_name">Middlename</label>
                    <input type="text" name="middle_name" id="middle_name"
                        value="{{ old('middle_name', $account->middle_name) }}" class="form-control">
                    @error('middle_name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name">Lastname</label>
                    <input type="text" name="last_name" id="last_name"
                        value="{{ old('last_name', $account->last_name) }}" class="form-control">
                    @error('last_name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Suffix -->
                <div class="form-group">
                    <label for="suffix">Suffix</label>
                    <input type="text" name="suffix" id="suffix" value="{{ old('suffix', $account->suffix) }}"
                        class="form-control">
                    @error('suffix')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $account->username) }}"
                        class="form-control">
                    @error('username')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">Profile Picture</label>
                    <input type="file" name="image" id="file" class="form-control">
                    @error('image')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-success float-end mt-3">
                        <i class="mdi mdi-pencil"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
