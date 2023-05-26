@extends('layouts.app')
@section('page-title', 'Division List')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }
    </style>
@endprepend

@section('content')

    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">@yield('page-title')</span>
        </div>

        <div class="card-body">

            <!-- Divison Listing Table -->
            <div class="table-responsive">
                <table class="table table-striped border" id="division-table">
                    <thead>
                        <tr>
                            <th class="text-center border">Name</th>
                            <th class="text-center border">Description</th>
                            <th class="text-center border">Board</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $data)
                            <tr>
                                <td class="text-center border">{{ $data->name }}</td>
                                <td class="text-center border">{{ $data->description }}</td>
                                {{-- <td class="text-center text-dark border">{{ $data->board_member->fullname }}</td> --}}
                                <td class="text-center text-dark border">{{ $data->fullname }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#division-table').DataTable({});
            });
        </script>
    @endpush

@endsection
