@extends('layouts.app-2')

@section('tab-title', 'Types')

@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endprepend

@section('content')

    <div class="clearfix"></div>

    <div class="modal fade" tabindex="-1" id="modalType">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark">Create Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formType">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="typeName"
                                placeholder="Enter a type here..">
                            <span class="text-danger error-field"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-md" id="btnSaveType">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-send me-1" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of the venue modal --}}

    <div class="card">
        <div class="card-header bg-dark justify-content-between align-items-center d-flex">
            <h4 class="text-white">Type List</h4>
            <button class="btn btn-light text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalType">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Add New Type
            </button>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table border" id="typeTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@push('page-scripts')
    <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>

    <script>

        $(document).ready(function() {

            let table = $('#typeTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                retrieve: true,
                pagingType: "full_numbers",
                ajax: 'types/list',
                columns: [
                    {
                        className: 'text-center',
                        data: 'name',
                        name: 'name',
                        searchable: true,
                        sortable: false,
                        visible: true
                    },
                    {
                        className: 'text-center',
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data, type, row) {
                            return moment(data).format('dddd - MMMM, D YYYY');
                        },
                        searchable: true,
                        sortable: false,
                        visible: true
                    },
                    {
                        className: 'text-center',
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#btnSaveType').on('click', function() {
                $.ajax({
                    url: route('types.store'),
                    type: 'POST',
                    data: $('#formType').serialize(),
                    success: function(response) {
                        if (response.success) {
                            notyf.success('Successfully added a new type!');
                            $('#modalType').modal('toggle');
                            document.querySelector('#typeName').value = '';
                            table.ajax.reload();
                        }
                    }
                });

            });

        });


    </script>
@endpush

@endsection
