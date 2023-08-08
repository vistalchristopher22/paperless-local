@extends('layouts.app-2')
@section('tab-title', 'View ' . $referenceSession->number . ' Regular Session')
@prepend('page-css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
@endprepend
@section('content')

    <div class="card">
        <div class="card-header bg-light justify-content-between align-items-center d-flex">
            <h6 class="fw-medium h6 card-title">Session</h6>
        </div>
        <div class="card-body p-4">
            @foreach($referenceSession->scheduleSessions as $boardSession)
                {{ $boardSession->name }}
            @endforeach
        </div>
    </div>

    <div class="alert alert-light mb-0 shadow-none border-0 rounded-0 p-2 text-center" style="width:8%;">
        <h6 class="fw-bolder h5 text-uppercase text-dark">Committees</h6>
    </div>
    @foreach($referenceSession->scheduleCommittees as $scheduleCommittee)
        @foreach($scheduleCommittee->committees as $committee)
            <div class="card mb-0 rounded-0 border mb-2">
                <div class="card-header bg-light justify-content-between align-items-center d-flex">
                    <h6 class="fw-medium h6 card-title">{{ Str::remove('Committee on', $committee?->lead_committee_information?->title) }}</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        @php
                            $fileMap = json_decode($committee->file_map, TRUE);
                        @endphp
                        <div class="dd-list">
                            @include('admin.regular-sessions.treeview', ['data' => $fileMap])
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    @push('page-scripts')
        <script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
        <script>

            $(document).on('click', '.dd-item', function (e) {
                e.stopPropagation();
                alert(1);
            });
        </script>
    @endpush

@endsection
