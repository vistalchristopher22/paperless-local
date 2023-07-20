@extends('layouts.app-2')
@section('tab-title', 'Create Agenda')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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
        <div class="card-header bg-light p-3 justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 text-dark">Create new Agenda</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('agendas.store') }}">
                @csrf

                <div class="form-group">
                    <label class="text-dark fw-bolder form-label">Title</label>
                    <input type="text" class="form-control" name="title">
                    @error('title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="text-dark form-label fw-bolder">Chairman</label>
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
                    <label class="form-label text-dark fw-bolder">Vice Chairman</label>
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
                    <label class="form-label text-dark fw-bolder">Members</label>
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
                    <button type="submit" class="btn btn-dark btn-md float-end mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {

                $('select[name="members[]"]').select2({
                    placeholder: 'Select members',
                });

                $('select[name="vice_chairman"]').select2({
                    placeholder: 'Select Vice chairman',
                });

                $('select[name="chairman"]').select2({
                    placeholder: 'Select Chairman',
                });

            });
        </script>
    @endpush
@endsection
