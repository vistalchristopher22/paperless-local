@extends('layouts.app-2')
@section('tab-title', 'Operate Regular Session')
@prepend('page-css')
    <link href="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-2/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }

        .nav-pills .nav-link.active {
            background: #1d2c48 !important;
        }
    </style>
@endprepend
@section('content')
    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs p-3 px-2" role="tablist">
                <li class="nav-item">
                    <a id="general-tab-link" class="nav-link" data-bs-toggle="tab" href="#general" role="tab"
                        aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a id="order-of-business-tab-link" class="nav-link mx-3" data-bs-toggle="tab" href="#order-of-business"
                        role="tab" aria-selected="false">Display</a>
                </li>
                <li class="nav-item">
                    <a id="committee-meeting-tab-link" class="nav-link" data-bs-toggle="tab" href="#committee-meeting"
                        role="tab" aria-selected="false">Committee Meeting</a>
                </li>
            </ul>
        </div>
        <div class="card-body">


            <!-- Tab panes -->
            <div class="tab-content">
                <div id="general" class="tab-pane" role="tabpanel">
                    @include('admin.screen-display.includes.general-tab')
                </div>
                <div id="order-of-business" class="tab-pane " role="tabpanel">
                    @include('admin.screen-display.includes.order-of-business-tab')
                </div>
                <div id="committee-meeting" class="tab-pane" role="tabpanel">
                    @include('admin.screen-display.includes.committee-meeting-tab')
                </div>
            </div>
        </div>
    </div>
    @push('page-scripts')
        <script src="{{ asset('/assets-2/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets-2/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="//cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // $('.button-menu-mobile').trigger('click');


            $('select[name="member"]').select2({
                placeholder: 'Select Sanggunian Panlalawigan Member',
            });

            if (localStorage.getItem('tab')) {
                $('#general-tab-link').removeClass('active');
                $('#order-of-business-tab-link').removeClass('active');
                $('#committee-meeting-tab-link').removeClass('active');

                $('#general-tab').removeClass('active');
                $('#order-of-business-tab').removeClass('active');
                $('#committee-meeting-tab').removeClass('active');

                $(`#${localStorage.getItem('tab')}`).addClass('active');
                $(`#${localStorage.getItem('tab').replace('-tab-link', '')}`).addClass('active');
            } else {
                $('#general-tab-link').removeClass('active');
                $('#order-of-business-tab-link').removeClass('active');
                $('#committee-meeting-tab-link').removeClass('active');

                $('#general-tab').removeClass('active');
                $('#order-of-business-tab').removeClass('active');
                $('#committee-meeting-tab').removeClass('active');

                $(`#general`).addClass('active');
                $(`#general-tab-link`).addClass('active');
            }


            let table = $('#screen-display-table').DataTable({
                ordering: false,
                pageLength: 100,
            });

            // each click of tab must save into local storage
            $('.nav-link').on('click', function() {
                let tab = $(this).attr('id');
                localStorage.setItem('tab', tab);
            });

            $(document).on('click', '.btn-play', function() {
                socket.emit("START_TIMER");
                $(this).html('<i class="mdi mdi-pause" style="pointer-events:none;"></i>');
            });

            $(document).on('click', '.btn-stop', function() {
                socket.emit("END_TIMER");
                setTimeout(() => location.reload(), 500);
            });

            $(document).on('click', '.btn-repeat', function() {
                let id = $(this).attr('data-id');
                $.ajax({
                    url: `/api/screen/repeat/${id}`,
                    method: 'PUT',
                    success: function(response) {
                        if (response.success) {
                            socket.emit('TRIGGER_REFRESH');
                            setTimeout(() => location.reload(), 500);
                        }
                    }
                });
            });
            $('#refreshClients').click(function(e) {
                e.preventDefault();
                socket.emit('TRIGGER_REFRESH');
            });

            $('#nextGuest').click(function(e) {
                e.preventDefault();
                socket.emit('TRIGGER_MOVE_TOP');
            });

            $(document).on('click', '.btn-set-current', function(e) {
                e.preventDefault();
                let record = $(this).attr('data-record');
                $.ajax({
                    url: '/api/screen/current',
                    method: 'PUT',
                    data: JSON.parse(record),
                    success: function(response) {
                        socket.emit('TRIGGER_REFRESH');
                        setTimeout(() => location.reload(), 500);
                    },
                });
            });


            $(document).on('click', '.btn-set-next', function(e) {
                e.preventDefault();
                let record = $(this).attr('data-record');
                $.ajax({
                    url: '/api/screen/next',
                    method: 'PUT',
                    data: JSON.parse(record),
                    success: function(response) {
                        socket.emit('TRIGGER_REFRESH');
                        setTimeout(() => location.reload(), 500);
                    },
                });
            });
        </script>
    @endpush
@endsection
