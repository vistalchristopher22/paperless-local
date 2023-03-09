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
            <h6 class="card-title m-0">User Management</h6>
            <div class="dropdown">
                <a href="{{ route('account.create') }}" class="btn btn-primary btn-sm">
                    Add New User
                </a>
            </div>
        </div>
        <div class="card-body">

            <!-- User Listing Table-->
            <div class="table-responsive">
                <table class="table table-striped border" id="users-table">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th>Role</th>
                            <th>Division</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="align-middle">
                                <td class="text-center text-muted">
                                    {{ $user->last_name }}, {{ $user->first_name }}
                                </td>
                                <td class="text-muted text-center">{{ $user->username }}</td>
                                <td class="text-muted">{{ $user->account_type }}</td>
                                <td class="text-muted"><i class="ri-map-pin-line align-bottom"></i> London, UK</td>
                                <td class="text-muted">{{ $user->created_at->format('jS M, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span @class([
                                            'f-w-2 f-h-2  d-block rounded-circle me-1 fs-xs fw-bolder',
                                            'bg-success' => $user->status->value == 1,
                                            'bg-danger' => $user->status->value == 2,
                                        ])></span>
                                        <span class="small text-muted">{{ $user->status->name }}</span>
                                    </div>
                                </td>
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
                $('#users-table').DataTable({});
            });
        </script>
    @endpush
@endsection
