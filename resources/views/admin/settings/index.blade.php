@extends('layouts.app')
@section('page-title', 'Edit Information')
@section('content')

    @if(session()->has('success'))
        <div class="card bg-success mb-3">
            <div class="card-body text-white">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h6 class="fw-bold">Application Settingss</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')
                <h5 class="card-title text-muted">Committee Report</h5>
                <div class="card-text">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Prepared By</label>
                        <div class="col-md-10">
                            <input type="text" name="prepared_by" id="prepared_by" class="form-control" 
                                placeholder="Merlita S. Deligero" value="{{ $settings?->where('name', 'prepared_by')?->first()?->value }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="noted_by" class="col-md-2 col-form-label text-md-right">Noted By</label>
                        <div class="col-md-10">
                            <input type="text" name="noted_by" id="noted_by" class="form-control" value="{{ $settings?->where('name', 'noted_by')?->first()?->value }}"
                                placeholder="Gemma M. Picasales">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Current Regular Session</label>
                        <div class="col-md-10">
                            <input type="number" name="current_session" id="current_session" class="form-control" value="{{ $settings?->where('name', 'current_session')?->first()?->value }}"
                                placeholder="">
                        </div>
                    </div>

                </div>

                <hr>

                <h5 class="card-title text-muted">Third-Parties</h5>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">LibreOffice Path</label>
                    <div class="col-md-10">
                        <input type="text" name="libre_office_path" id="libre_office_path" class="form-control"
                            placeholder="C:\ProgramFiles\LibreOffice\" value="{{ $settings?->where('name', 'libre_office_path')?->first()?->value }}">
                    </div>
                </div>

                <div class="form-group
                            row mb-0">
                        <div class="col-md-10 text-end offset-md-2">
                            <button type="submit" class="btn btn-primary">
                                Save Setting
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

@endsection
