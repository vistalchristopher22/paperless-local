@extends('layouts.app-2')
@section('tab-title', 'Division List')
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
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h6 class="fw-bold h6 text-white">Complete Listing of Divisions</h6>
            <a href="{{ route('division.create') }}" class="btn btn-light fw-bold">
                Add New Division
            </a>
        </div>

        <div class="card-body">

            <!-- Divison Listing Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-color: transparent" id="division-table">
                    <thead>
                        <tr>
                            <th class="text-center text-dark border bg-light">Name</th>
                            <th class="text-center text-dark border bg-light">Description</th>
                            <th class="text-center text-dark border bg-light">Board</th>
                            <th class="text-center text-dark border bg-light">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $data)
                            <tr>
                                <td class="text-center ">{{ $data->name }}</td>
                                <td class="text-center ">{{ $data->description }}</td>
                                <td class="text-center text-dark ">{{ $data->board_member->fullname }}</td>
                                <td class="align-middle text-center ">
                                    <form action="{{ route('division.destroy', $data) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('division.edit', $data) }}" class="btn btn-success text-white"
                                            title="Edit Division" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <button class="btn btn-danger text-white" title="Delete Division"
                                            data-bs-toggle="tooltip" data-bs-placement="top"><i
                                                class="mdi mdi-trash-can-outline"></i></button>
                                    </form>

                                    {{-- <button type="button" class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteBtn">Delete</button>

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
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#division-table').DataTable({});
            });
        </script>
    @endpush

@endsection
