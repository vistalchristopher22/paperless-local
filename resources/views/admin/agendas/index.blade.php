@extends('layouts.app')
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
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card border-0 m-0 ">Complete Listing of Agendas</h6>
            <div class="dropdown">
                <a href="{{ route('account.create') }}" class="btn btn-primary btn-sm">
                    Add New Agenda
                </a>
            </div>
        </div>
        <div class="card-body">

            <!-- User Listing Table-->
            <div class="table-responsive">
                <table class="table table-striped border" id="agendas-table">
                    <thead>
                        <tr>
                            <th class="text-center">Title</th>
                            <th class="text-center">Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas as $user)
                            <tr class="align-middle">
                                <td class="text-start text-muted">
                                    {{ $user->title }}
                                </td>
                                <td></td>
                                <td class="align-middle text-center">
                                    <form action="{{ route('account.destroy', $user) }}" method="POST">
                                        <a class="btn btn-sm btn-success text-white"
                                            href="{{ route('account.edit', $user) }}">Edit</a>
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                    </form>
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
                $('#agendas-table').DataTable({});
            });
        </script>
    @endpush
@endsection
