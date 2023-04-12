@extends('layouts.app')
@section('page-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css"
        integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        .fade-in.show {
            opacity: 1;
        }

        .fade-out {
            opacity: 1;
            transition: opacity 0.8s ease-in-out;

        }

        .fade-out.hide {
            opacity: 0;
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

    <div class="card mb-4 ">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0">Sangguniang Panlalawigan Members</h6>
            <div class="dropdown">
                <a href="{{ route('sanggunian-members.create') }}" class="btn btn-primary btn-sm">
                    Add New Member
                </a>
            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table border" id="members-table">
                    <thead>
                        <tr>
                            <th class="text-center text-dark border">Picture</th>
                            <th class="text-center text-dark border">Fullname</th>
                            <th class="text-center text-dark border">District</th>
                            <th class="text-dark text-center border">Sanggunian</th>
                            <th class="text-dark text-center border">Joined</th>
                            <th class="text-dark text-center border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td class="text-center border">
                                    <a href="{{ asset('storage/user-images/' . $member->profile_picture) }}"
                                        data-lightbox="roadtrip">
                                        <img class="img-fluid rounded-circle"
                                            src="{{ asset('storage/user-images/' . $member->profile_picture) }}"
                                            width="50px">
                                    </a>
                                </td>
                                <td class="text-dark fw-medium border">
                                    <span class="mx-5">
                                        <a href="javascript::void(0)" class="text-decoration-underline btn-view-details"
                                            data-bs-toggle="offcanvas" data-bs-target="#offCanvasAgendas"
                                            aria-controls="offCanvasAgendas" data-name="{{ $member->fullname }}"
                                            data-id="{{ $member->id }}">{{ $member->fullname }}</a>
                                    </span>
                                </td>
                                <td class="text-dark text-center border">{{ $member->district }}</td>
                                <td class="text-dark text-center border">{{ $member->sanggunian }}</td>
                                <td class="text-dark text-center border">{{ $member->created_at->format('jS M, Y h:i A') }}</td>
                                <td class="text-dark text-center border">
                                    <a class="btn btn-sm btn-success text-white" title="Edit User" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-original-title="Edit Sanggunian Member"
                                        href="{{ route('sanggunian-members.edit', $member) }}">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger text-white btn-remove-sanggunian"
                                        data-id="{{ $member->id }}" title="Remove Sanggunian Member"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="Remove Sanggunian Member">
                                        <i class="fa-solid fa-user-xmark"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasAgendas" aria-labelledby="offCanvasAgendasTitle">
        <div class="offcanvas-header position-relative">
            <div class="d-flex flex-column w-100">
                <h5 class="offcanvas-title mb-3" id="offCanvasAgendasTitle">Agendas</h5>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"
            integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#members-table').DataTable({});
                let showDeleteConfirmation = (id) => {
                    alertify.prompt("Please enter your password", "",
                        function(evt, value) {
                            $.ajax({
                                url: route('sanggunian-members.destroy', id),
                                method: 'DELETE',
                                data: {
                                    key: value
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alertify.success(response.message);
                                        setTimeout(() => location.reload(), 5000);
                                    }
                                },
                                error: function(response) {
                                    if (response.status == 422) {
                                        alertify.error(response.responseJSON.message);
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


                $(document).on('click', '.btn-remove-sanggunian', function() {
                    let id = $(this).attr('data-id');
                    showDeleteConfirmation(id);
                });

                $(document).on('click', '.btn-view-details', function() {

                    let id = $(this).attr('data-id');
                    let fullname = $(this).attr('data-name');
                    $('#offCanvasAgendasTitle').text(`${fullname} Agendas`);
                    // display a spinner first in lead commite content
                    $('#leadCommitteeContent').empty();
                    $('#leadCommitteeContent').append(`<div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>`);
                    $.get({
                        url: route('sanggunian-member.agendas.show', id),
                        success: function(response) {
                            let chairman = response.chairman;

                            $('#leadCommitteeContent').empty();

                            $('#leadCommitteeContent').append(
                                `<h5 class="bg-primary text-white p-2 mb-2 shadow rounded text-center">Chairman on agenda</h5>`
                            );
                            // Check if there's a record
                            if (chairman.length == 0) {
                                $('#leadCommitteeContent').append(
                                    `<p class="fw-medium mx-2 text-center d-flex flex-column align-items-center justify-content-center">No record found.</p>`
                                );
                            } else {
                                chairman.forEach((chairman, index) => {
                                    $('#leadCommitteeContent').append(
                                        `<p class="fw-medium mx-2"><span class="fw-bold">${index + 1}.</span> ${chairman.title}</p>`
                                    );
                                });
                            }

                            $('#leadCommitteeContent').append(
                                `<div class="border border-bottom border-primary my-2"></div>`);

                            // vice chairman render
                            let viceChairman = response.vice_chairman;
                            $('#leadCommitteeContent').append(
                                `<h5 class="bg-primary text-white p-2 mb-2 shadow rounded text-center">Vice Chairman on Agenda</h5>`
                            );

                            if (viceChairman.length == 0) {
                                $('#leadCommitteeContent').append(
                                    `<p class="fw-medium mx-2 text-center d-flex flex-column align-items-center justify-content-center">No record found.</p>`
                                );
                            } else {
                                viceChairman.forEach((vice, index) => {
                                    $('#leadCommitteeContent').append(
                                        `<p class="fw-medium mx-2"><span class="fw-bold">${index + 1}.</span> ${vice.title}</p>`
                                    );
                                })
                            }

                            $('#leadCommitteeContent').append(
                                `<div class="border border-bottom border-primary my-2"></div>`);

                            let members = response.member;
                            $('#leadCommitteeContent').append(
                                `<h5 class="bg-primary text-white p-2 mb-2 shadow rounded text-center">Members on Agenda</h5>`
                            );

                            if (members.length == 0) {
                                $('#leadCommitteeContent').append(
                                    `<p class="fw-medium mx-2 text-center d-flex flex-column align-items-center justify-content-center">No record found.</p>`
                                );
                            } else {
                                members.forEach((member, index) => {
                                    $('#leadCommitteeContent').append(
                                        `<p class="fw-medium mx-2"><span class="fw-bold">${index + 1}.</span> ${member.agenda.title}</p>`
                                    );
                                });
                            }

                            $('#leadCommitteeContent').append(
                                `<div class="border border-bottom border-primary my-2"></div>`);
                        },
                    });
                });
            });
        </script>
    @endpush
@endsection
