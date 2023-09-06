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
            <div class="card-title">
                <h6 class="fw-medium h6">Create new Committee</h6>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('agendas.store') }}">
                @csrf

                <div class="form-group">
                    <label for="title" class="text-dark form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title">
                    @error('title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="text-dark form-label" for="select-chairman">Chairman</label>
                    <div class="@error('chairman') border border-danger rounded @enderror">
                        <select name="chairman" class="form-select"
                                id="select-chairman">
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('chairman')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label text-dark">Vice Chairman</label>
                    <div class="@error('vice_chairman') border border-danger rounded @enderror">
                        <select name="vice_chairman" class="form-select @error('vice_chairman') is-invalid @enderror"
                                aria-label="select
                    example">
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('vice_chairman')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label text-dark">Sanggunian</label>
                    <input type="text" class="form-control @error('sanggunian') is-invalid @enderror" name="sanggunian"
                           value="{{ old('sanggunian', \App\Repositories\SettingRepository::getValueByName('current_sanggunian')) }}">
                    @error('sanggunian')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="members" class="form-label text-dark">Members</label>
                    <div class="@error('members') border border-danger rounded @enderror">
                        <select name="members[]" class="form-select"
                                multiple>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
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
