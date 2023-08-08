@extends('layouts.app-2')
@section('tab-title', 'Division List')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
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
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div class="card-title">
                <h6 class="fw-bold h6">Complete Listing <span class="text-lowercase">of</span> Divisions</h6>
            </div>
            <div>
                <a href="{{ route('division.create') }}" class="btn btn-dark shadow-dark-lg fw-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Add New Division
                </a>
            </div>
        </div>

        <div class="card-body">

            <!-- Divison Listing Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                       style="border-color: transparent" id="division-table">
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
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#division-table').DataTable({});
            });
        </script>
    @endpush

@endsection
