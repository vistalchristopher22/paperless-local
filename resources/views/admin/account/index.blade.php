@extends('layouts.app')
@section('page-title', 'User Management')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }
    </style>
@endprepend
@section('content')
    @if (session()->has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0">@yield('page-title')</h6>
            <div class="dropdown">
                <a href="{{ route('account.create') }}" class="btn btn-primary">
                    Add New User
                </a>
            </div>
        </div>
        <div class="card-body">

            <!-- User Listing Table-->
            <div class="table-responsive">
                <table class="table border" id="users-table">
                    <thead>
                        <tr>
                            <th class="text-dark border text-center"><small>Name</small></th>
                            <th class="text-dark border text-center"><small>Username</small></th>
                            <th class="text-dark border text-center"><small>Role</small></th>
                            <th class="text-dark border text-center"><small>Division</small></th>
                            <th class="text-dark border text-center"><small>Joined</small></th>
                            <th class="text-dark border text-center"><small>Status</small></th>
                            <th class="text-dark border text-center"><small>Actions</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="align-middle">
                                <td class="text-start text-dark border text-capitalize">
                                    <span class="mx-3"></span>
                                    {{ $user->last_name }}, {{ $user->first_name }}
                                </td>
                                <td class="text-dark border">
                                    <span class="mx-5"></span>
                                    {{ $user->username }}
                                </td>
                                <td class="text-dark border">
                                    <span class="mx-3">{{ $user->account_type }}</span>
                                </td>
                                <td class="text-dark border text-center">{{ $user->division_information->name ?? '-' }}</td>
                                <td class="text-dark border text-center">{{ $user->created_at->format('jS M, Y') }}</td>
                                <td class="border">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span @class([
                                            'f-w-2 f-h-2 d-block rounded-circle me-1 fs-xs fw-bolder',
                                            'bg-success' => $user->status->value == 1,
                                            'bg-danger' => $user->status->value == 2,
                                        ])></span>
                                        <span class="small text-dark">{{ $user->status->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center border">
                                    <a class="btn btn-sm btn-success text-white" title="Edit User" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-original-title="Edit User"
                                        href="{{ route('account.edit', $user) }}">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                    @if (auth()->user()->id != $user->id)
                                        <button class="btn btn-sm btn-danger text-white btn-remove-user"
                                            data-id="{{ $user->id }}" title="Remove User" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-original-title="Remove User">
                                            <i class="fa-solid fa-user-xmark"></i>
                                        </button>
                                    @endif
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

                let showDeleteConfirmation = (id) => {
                    alertify.prompt("Please enter your password", "",
                        function(evt, value) {
                            $.ajax({
                                url: route('account.destroy', id),
                                method: 'DELETE',
                                data: {
                                    password: value
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alertify.success(response.message);
                                        setTimeout(() => location.reload(), 5000);
                                    } else {
                                        alertify.error(response.message);
                                        showDeleteConfirmation(id);
                                    }
                                }
                            });
                        }).set({
                        labels: {
                            ok: 'Proceed',
                            cancel: 'Cancel',
                        }
                    }).setHeader('Confirmation').set('type', 'password');
                }

                $(document).on('click', '.btn-remove-user', function() {
                    let id = $(this).attr('data-id');
                    showDeleteConfirmation(id);
                });
            });
        </script>
    @endpush
@endsection
