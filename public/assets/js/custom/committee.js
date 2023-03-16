const table = $('#committees-table').DataTable({
    ordering: false,
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
