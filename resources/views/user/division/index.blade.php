@extends('layouts.app-2')
@section('tab-title', 'Division List')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
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
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h6 class="card-title h6 fw-medium text-white m-0">@yield('tab-title')</h6>
        </div>

        <div class="card-body">
            <!-- Divison Listing Table -->
            <div class="table-responsive">
                <table class="table table-striped border datatable" id="division-table">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-center border fw-medium">#</th>
                            <th class="text-center border fw-medium">Name</th>
                            <th class="text-center border fw-medium">Description</th>
                            <th class="text-center border fw-medium">Board Member</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $data)
                            <tr>
                                <td class="text-center border">{{ $data->id }}</td>
                                <td class="text-center border">{{ $data->name }}</td>
                                <td class="text-center border">{{ $data->description }}</td>
                                <td class="text-center text-dark border">{{ $data->board_member->fullname }}</td>
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
            $(document).ready(function() {
                $('#division-table').DataTable({});
            });
        </script>
    @endpush

@endsection
