@extends('layouts.app')
@section('page-title', 'Modify Schedule')
@prepend('page-css')
@endprepend
@section('content')
    <div class="card">
        <div class="card-header bg-dark">
            <div class="card-title text-white h6 text-uppercase">
                @yield('page-title')
            </div>
        </div>
        <div class="card-body">
            <div class="header d-flex flex-row align-items-center justify-content-center border border-start-0 border-end-0 border-top-0 border-5 mb-3">
                <img width="13%" src="{{ asset('session/logo.png') }}" alt="" class="me-auto">
                <div class="d-flex flex-column align-items-center">
                    <h5>Republic of the Philippines</>
                    <h5 class="fw-bold">PROVINCE OF SURIGAO DEL SUR</h5>
                    <h5>Tandag City</h5>
                    <h3 class="fw-bold">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</h3>
                    <h5>(Office of the Provincial Council)</h5>
                </div>
                <img width="14.5%" src="{{ asset('assets/tsp.png') }}" alt="" class="ms-auto">
            </div>

        </div>
    </div>

    @push('page-scripts')
    @endpush
@endsection
