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
            <div class="dropdown">
                <a href="{{ route('division.create') }}" class="btn btn-primary">
                    Add New Division
                </a>
            </div>
        </div>

        <div class="card-body">

            <!-- Divison Listing Table -->
            <div class="table-responsive">
                <table class="table table-striped border" id="division-table">
                    <thead>
                        <tr>
                            <th class="text-center text-dark border">Name</th>
                            <th class="text-center text-dark border">Description</th>
                            <th class="text-center text-dark border">Board</th>
                            <th class="text-center text-dark border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $data)
                            <tr>
                                <td class="text-center border">{{ $data->name }}</td>
                                <td class="text-center border">{{ $data->description }}</td>
                                {{-- <td class="text-center text-dark border">{{ $data->board_member->fullname }}</td> --}}
                                <td class="text-center text-dark border">{{ $data->fullname }}</td>
                                <td class="align-middle text-center border">
                                    <form action="{{ route('division.destroy', $data) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('division.edit', $data)  }}" class="btn btn-sm btn-success text-white">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm text-white"><i class="fas fa-trash text-white"></i></button>
                                    </form>

                                    {{-- <button type="button" class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteBtn">Delete</button>

                                    <div class="modal fade" id="deleteBtn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Attention!</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>Are you sure you want to delete this data?</h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                                <form action="{{ route('division.destroy', $data->id ) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </td>
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
