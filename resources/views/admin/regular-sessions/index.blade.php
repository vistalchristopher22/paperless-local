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
            <h6 class="fw-medium h6 card-title">Archive Regular Sessions</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped datatable table-bordered border">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-2 text-uppercase text-center fw-medium">Session</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Year</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Venue</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Session</th>
                        <th class="p-2 text-uppercase text-center fw-medium">Committee</th>
                        <th class="p-2 text-uppercase fw-medium text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($referenceSessions as $session)
                        <tr>
                            <td class="text-center">{{ $session->number }} Regular Session</td>
                            <td class="text-center">{{ $session->year }}</td>
                            <td class="text-center text-uppercase">{{ $session->scheduleSessions?->implode('venue', ', ') }}</td>
                            <td class="text-center text-uppercase">{{ $session->scheduleSessions?->implode('name', ', ') }}</td>
                            <td class="text-center text-uppercase">{{ $session->scheduleCommittees?->implode('name', ', ') }}</td>
                            <td class="text-center">
                                <a href="{{ route('regular-session.show', $session->id) }}" class="btn btn-info"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   data-bs-original-title="View Regular Session">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </a>
                            </td>
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
