<div class="dropdown" data-id="{{ $boardSession->id }}" data-file-path="{{ $boardSession->file_path }}">
    <button class="btn btn-dark dropdown-toggle fw-medium" type="button" id="dropdownAction" data-bs-toggle="dropdown"
        aria-expanded="false">
        Actions
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
        </svg>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownAction" style="">
        <li><a href="{{ route('board-sessions.edit', $boardSession->id) }}" class="dropdown-item">Edit Session</a>
        </li>
        <li class="dropdown-divider"></li>
        <li><button class="dropdown-item btn-inspect-link"
                data-view-link="{{ $boardSession?->file_link->view_link }}">Inspect Link</button></li>
        <li>
            <a href="#">
                <span class="text-decoration-none mx-4 fw-medium text-capitalize cursor-pointer btn-view-file"
                    data-path="{{ $boardSession->file_path }}" class="dropdown-item"
                    data-id="{{ $boardSession->id }}">Edit File
                </span>
            </a>
        </li>
        <li><a href="{{ route('board-sessions.show', $boardSession->id) }}" target="_blank" class="dropdown-item">View
                File</a></li>
        <li class="dropdown-divider"></li>
        <li>
            <a data-id="{{ $boardSession->id }}" class="dropdown-item btn-delete-session cursor-pointer text-danger">
                Delete Session
            </a>
        </li>
    </ul>
</div>
