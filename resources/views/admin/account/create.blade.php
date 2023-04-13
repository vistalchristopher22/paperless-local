@extends('layouts.app')
@section('page-title', 'Create User')
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
            <h6 class="card-title m-0">@yield('page-title')</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('account.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name">Firstname</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" autofocus
                        class="form-control @error('first_name') is-invalid @enderror" >
                    @error('first_name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div class="form-group">
                    <label for="middle_name">Middlename</label>
                    <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}"
                        class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}">
                    @error('middle_name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name">Lastname</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                        class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                    @error('last_name')
                        <span class="invalid-feedback"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Suffix -->
                <div class="form-group">
                    <label for="suffix">Suffix</label>
                    <input type="text" name="suffix" id="suffix" value="{{ old('suffix') }}" class="form-control @error('suffix') is-invalid @enderror">
                    @error('suffix')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="form-control @error('username') is-invalid @enderror">
                    @error('username')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Account Type -->
                <div class="form-group">
                    <label for="account_type">Account Type</label>
                    <select name="account_type" id="account_type" class="form-control
                    {{ $errors->has('account_type') ? 'is-invalid' : '' }}">
                        @foreach ($types as $type)
                            <option {{ old('account_type') == $type->value ? 'selected' : '' }}
                                value="{{ $type }}">
                                {{ $type->value }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('account_type'))
                    <span class="invalid-feedback">{{ $errors->first('account_type') }}</span>
                    @endif
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        @foreach ($status as $status)
                            <option {{ old('status') == $status->value ? 'selected' : '' }} value="{{ $status->value }}">
                                {{ $status->name }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Division -->
                <div class="form-group">
                    <label for="">Division</label>

                    <select class="form-control {{ $errors->has('division') ? 'is-invalid' : '' }}" name="division" id="division">
                        <option default value="">-- Select--</option>
                        @foreach($divisions as $data)
                            <option value="{{ $data->id }}" {{ $data->id == old('division') ? 'selected' : '' }}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                    @error('division')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Image File -->
                <label for="">Image</label>
                <div class="form-group">
                    <input type="file" class="form-control" name="image" id="image">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('account.index') }}" class="text-decoration-underline fw-bold">Back</a>
                    <button type="submit" class="btn btn-primary float-end mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
