<div class="dropdown" data-id="{{ $boardSession->id }}" data-submitted-by="{{ $boardSession?->submitted_by }}" data-file-path="{{ $boardSession->file_path }}">
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
        <li class="cursor-pointer btn-view-file" data-readonly="true" data-path="{{ $boardSession->file_path }}"><a href="#" class="dropdown-item">View File</a>
        </li>
    </ul>
</div>
