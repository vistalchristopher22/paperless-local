@extends('layouts.app')
@section('page-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />

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

    <div class="card">
        <div class="card-header justify-content-between align-items-center d-flex">
            Committees
            <a href="{{ route('committee.create') }}" class="btn btn-primary btn-sm">
                Add New Committee
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped border" id="committees-table">
                <thead>
                    <tr>
                        <th class="text-center">Priority Number</th>
                        <th>Name</th>
                        <th>Schedule</th>
                        <th>Lead Committee</th>
                        <th>Expanded Committee</th>
                        <th>File Attached</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($committees as $committee)
                        <tr>
                            <td class="text-center text-dark fw-bold">
                                {{ $committee->priority_number }}
                            </td>
                            <td class="">{{ $committee->name }}</td>
                            <td class="">{{ $committee->session_schedule }}</td>
                            <td class="">
                                <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                    aria-controls="offCanvasCommittee"
                                    data-lead-committee="{{ $committee->lead_committee }}"
                                    class="cursor-pointer view-lead-committees text-primary text-decoration-underline fw-medium">{{ $committee->lead_committee_information->title }}</a>
                            </td>
                            <td class="">
                                <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                    aria-controls="offCanvasCommittee"
                                    data-expanded-committee="{{ $committee->expanded_committee }}"
                                    class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">{{ $committee->expanded_committee_information->title }}</a>
                            </td>
                            <td class="">
                                <a download href="{{ asset('/storage/committees/' . basename($committee->file_path)) }}"
                                    class="text-primary fw-medium text-decoration-underline">
                                    {{ basename($committee->file_path) }}
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                                        <li><button class="dropdown-item">Show</button></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('committee.edit', $committee) }}">Edit</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">View
                                                File</button></li>
                                        <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">Edit
                                                File</button></li>
                                        <li><button class="dropdown-item" href="#">Download File</button></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasCommittee" aria-labelledby="offCanvasCommitteeTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 class="offcanvas-title mb-3" id="offCanvasCommitteeTitle"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar-group me-4" id="pictures">
                        <span class="small fw-bolder ms-2 text-muted text-dark" id="picturesDescription"></span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close text-reset position-absolute top-20 end-5" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
            <div class="overflow-auto py-2">
                <div class="overflow-hidden" id="leadCommitteeContent">
                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/js/custom/committee.js') }}"></script>
    @endpush
@endsection
