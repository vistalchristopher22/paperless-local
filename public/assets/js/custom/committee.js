$('#filterByContent').val('');
String.prototype.limit = function (limit) {
    let text = this.trim();
    if (text.length > limit) {
        text = text.substring(0, limit).trim() + '...'; 
    }
    return text;
};

let table = $('#committees-table').DataTable({
    order: [[0, "asc"]],
    destroy: true,
    serverSide: true,
    processing: true,
    language: {
        processing: '<span class="sr-only mt-2">&nbsp;</span> '
    },
    ajax: `/committee-list`,
    columns: [
        {
            name: 'name',
            data: 'name',
        },
        {
            name: 'submitted.fullname',
            data: 'submitted.fullname',
        },
        {
            name: 'lead_committee_information.title',
            data: 'lead_committee_information.title',
            render: function (rowData, _, row) {
                return `
                    <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                    aria-controls="offCanvasCommittee"
                    data-expanded-committee="${row.lead_committee}"
                    class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
                        ${rowData.limit(50) || ''}
                    </a>
                `;
            }
        },
        {
            name: 'expanded_committee_information.title',
            data: 'expanded_committee_information.title',
            render: function (rowData, _, row) {
                return `
                    <a data-bs-toggle="offcanvas" data-bs-target="#offCanvasCommittee"
                    aria-controls="offCanvasCommittee"
                    data-expanded-committee="${row.expanded_committee}"
                    class="cursor-pointer text-primary view-expanded-comittees text-decoration-underline fw-medium">
                        ${rowData.limit(50) || ''}
                    </a>
                `;
            },
        },
        {
            name : 'status',
            className : 'text-center',
            data : 'status',
            render : function (raw) {
                if(raw == 'review') {
                    return `<span class="badge badge-soft-primary text-uppercase">${raw}</span>`;
                } else if(raw == 'approved') {
                    return `<span class="badge badge-soft-success text-uppercase">${raw}</span>`;
                } else if(raw == 'returned') {
                    return `<span class="badge badge-soft-danger text-uppercase">${raw}</span>`;
                } else {
                    return `<span class="badge badge-soft-warning text-uppercase">${raw}</span>`;
                }
            }
        },
        {
            className: 'text-center',
            name: 'submitted_at',
            data: 'submitted_at',
        },
        {
            name: 'id',
            data: 'id',
            render: function (id, _, row) {
                return `
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                        <li><a class="dropdown-item"
                                href="${route('committee.edit', id)}">Edit Committee</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="${route('committee-file.show', id)}"
                                class="dropdown-item">View File</a></li>
                        <li><button class="dropdown-item btn-edit" data-id="${id}">Edit
                                File</button></li>
                        <li><a  class="dropdown-item" download href="/storage/committees/${row.file}">Download File</a></li>
                    </ul>
                </div>
                `;
            },
        },
    ],
});



// Add debounce for searching
let searchTimeout;
const searchInput = $('#committees-table_filter input');
const delay = 300; // Set delay time in milliseconds

searchInput.off().on('keyup', function () {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        table.search($(this).val()).draw();
    }, delay);
});

$('#filterLeadCommitee').change(function () {
    let lead = $('#filterLeadCommitee').val();
    let expanded = $('#filterExpandedCommittee').val();
    let content = $('#filterByContent').val();
    table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
});

$('#filterExpandedCommittee').change(function () {
    let lead = $('#filterLeadCommitee').val();
    let expanded = $('#filterExpandedCommittee').val();
    let content = $('#filterByContent').val();
    table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
});

$('#filterByContent').keyup(function (e) {
    if (e.keyCode == 13) {
        let lead = $('#filterLeadCommitee').val();
        let expanded = $('#filterExpandedCommittee').val();
        let content = $(this).val();
        table.ajax.url(`/committee-list/${lead}/${expanded}/${content}`).load(null, false);
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
});
