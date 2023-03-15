@extends('layouts.app')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
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
    @else
        <div class="card bg-primary text-white mb-3">
            <div class="card-body alert-dismissible fade show" role="alert">
                You can reorder the rows by dragging and dropping them.
            </div>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card border-0 m-0 ">Complete Listing of Agendas</h6>
            <div class="dropdown">
                <a href="{{ route('agendas.create') }}" class="btn btn-primary btn-sm">
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
                            <th class="text-center">Order</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Chairman</th>
                            <th class="text-center">Vice Chairman</th>
                            <th class="text-center">Members</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas as $agenda)
                            <tr class="align-middle draggable" data-id="{{ $agenda->id }}">
                                <td class="text-center">
                                    {{ $agenda->index }}
                                </td>
                                <td class="text-start">
                                    <span class="mx-3">
                                        {{ Str::limit($agenda->title, 50, '...') }}</span>
                                </td>
                                <td class="text-truncate">{{ $agenda->chairman_information->fullname }}</td>
                                <td>{{ $agenda->vice_chairman_information->fullname }}</td>
                                <td class="text-center">
                                    @if ($agenda->members->count() > 0)
                                        <a href="" class="text-primary fw-medium">View
                                            Members</a>
                                    @endif

                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-sm btn-success text-white"
                                        href="{{ route('agendas.edit', $agenda) }}">Edit</a>
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
        <script src="//cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
        <script>
            $(document).ready(function() {

                let table = $('#agendas-table').DataTable({
                    ordering: false,
                    pageLength: 100,
                    rowReorder: {
                        dataSrc: 'id',
                        update: false,
                        selector: 'tr',
                        snapX: 5,
                        scrollX: true
                    },
                });

                table.on('row-reorder', function(e, details, changes) {
                    details.forEach((row, index) => {
                        // Get the first cell of the row
                        let [orderCell] = row.node.children;
                        orderCell.innerText = `${row.newPosition + 1}`;


                        $.ajax({
                            url: '/re-order/agenda',
                            method: 'POST',
                            data: {
                                id: `${row.node.getAttribute('data-id')}`,
                                index: `${row.newPosition + 1}`,
                            },
                        });
                    })
                });
            });
        </script>
    @endpush
@endsection
