@extends('layouts.app-2')
@section('page-title', 'Edit User Account')
@prepend('page-css')
    <style>
        .required::after {
            content: " *";
            color: red;
        }
    </style>
@endprepend
@section('content')
    @if (session()->has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ session()->get('success') }}
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
            <h6 class="card-title m-0 text-white">User Details</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('account.update', $account->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name" class="form-label required">Firstname</label>
                    <input type="text" name="first_name" id="first_name"
                           value="{{ old('first_name', $account->first_name) }}" autofocus
                           class="form-control
                        {{ $errors->has('first_name') ? 'is-invalid' : '' }}">
                    @error('first_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div class="form-group">
                    <label for="middle_name" class="form-label">Middlename</label>
                    <input type="text" name="middle_name" id="middle_name"
                           value="{{ old('middle_name', $account->middle_name) }}"
                           class="form-control
                   {{ $errors->has('middle_name') ? 'is-invalid' : '' }}">
                    @if ($errors->has('middle_name'))
                        <span class="text-danger"> {{ $errors->first('middle_name') }}</span>
                    @endif
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name" class="form-label required">Lastname</label>
                    <input type="text" name="last_name" id="last_name"
                           value="{{ old('last_name', $account->last_name) }}"
                           class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                    @if ($errors->has('last_name'))
                        <span class="text-danger"> {{ $errors->first('last_name') }}</span>
                    @endif
                </div>

                <!-- Suffix -->
                <div class="form-group">
                    <label for="suffix">Suffix</label>
                    <input type="text" name="suffix" id="suffix" value="{{ old('suffix', $account->suffix) }}"
                           class="form-control {{ $errors->has('suffix') ? 'is-invalid' : '' }}">
                    @if ($errors->has('suffix'))
                        <span class="text-danger"> {{ $errors->first('suffix') }}</span>
                    @endif
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username" class="form-label required">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $account->username) }}"
                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}">
                    @if ($errors->has('username'))
                        <span class="text-danger"> {{ $errors->first('username') }}</span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control
                    @if ($errors->has('password')) is-invalid @endif">
                    @if ($errors->has('password'))
                        <span class="text-danger"> {{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <!-- Account Type -->
                    <label for="account_type" class="form-label required">Account type</label>
                    <select name="account_type" id="account_type"
                            class="form-control {{ $errors->has('account_type') ? 'is-invalid' : '' }}">
                        @foreach ($types as $type)
                            <option {{ old('account_type', $account->account_type) == $type->value ? 'selected' : '' }}
                                    value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('account_type'))
                        <span class="text-danger"> {{ $errors->first('account_type') }}</span>
                    @endif
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status"
                            class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        @foreach ($status as $s)
                            <option {{ old('status', $account->status->value) == $s->value ? 'selected' : '' }}
                                    value="{{ $s->value }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('status'))
                        <span class="text-danger"> {{ $errors->first('status') }}</span>
                    @endif
                </div>

                <!-- Division -->
                <div class="form-group">
                    <label for="division" class="form-label required">Division</label>
                    <select class="form-control {{ $errors->has('division') ? 'is-invalid' : '' }}" name="division"
                            id="division">
                        @foreach ($divisions as $division)
                            <option value="{{ old('division', $division->id) }}" {{ $division->id == $account->id }}>
                                {{ $division->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('division'))
                        <div class="invalid-feedback">{{ $errors->first('division') }}</div>
                    @endif
                </div>

                <!-- Image File -->
                <p>
                    <img class="img-thumbnail mt-2"
                         src="{{ asset('storage/user-images/' . $account->profile_picture) }}"
                         width="200px">
                </p>

                <label for="" class="form-label required">Image</label>
                <div class="form-group">
                    <input type="file" class="form-control" name="image">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('account.index') }}" class="text-decoration-underline fw-bold">Back</a>
                    <button type="submit" class="btn btn-success text-white float-end mt-3">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
