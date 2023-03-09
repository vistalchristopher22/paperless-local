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
            <form method="POST" action="{{ route('sanggunian-members.update', $member) }}">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $member->name) }}"
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


                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-success float-end mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
