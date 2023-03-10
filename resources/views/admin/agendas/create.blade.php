@extends('layouts.app')
@section('page-title', 'Create Agenda')
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
            <h6 class="card-title m-0">Create Agenda</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('agendas.store') }}">
                @csrf

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Descrption</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Chairman</label>
                    <select name="chairman" class="form-select">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('chairman')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Vice Chairman</label>
                    <select name="vice_chairman" class="form-select">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('vice_chairman')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Members <span class="text-primary">(Use the <span class="fw-bold">CTRL</span> key on your
                            keyboard to select
                            multiple)</span></label>
                    <select name="members[]" class="form-select" multiple aria-label="multiple select example">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('members')
                        <span class="text-danger">{{ $message }}</span>
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
