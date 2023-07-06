<div class="text-center">
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
            <li><a class="dropdown-item" href="{{ route('committee.edit', $committee->id) }}">Edit Committee</a></li>
            <li class="dropdown-divider"></li>
            <li><a href="{{ route('committee-file.show', $committee->id) }}" class="dropdown-item" target="_blank">View File</a></li>
            <li><button class="dropdown-item btn-edit" data-id="{{ $committee->id }}">Edit
                    File</button></li>
            <li><a class="dropdown-item" download href="/storage/committees/{{ $committee->file }}">Download File</a></li>
        </ul>
    </div>
</div>
