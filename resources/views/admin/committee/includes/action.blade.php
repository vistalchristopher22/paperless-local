<div class="text-center">
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Actions
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
            </svg>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
            <li><a class="dropdown-item" href="{{ route('committee.edit', $committee->id) }}">Edit Committee</a></li>
            <li><button class="dropdown-item btn-inspect-link"
                    data-view-link="{{ $committee?->file_link->view_link }}">Inspect Link</button></li>
            <li class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('committee.invited-guest.create', $committee->id) }}">Add Invited
                    Guest</a></li>
            <li class="dropdown-divider"></li>
            <li><a href="{{ route('committee-file.show', $committee->id) }}" class="dropdown-item" target="_blank">View
                    File</a></li>
            <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">Edit
                    File</button></li>

            <li><a class="dropdown-item" href="{{ route('committee-file.download', $committee->id) }}">Download File</a>
            </li>
            <li class="dropdown-divier"></li>
            <li>
                <form action="{{ route('committee.destroy', $committee->id) }}" method="POST"
                    id="deleteCommitteeForm-{{ $committee->id }}">
                    @method('DELETE')
                    <button type="button" class="dropdown-item text-danger btn-delete-committee" data-id="{{ $committee->id }}">Delete
                        Committee</button>
                </form>
            </li>
        </ul>
    </div>
</div>
