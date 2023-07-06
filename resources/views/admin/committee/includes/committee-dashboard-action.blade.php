<div class="dropdown">
    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
        aria-expanded="false">
        Actions
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
        <li><a class="dropdown-item" href="{{ route('committee.edit', $committee->id) }}">Edit</a></li>
        <li><a class="dropdown-item btn-approve cursor-pointer" data-id="{{ $committee->id }}">Approve</a></li>
        <li><a class="dropdown-item btn-disapprove cursor-pointer" data-id="{{ $committee->id }}">Return</a></li>
        <li class="dropdown-divider"></li>
        <li><a href="{{ route('committee-file.show', $committee->id) }}" target="_blank" class="dropdown-item">Show
                File</a></li>
        <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">Edit
                File</button></li>
        <li><a class="dropdown-item" target="_blank" download
                href="/storage/committees/{{ basename($committee->file_path) }}">Download
                File</a>
        </li>
    </ul>
</div>
