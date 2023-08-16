@extends('layouts.app-2')
@section('tab-title', 'Archive Regular Sessions')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endprepend

@section('content')

    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="fw-medium h6 card-title">Archive Invited Guests</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-2 text-uppercase text-center fw-medium">Fullname</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Description</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Venue</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Date</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Session</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($guests as $guest)
                        <tr>
                            <td><span class="mx-3"></span>{{ $guest->fullname }}</td>
                            <td class="text-center">{{ $guest?->schedule?->description }}</td>
                            <td class="text-center">{{ $guest?->schedule?->venue }}</td>
                            <td class="text-center">{{ $guest?->schedule?->date_and_time->format('F d, Y') }}</td>
                            <td class="text-uppercase text-center">{{ $guest?->schedule?->regular_session->number }} Regular Session - {{ $guest?->schedule?->regular_session->year }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            let table = $('.datatable').DataTable({});
        </script>
    @endpush
@endsection
