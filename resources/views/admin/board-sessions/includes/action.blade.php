<div class="dropdown" data-id="{{ $boardSession->id }}" data-file-path="{{ $boardSession->file_path }}" data-unassigned-file-path="{{ $boardSession->unassigned_business_file_path }}">
    <button class="btn btn-dark dropdown-toggle fw-medium" type="button" id="dropdownAction" data-bs-toggle="dropdown"
            aria-expanded="false">
        Actions
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down"
             viewBox="0 0 16 16">
            <path
                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
        </svg>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownAction" style="">
        <li><a href="{{ route('board-sessions.edit', $boardSession->id) }}" class="dropdown-item">Edit</a></li>
        <li><a href="{{ route('board-sessions.show', $boardSession->id) }}" class="dropdown-item">View</a></li>
        <li class="dropdown-divider"></li>
        <li>
            <a data-id="{{ $boardSession->id }}" class="dropdown-item btn-delete-session cursor-pointer text-danger">
                Delete
            </a>
        </li>
    </ul>
</div>
