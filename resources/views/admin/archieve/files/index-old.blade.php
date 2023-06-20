@extends('layouts.app-2')
@section('page-title', 'File Manager')
@prepend('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endprepend
@section('content')

    <div class="card mb-4">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0">File Manager</h6>
            <div class="dropdown">
                <a href="{{ route('account.create') }}" class="btn btn-primary btn-sm">
                    New File
                </a>
            </div>
        </div>
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumbs">
                    <li class="breadcrumb-item"><a href="#" class="btn-breadcrumb-click" data-information=''>Home</a>
                    </li>
                </ol>
            </nav>
            <div class="row" id="baseFolderContainer">
                @foreach ($directories as $folder)
                    <div
                        class="card col-lg-2 mb-3 mx-4 shadow-sm cursor-pointer d-flex align-items-center justify-content-center ">
                        <div class="card-header bg-gray justify-content-between align-items-center w-100 d-flex">
                            <h6 class="card-title m-0 fw-medium"></h6>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle dropdown-toggle-icon fw-bold p-0" type="button"
                                    id="actionButton" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="ri-more-2-line"></i>
                                </button>
                                <ul class="dropdown-menu dropdown" aria-labelledby="actionButton"
                                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-165px, 23px);"
                                    data-popper-placement="bottom-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Details</a></li>
                                    {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="card-body btn-folder-clicked d-flex flex-column"
                            data-information="{{ json_encode($folder) }}">
                            <i class="fa-solid fa-folder fa-4x align-self-center shadow text-primary"></i>
                            <small class="mt-2 p-2">
                                <span
                                    class="fw-medium align-self-center text-muted text-uppercase">{{ $folder['basename'] }}</span>
                            </small>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="row" id="baseSubFolderContainer">
            </div>
        </div>

    </div>
    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
            $(function() {
                let isClicked = false;
                const extensionIcons = {
                    'pdf': 'file-pdf text-danger',
                    'xlsx': 'file-excel text-success',
                    'docx': 'file-word',
                    'csv': 'file-csv text-success',
                    'txt': 'file-lines text-dark',
                    'db': 'file-lines text-dark',
                };

                let directories = [{
                    basename: 'Home',
                    path: "C:\\laragon\\www\\TSP_LegislateSys\\storage\\app\\source"
                }];

                const baseSubFolderContainer = $('#baseSubFolderContainer');

                const displayFiles = (details) => {
                    if (!isClicked) {
                        isClicked = true;


                        $.ajax({
                            url: '/files/get',
                            method: 'POST',
                            data: details,
                            success: function(files) {
                                baseSubFolderContainer.empty().hide().fadeIn(300);
                                let entered = false;
                                let fileIndex = -1;


                                directories.map((directory, index) => {
                                    if (directory.path == details.path) {
                                        entered = true;
                                        fileIndex = index;
                                    }
                                });

                                if (fileIndex != -1) {
                                    let newDirectories = [];

                                    directories.forEach((directory, index) => {
                                        if (index < fileIndex) {
                                            newDirectories.push(directory);
                                        }
                                    });

                                    directories = newDirectories;
                                }

                                directories.push(details);

                                $('#breadcrumbs').html(``);
                                directories.forEach((directory) => {
                                    $('#breadcrumbs').append(`
                                        <li class="breadcrumb-item"><a href="#" class="btn-breadcrumb-click" data-information='${JSON.stringify(directory)}'>${directory.basename}</a></li>
                                    `)
                                });

                                $.each(files, function(index, file) {
                                    const cardClass = file.type == 'file' ? '' :
                                        'btn-sub-folder-clicked';
                                    const iconClass =
                                        `fa-${file.type == 'file' ? extensionIcons[file.extension] : 'folder'}`;

                                    baseSubFolderContainer.append(`
                                        <div class="card col-lg-2 mx-4 mb-3 shadow-sm cursor-pointer d-flex align-items-center justify-content-center">
                                            <div class="card-header bg-gray justify-content-between align-items-center w-100 d-flex">
                                                <h6 class="card-title m-0 fw-medium"></h6>
                                                <div class="dropdown">
                                                    <button class="btn btn-link dropdown-toggle dropdown-toggle-icon fw-bold p-0" type="button"
                                                        id="actionButton" data-bs-toggle="dropdown" aria-expanded="true">
                                                        <i class="ri-more-2-line"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown" aria-labelledby="actionButton"
                                                        style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-165px, 23px);"
                                                        data-popper-placement="bottom-end">
                                                        <li><a data-information='${JSON.stringify(file)}' class="dropdown-item btn-view-file text-dark ${file.type == 'file' ? 'show' : 'd-none'}">View</a></li>
                                                        <li class="dropdown-divider ${file.type == 'file' ? 'show' : 'd-none'}"></li>
                                                        <li><a class="dropdown-item text-dark" href="#">Details</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex flex-column ${cardClass}" data-information='${JSON.stringify(file)}'>
                                                <i class="${file.type == 'file' ? 'fa-regular' : 'fa-solid'} text-primary ${iconClass} fa-4x align-self-center shadow "></i>
                                                <small class="mt-2 p-2">
                                                    <span class="fw-medium align-self-center text-muted text-uppercase">${file.basename.replace(`.${file.extension}`, '')}</span>
                                                </small>
                                            </div>
                                        </div>
                                    `);
                                });

                                isClicked = false;
                            },
                            error: function() {},
                        });
                    }
                }

                $('#baseSubFolderContainer').hide();

                $(document).on('click', '.btn-folder-clicked', function() {
                    const details = JSON.parse($(this).attr('data-information'));
                    displayFiles(details);
                    $('#baseFolderContainer').fadeOut(300);
                });

                $(document).on('click', '.btn-sub-folder-clicked', function() {
                    const details = JSON.parse($(this).attr('data-information'));
                    displayFiles(details);
                });

                $(document).on('click', '.btn-breadcrumb-click', function() {
                    const details = $(this).attr('data-information');
                    displayFiles(JSON.parse(details));
                });

                $(document).on('click', '.btn-view-file', function() {
                    let details = JSON.parse($(this).attr('data-information'));
                    socket.emit('VIEW_IN_FILE_MANAGER', details);
                });
            });
        </script>
    @endpush
@endsection
