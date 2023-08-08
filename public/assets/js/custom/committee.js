let token = $("meta[name='token']").content;

$('#filterByContent').val('');
String.prototype.limit = function (limit) {
    let text = this.trim();
    if (text.length > limit) {
        text = text.substring(0, limit).trim() + '...';
    }
    return text;
};

let table = $('#committees-table').DataTable({
    serverSide: true,
    ajax: {
        url: '/api/committee-list/*/*/*/*',
    },
    processing: true,
    language: {
        processing: '<div class="spinner-border text-info" role="status"></div>'
    },
    columns: [
        {
            name: 'name',
            render: (data) => `<span class="mx-2">${data}</span>`,
        },
        {
            className: 'text-center',
            name: 'submitted.fullname',
            searchable: false,
            orderable: false,
            render: (data) => `<span class="mx-2">${data}</span>`,
        },
        {
            name: 'lead_committee',
            searchable: false,
            orderable: false,
            render: (data) => `<span class="mx-2">${data}</span>`,
        },
        {

            name: 'expanded_committee',
            searchable: false,
            orderable: false,
            render: (data) => `<span class="mx-2">${data}</span>`,
        },
        {

            name: 'other_expanded_committee',
            searchable: false,
            orderable: false,
            render: (data) => `<span class="mx-2">${data}</span>`,
        },
        {
            className : 'text-center',
            name: 'schedule',
            searchable: false,
            orderable: false,
        },
        {
            name: 'status',
            className: 'text-center',
            render: function (raw) {
                if (raw == 'review') {
                    return `<span class="badge badge-soft-primary text-uppercase">${raw}</span>`;
                } else if (raw == 'approved') {
                    return `<span class="badge badge-soft-success text-uppercase">${raw}</span>`;
                } else if (raw == 'returned') {
                    return `<span class="badge badge-soft-danger text-uppercase">${raw}</span>`;
                } else {
                    return `<span class="badge badge-soft-warning text-uppercase">${raw}</span>`;
                }
            }
        },
        {
            className: 'text-center',
            name: 'created_at',
        },
        {
            name: 'action',
            orderable: false,
            searchable: false,
        },
    ],
});

let searchTimeout;
const searchInput = $('#committees-table_filter input');
const delay = 300;

searchInput.off().on('keyup', function () {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        table.search($(this).val()).draw();
    }, delay);
});
$('#filterLeadCommitee').change(function () {
    let lead = $('#filterLeadCommitee').val();
    let expanded = $('#filterExpandedCommittee').val();
    let session = $('#availableSession').val();
    table.ajax.url(`/api/committee-list/${lead}/${expanded}/*/${session}`).load(null, false);
});
$('#filterExpandedCommittee').change(function () {
    let lead = $('#filterLeadCommitee').val();
    let expanded = $('#filterExpandedCommittee').val();
    let session = $('#availableSession').val();
    table.ajax.url(`/api/committee-list/${lead}/${expanded}/*/${session}`).load(null, false);
});

$('#availableSession').change(function () {
    let lead = $('#filterLeadCommitee').val();
    let expanded = $('#filterExpandedCommittee').val();
    table.ajax.url(`/api/committee-list/${lead}/${expanded}/*/${this.value}`).load(null, false);
});

$('#filterByContent').keyup(function (e) {
    if (e.keyCode == 13) {
        let lead = $('#filterLeadCommitee').val();
        let expanded = $('#filterExpandedCommittee').val();
        let content = $(this).val();
        if (content == '') {
            table.ajax.url(`/api/committee-list/${lead}/${expanded}/*/*`).load(null, false);
        } else {
            $.ajax({
                url: 'http://localhost:3030/api/committee-content/search',
                method: 'POST',
                data: {
                    key: content,
                    page: 1,
                },
                success: function (response) {
                    let ids = response.committees.map((committee) => committee.id);
                    if (ids.length === 0) {
                        table.ajax.url(`/api/committee-list/-1/-1/*/*`).load(null, false);
                    } else {
                        table.ajax.url(`/api/committee-list/${lead}/${expanded}/${ids.join(',') || '*'}/*`).load(null, false);
                    }
                }
            });
        }

    }

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
        <picture class="user-avatar user-avatar-group">
            <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.chairman_information.profile_picture}" >
        </picture>
    `);

    $('#pictures').prepend(`
        <picture class="user-avatar user-avatar-group">
            <img class="thumb-lg rounded-circle" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" alt="${agenda.vice_chairman_information.fullname}">
        </picture>
    `);

    if (agenda.members) {
        $('#leadCommitteeContent').html(``);

        $('#leadCommitteeContent').prepend(`
            <div class="card mb-3">
                    <div class="card-body fw-medium">
                        <div class="user-avatar">
                            <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.vice_chairman_information.profile_picture}" alt="${agenda.vice_chairman_information.fullname}">
                        </div>
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
                        <div class="user-avatar">
                            <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${agenda.chairman_information.profile_picture}" alt="${agenda.chairman_information.fullname}">
                        </div>
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
            <picture class="user-avatar user-avatar-group">
                <img class="thumb-lg rounded-circle img-fluid" src="/storage/user-images/${memberInformation.profile_picture}" alt="${memberInformation.fullname}">
            </picture>
        `);


            $('#leadCommitteeContent').append(`
                <div class="card mb-3">
                    <div class="card-body fw-medium">
                        <div class="user-avatar">
                            <img class="thumb-lg rounded-circle" src="/storage/user-images/${memberInformation.profile_picture}" alt="${memberInformation.fullname}">
                        </div>
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
document.addEventListener('click', event => {
    if (event.target.matches('.btn-edit')) {
        const id = event.target.getAttribute('data-id');
        fetch(`/committee-file/${id}/edit`)
            .then(response => response.json())
            .then(data => socket.emit('EDIT_FILE', data))
            .catch(error => console.error(error));
    }

    if (event.target.matches('.view-lead-committees')) {
        const agenda = event.target.getAttribute('data-lead-committee');
        fetch(`/api/agenda-members/${agenda}`)
            .then(response => response.json())
            .then(data => loadCanvasContent(data))
            .catch(error => console.error(error));
    }

    if (event.target.matches('.view-expanded-comittees')) {
        const agenda = event.target.getAttribute('data-expanded-committee');
        fetch(`/api/agenda-members/${agenda}`)
            .then(response => response.json())
            .then(data => loadCanvasContent(data))
            .catch(error => console.error(error));
    }

    if(event.target.matches('.view-schedule-information')) {
        const schedule = event.target.getAttribute('data-id');
        let endpoint = route('committee-schedule-information.show', schedule);
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                let { schedule } = data;
                $('#scheduleInformationContent').html(``);
                $('#scheduleInformationContent').append(`
                    <div class="list-group">
                        <div class="list-group-item align-middle">
                            <strong>Name</strong> : ${schedule.name}
                        </div>

                        <div class="list-group-item align-middle">
                            <strong>Description</strong> : ${schedule.description}
                        </div>

                        <div class="list-group-item align-middle">
                            <strong>Date & Time</strong> : ${moment(schedule.date_and_time).format('MMMM Do YYYY')}
                        </div>

                        <div class="list-group-item align-middle">
                            <strong>Venue</strong> : ${schedule.venue}
                        </div>

                        <div class="list-group-item align-middle">
                            <strong>With Guest</strong> : ${schedule.with_invited_guest == 1 ? "Yes" : "No"}
                        </div>
                    </div>
                `);
            })
            .catch(error => console.error(error));
    }
});
