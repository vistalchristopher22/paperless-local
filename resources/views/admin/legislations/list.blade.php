@extends('layouts.app-2')

@section('page-title', 'Legislations')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endprepend

@section('content')
    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0 text-white">Ordinance and Resolution</h6>
            <div class="dropdown">
                <a href="{{ route('legislation.create') }}" class="btn btn-light fw-bold" title="Add New User"
                    data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="mdi mdi-file-plus"></i> Create Resolution
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table border" id="users-table">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-dark text-center fw-medium">Title</th>
                            <th class="text-dark text-center fw-medium">Description</th>
                            <th class="text-dark text-center fw-medium">Type</th>
                            <th class="text-dark text-center fw-medium">Author</th>
                            <th class="text-dark text-center fw-medium">Session Date</th>
                            <th class="text-dark text-center fw-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

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
