@extends('layouts.app')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endprepend
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
                    <label>Chairman</label>
                    <select name="chairman" class="form-select" id="select-chairman">
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
                    <select name="vice_chairman" class="form-select" aria-label="select example">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                        @endforeach
                    </select>
                    @error('vice_chairman')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Members <span class="text-primary">(Use the <span class="fw-bold">CTRL or SHIFT</span> key on
                            your
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
    @push('page-scripts')
    <script>
        $(document).ready(function() {
            
            $('select[name="members[]"]').select2({
                placeholder: 'Select members',
                theme: "classic",
            });

            $('select[name="vice_chairman"]').select2({
                placeholder: 'Select Vice chairman',
                theme: "classic",
            });

            $('select[name="chairman"]').select2({
                placeholder: 'Select Chairman',
                theme: "classic",
            });
   
        });
    </script>
    @endpush
@endsection
