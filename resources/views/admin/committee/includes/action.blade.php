<div class="text-center">
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Actions
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-caret-down" viewBox="0 0 16 16">
                <path
                    d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z" />
            </svg>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
            <li><a class="dropdown-item" href="{{ route('committee.edit', $committee->id) }}">Edit Committee</a></li>
            <li><button class="dropdown-item btn-inspect-link" data-view-link="{{ $committee?->file_link->view_link }}">Inspect Link</button></li>
            <li class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('committee.invited-guest', $committee->id) }}">Add Invited Guest</a></li>
            <li class="dropdown-divider"></li>
            <li><a href="{{ route('committee-file.show', $committee->id) }}" class="dropdown-item" target="_blank">View
                    File</a></li>
            <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">Edit
                    File</button></li>

            <li><a class="dropdown-item" href="{{ route('committee-file.download', $committee->id) }}">Download File</a>
            </li>
        </ul>
    </div>
</div>
