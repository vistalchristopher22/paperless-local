@extends('layouts.app-2')

@section('tab-title', 'Types')

@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
          type="text/css"/>
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
                            <span class="text-danger error-field" id="error-field-name"></span>
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

    <div class="modal fade" tabindex="-1" id="editModalType">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark">Edit Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTypeForm">
                    <div class="modal-body">
                        <input type="hidden" id="editTypeID">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="editTypeName"
                                   placeholder="Enter a type here..">
                            <span class="text-danger error-field" id="error-field-edit-name"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-md" id="editBtnSaveType">
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

    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <div class="card-title h6 fw-medium">Types</div>
            <button class="btn btn-dark shadow-lg fw-medium" id="btnAddNewType">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Add New Type
            </button>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="typeTable">
                    <thead>
                    <tr class="bg-light">
                        <th class="p-3 fw-medium text-uppercase">Name</th>
                        <th class="p-3 fw-medium text-uppercase">Date Created</th>
                        <th class="p-3 fw-medium text-uppercase">Action</th>
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

            $(document).ready(function () {

                let table = $('#typeTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    retrieve: true,
                    ordering: false,
                    pagingType: "full_numbers",
                    language: {
                        processing: '<div class="spinner-border text-primary" role="status">' +
                            '<span class="visually-hidden">Loading...</span>' +
                            '</div>'
                    },
                    ajax: 'types/list',
                    columns: [
                        {
                            className: 'text-center text-uppercase',
                            data: 'name',
                            name: 'name',
                            searchable: true,
                            visible: true,
                        },
                        {
                            className: 'text-center',
                            data: 'created_at',
                            name: 'created_at',
                            render: function (data) {
                                return moment(data).format('dddd - MMMM D, YYYY');
                            },
                            searchable: true,
                            sortable: false,
                            visible: true
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action',
                            sortable: false,
                        }
                    ]
                });

                const clearAllErrorFieldsClass = () => {
                    $('input.form-control').removeClass('is-invalid');
                    $('.error-field').each((_, element) => $(element).html(``));
                };

                $('#btnAddNewType').click(function () {
                    clearAllErrorFieldsClass();
                    $('#modalType').modal('toggle');
                });


                $('#btnSaveType').on('click', function () {
                    clearAllErrorFieldsClass();
                    $.ajax({
                        url: route('types.store'),
                        type: 'POST',
                        data: $('#formType').serialize(),
                        success: function (response) {
                            if (response.success) {
                                notyf.success('Successfully added a new type!');
                                $('#modalType').modal('toggle');
                                $('#typeName').val('');
                                table.ajax.reload();
                            }
                        },
                        error: function (error) {
                            let {errors} = error.responseJSON;
                            Object.keys(errors).map((field) => {
                                $(`.error-field-${field}`).html(``);
                                Array.from(errors[field]).forEach((message) => {
                                    $(`#error-field-${field}`).append(`<span>${message}</span>`);
                                    $(`#error-field-${field}`).parent().find('input').addClass('is-invalid')
                                });
                            });
                        }
                    });
                });

                $(document).on('click', '.btn-edit-type', function (e) {
                    e.preventDefault();
                    let {id, name} = JSON.parse($(this).attr('data-content'));
                    clearAllErrorFieldsClass();
                    $('#editTypeID').val(id);
                    $('#editModalType').modal('toggle');
                    $('#editTypeName').val(name);
                });


                $('#editBtnSaveType').click(function () {
                    clearAllErrorFieldsClass();
                    $.ajax({
                        url: route('types.update', $("#editTypeID").val()),
                        type: 'PUT',
                        data: $('#editTypeForm').serialize(),
                        success: function (response) {
                            if (response.success) {
                                notyf.success('Type successfully updated');
                                $('#editModalType').modal('toggle');
                                table.ajax.reload();
                            }
                        },
                        error: function (error) {
                            let {errors} = error.responseJSON;
                            Object.keys(errors).map((field) => {
                                $(`.error-field-${field}`).html(``);
                                Array.from(errors[field]).forEach((message) => {
                                    $(`#error-field-edit-${field}`).append(`<span>${message}</span>`);
                                    $(`#error-field-edit-${field}`).parent().find('input').addClass('is-invalid')
                                });
                            });
                        }
                    });
                });


                $(document).on('click', '.btn-delete-type', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');
                    alertify.confirm('Are you sure you want to perform this action?', () => {
                        $.ajax({
                            url: route('types.destroy', id),
                            method: 'DELETE',
                            success: function (response) {
                                if (response.success) {
                                    notyf.success('Type successfully updated');
                                    table.ajax.reload();
                                }
                            }
                        });
                    }, () => {
                    }).set({
                        labels: {
                            ok: 'Yes',
                            cancel: 'No'
                        }
                    }).setHeader('Confirmation');
                });
            });
        </script>
    @endpush

@endsection
