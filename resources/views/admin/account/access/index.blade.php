@extends('layouts.app')
@section('page-title', 'User Access Control')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .agenda-access-checkbox:hover {
            transform: scale(1.03);
            transition-duration: 0.3s;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }
    </style>
@endprepend
@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- generate a card for short information about the page process --}}
            <div class="card bg-primary mb-2 text-white">
                <div class="card-body">
                    <i class="fas fa-info-circle fa-1x me-2"></i>
                    Select a user to view the access control of the user or grant access to the user.
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold">Assign Access Control</div>
                <div class="card-body">
                    <label class="fw-bold">User <span class="text-danger fw-bold">*</span></label>
                    <select name="user" id="user" class="form-select">
                        <option value="" selected disabled>Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ Str::ucfirst($user->last_name) }},
                                {{ Str::ucfirst($user->first_name) }}
                                {{ Str::ucfirst($user->middle_name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="row my-1">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header fw-bold d-flex flex-row align-items-center justify-content-between">
                    <span class="">Agendas <span id="totalAccess">(Total Access - 0)</span></span>
                    <button class="btn btn-info text-white shadow" id="btnBulkAction">Checked All</button>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($agendas as $agenda)
                            <li class="p-3 list-group-item d-flex flex-column agenda-access-checkbox cursor-pointer"
                                data-id="{{ $agenda->id }}" style="cursor: pointer;">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input cursor-pointer"
                                        id="agenda-{{ $agenda->id }}">
                                    <label class="form-check-label cursor-pointer" style="user-select:none;"
                                        for="agenda-{{ $agenda->id }}"><span class="fw-bold">{{ $agenda->index }}.</span>
                                        {{ $agenda->title }}</label>
                                    <a class="text-sm text-primary float-end text-primary fw-medium text-decoration-underline cursor-pointer view-lead-committees cursor-pointer text-decoration-underline"
                                        data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                                        aria-controls="offCanvasCommittee"
                                        data-lead-committee="{{ $agenda->id }}">Details</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <button class="btn btn-primary my-3 float-end" id="btnGrantBulkAccess">Grant Bulk Access <span
                            id="numberOfAccess">(0)</span></button>
                </div>
            </div>
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
        <script>
            let newAccessSet = new Set();

            $('select#user').select2({
                placeholder: 'Select user',
                theme: "classic",
            });

            $('#user').change(function() {
                let id = $(this).val();
                $.ajax({
                    url: route('account-access-control.show', id),
                    success: function(response) {
                        newAccessSet.clear();
                        const checkboxes = $('.agenda-access-checkbox input[type="checkbox"]');
                        checkboxes.prop('checked', false);
                        response.access.forEach((access) => {
                            let {
                                agenda
                            } = access;
                            if (agenda) {
                                $(`[data-id="${agenda}"]`).trigger('click');
                            }
                        });
                        let count = $('.agenda-access-checkbox input[type="checkbox"]:checked').length;
                        $('#totalAccess').text(``).text(`(Total Access - ${count})`);
                        $('#numberOfAccess').text(``).text(`(${count})`);
                    },
                });
            });

            const loadCanvasContent = (response) => {
                let chairmanAndViceChairmanCount = 2;
                let {
                    agenda
                } = response;

                $('#offCanvasCommitteeTitle').text(agenda.title);
                $('#picturesDescription').text(`${agenda.members.length + chairmanAndViceChairmanCount} Members`);

                $('#pictures').find('picture').remove();
                $('#pictures').prepend(`
                    <picture class="avatar-group-img">
                        <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.chairman_information.profile_picture}" alt="${agenda.chairman_information.fullname}">
                    </picture>
                `);
                $('#pictures').prepend(`
                    <picture class="avatar-group-img">
                        <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" alt="${agenda.vice_chairman_information.fullname}">
                    </picture>
                `);
                if (agenda.members) {
                    $('#leadCommitteeContent').html(``);

                    $('#leadCommitteeContent').prepend(`
                        <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}"
                                    alt="${agenda.vice_chairman_information.fullname}">
                                    <span>${agenda.vice_chairman_information.fullname}</span>
                                    <br>
                                    <span>${agenda.vice_chairman_information.district}</span>
                                    <br>
                                    <span>${agenda.vice_chairman_information.sanggunian}</span>
                                </div>
                        </div>
                    `);

                    $('#leadCommitteeContent').prepend(`<span class="fw-bold">Vice Chairman</span>`);


                    $('#leadCommitteeContent').prepend(`
                        <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <img class="f-w-10 rounded-circle" src="/storage/user-images/${agenda.chairman_information.profile_picture}"
                                    alt="${agenda.chairman_information.fullname}">
                                    <span>${agenda.chairman_information.fullname}</span>
                                    <br>
                                    <span>${agenda.chairman_information.district}</span>
                                    <br>
                                    <span>${agenda.chairman_information.sanggunian}</span>
                                </div>
                        </div>
                    `);

                    $('#leadCommitteeContent').prepend(`<span class="fw-bold">Chairman</span>`);
                    $('#leadCommitteeContent').append(`<span class="fw-bold">Members</span>`);

                    agenda.members.forEach((member) => {
                        let {
                            sanggunian_member
                        } = member;
                        let [memberInformation] = sanggunian_member;
                        $('#pictures').prepend(`
                            <picture class="avatar-group-img">
                                <img class="f-w-10 rounded-circle" src="/storage/user-images/${memberInformation.profile_picture}"
                                    alt="${memberInformation.fullname}">
                            </picture>
                        `);

                        $('#leadCommitteeContent').append(`
                            <div class="card mb-3">
                                <div class="card-body fw-medium">
                                    <img class="f-w-10 rounded-circle" src="/storage/user-images/${memberInformation.profile_picture}"
                                    alt="${memberInformation.fullname}">
                                    <span class="fw-medium">${memberInformation.fullname}</span>
                                    <br>
                                    <span>${memberInformation.district}</span>
                                    <br>
                                    <span>${memberInformation.sanggunian}</span>
                                </div>
                            </div>
                        `);
                    });
                }
            };

            $('#btnBulkAction').click(function() {
                const checkboxes = $('.agenda-access-checkbox input[type="checkbox"]');
                const checkedCheckboxes = checkboxes.filter(':checked');

                if (checkedCheckboxes.length === 0) {
                    checkboxes.prop('checked', true);
                    $(this).text('Unchecked All').removeClass('btn-primary').addClass('btn-danger').addClass(
                        'text-white').addClass('shadow');
                } else {
                    checkboxes.prop('checked', false);
                    $(this).text('Check All').removeClass('btn-danger').addClass('btn-primary').addClass('shadow');
                }
                let count = $('.agenda-access-checkbox input[type="checkbox"]:checked').length;
                $('#totalAccess').text(``).text(`(Total Access - ${count})`);
                $('#numberOfAccess').text(``).text(`(${count})`);
            });

            $('#btnGrantBulkAccess').click(function() {
                let newAccessArray = Array.from(newAccessSet);
                let user = $('#user').val();

                if (newAccessArray.length === 0 || user === null) {
                    alertify.error(`Please select a user and/or agenda to grant access.`);
                    return;
                }

                alertify.confirm("Are you sure you want to grant access?",
                    function() {
                        $.ajax({
                            url: route('account-access-control.store'),
                            method: 'POST',
                            data: {
                                key: `password`,
                                user: user,
                                agendas: newAccessArray
                            },
                            success: function(response) {
                                if (response.success) {
                                    alertify.success(response.message);

                                    // clear all access set
                                    newAccessSet.clear();
                                }
                            },
                            error: function(response) {
                                if (response.status == 422) {
                                    alertify.error(response.responseJSON.message);
                                }
                            }
                        });
                    });
            });

            $(document).on('click', '.agenda-access-checkbox', function() {
                let id = $(this).attr('data-id');

                let checkbox = $(this).find('input[type="checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));

                if (checkbox.is(':checked')) {
                    newAccessSet.add(id);
                } else {
                    newAccessSet.delete(id);
                }

                let count = $('.agenda-access-checkbox input[type="checkbox"]:checked').length;
                $('#totalAccess').text(``).text(`(Total Access - ${count})`);
                $('#numberOfAccess').text(``).text(`(${count})`);
            });



            document.addEventListener('click', event => {
                if (event.target.matches('.view-lead-committees')) {
                    const agenda = event.target.getAttribute('data-lead-committee');
                    fetch(`/api/agenda-members/${agenda}`)
                        .then(response => response.json())
                        .then(data => loadCanvasContent(data))
                        .catch(error => console.error(error));
                }
            });
        </script>
    @endpush
@endsection
