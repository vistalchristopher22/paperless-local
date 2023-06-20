@extends('layouts.app-2')
@section('page-title', 'User Management')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endprepend
@section('content')
    @if (session()->has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 text-white">Accounts</h6>
            <div class="dropdown">
                <a href="{{ route('account.create') }}" class="btn btn-light fw-bold" title="Add New User"
                    data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="mdi mdi-account-multiple-plus"></i> Add New User
                </a>
            </div>
        </div>
        <div class="card-body">

            <!-- User Listing Table-->
            <div class="table-responsive">
                <table class="table border" id="users-table">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-dark text-center fw-medium">Name</th>
                            <th class="text-dark text-center fw-medium">Username</th>
                            <th class="text-dark text-center fw-medium">Role</th>
                            <th class="text-dark text-center fw-medium">Division</th>
                            <th class="text-dark text-center fw-medium">Joined</th>
                            <th class="text-dark text-center fw-medium">Status</th>
                            <th class="text-dark text-center fw-medium">Actions</th>
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
                                            'f-w-2 f-h-2 d-block badge me-1 fs-xs fw-bolder',
                                            'badge-soft-primary' => $user->status->value == 1,
                                            'badge badge-soft-danger' => $user->status->value == 2,
                                        ])>
                                            {{ $user->status->name }}
                                        </span>

                                    </div>
                                </td>
                                <td class="align-middle text-center border">
                                    <a class="btn btn-success text-white" title="Edit User" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-original-title="Edit User"
                                        href="{{ route('account.edit', $user) }}">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    @if (auth()->user()->id != $user->id)
                                        <button class="btn btn-danger text-white btn-remove-user"
                                            data-id="{{ $user->id }}" title="Remove User" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-original-title="Remove User">
                                            <i class="mdi mdi-account-off-outline"></i>
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
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
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
