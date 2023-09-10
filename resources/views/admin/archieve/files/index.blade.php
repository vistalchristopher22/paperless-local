@extends('layouts.app-2')
@section('page-title', 'File Manager')
@prepend('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css"
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" crossorigin="anonymous">
    </script>
    <style>
        .context-menu {
            background-color: #fff;
            border: 1px solid #dadce0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
            padding: 0;
            position: absolute;
            z-index: 1000;
            animation: slide-down 0.15s ease-out forwards;
            font-size: 14px;
            min-width: 170px;
            opacity: 0;
            transform: translateY(-10px);
        }

        .context-menu::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            margin-left: -8px;
            border-style: solid;
            border-width: 0 8px 8px 8px;
            border-color: transparent transparent #dadce0 transparent;
        }

        .context-menu div {
            cursor: pointer;
            padding: 10px 15px;
            transition: background-color 0.1s ease-in-out;
        }

        .context-menu div:hover {
            background-color: #f1f1f1;
        }

        .context-menu hr {
            border: none;
            border-top: 1px solid #dadce0;
            margin: 5px 0;
        }

        @keyframes slide-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Customize the appearance of Dropzone */
        .dropzone {
            border-color: transparent;
            padding: 0px;
        }

        /* Style the message that appears when there are no files */
        .dropzone .dz-message {
            text-align: center;
            margin: 0;
        }

        /* Style the file preview */
        .dropzone .dz-preview {
            display: none;
        }

        /* Style the file thumbnail */
        .dropzone .dz-preview .dz-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Style the file name and size */
        .dropzone .dz-preview .dz-details {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            text-align: left;
        }

        /* Style the delete button */
        .dropzone .dz-preview .dz-remove {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 20px;
            color: #ccc;
            cursor: pointer;
        }

        .dz-preview {
            display: none;
        }

        .dz-preview .dz-error-message {
            display: none;
        }

        * {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        img {
            -webkit-user-drag: none;
            user-drag: none;
        }
    </style>
@endprepend
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb" id="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter" id="listBreadcrumb">
                        </ol>
                    </nav>
                </div>
                <!-- End Col -->


                <div class="col-sm-auto" aria-label="Button group">
                    <!-- Button Group -->
                    <div class="button-items">
                        <button class="btn btn-dark" id="btnSearch">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            Search
                        </button>
                        <button type="button" id="buttonFilter" class="btn btn-dark dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-funnel" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                                </svg>
                                File Type
                            </span>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item filter-file-type" data-type="*" href="#">
                                All Files
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item filter-file-type" data-type="word_file" href="#">
                                Documents
                            </a>
                            <button class="dropdown-item filter-file-type" data-type="excel_file" href="#">
                                Spreadsheets
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="powerpoint_file">
                                Presentations
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="pictures_file">
                                Photos & images
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="pdf_file">
                                PDFs
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="video_file">
                                Videos
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="folder">
                                Folders
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="shortcut_file">
                                Shortcuts
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="audio_file">
                                Audio
                            </button>
                            <button class="dropdown-item filter-file-type" data-type="archives_file">
                                Archives
                            </button>
                        </div>
                    </div>
                    <!-- End Button Group -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <h2 class="h4 mb-3"></h2>
        <div id="searchContainer" class="d-none">
            <label for="searchField" class="form-label text-dark fw-bolder">Search</label>
            <input id="searchField" type="text" class="form-control form-control-lg mb-3 border-dark">
        </div>
        <!-- Folders -->
        <div id="directories">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
            </div>
        </div>
        <!-- End Folders -->

        <div class="progress rounded-0"
            style="position:fixed; bottom :0%; z-index:9999999; right:0%; left:0%; background :white;">
            <div class="progress-bar rounded-0" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>

        <div id="files" class="dropzone">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h4 mb-0">Files</h2>
                </div>
            </div>
            <!-- End Header -->

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5" id="file-list">
            </div>
        </div>


        <div class="offcanvas offcanvas-end" style="width : 450px;" tabindex="-1" id="detailsOffcanvas">
            <div class="offcanvas-header">
                <h6 class="offcanvas-title text-white card-title">Details</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body"></div>
        </div>

        <div class="modal fade" tabindex="-1" id="viewLink">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title card-title h6">View Link</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: hidden">
                        <label for="viewLinkText" class="form-label">Link for viewing</label>
                        <input id="viewLinkText" class="fw-bold form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="previewModal">
            <div class="modal-dialog modal-xl modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title card-title h6">Preview</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 m-0">
                        <iframe src="" frameborder="0" width="100%" height="110%"
                            style="position:absolute; top :-6%;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="renameModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Rename File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="currentDirectory">Directory</label>
                            <input type="text" class="form-control" id="currentDirectory" name="currentDirectory"
                                value="" required readonly>
                            <div class="invalid-feedback">
                                Please enter a valid file name.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="currentFileName">Current File Name</label>
                            <input type="text" class="form-control" id="currentFileName" name="currentFileName"
                                value="" required readonly>
                            <div class="invalid-feedback">
                                Please enter a valid file name.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newFileName">New File Name</label>
                            <input type="text" class="form-control" id="newFileName" name="newFileName"
                                value="" required>
                            <div class="invalid-feedback">
                                Please enter a valid file name.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnRename">Rename</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
        <script>
            let applicationType = document
                .querySelector('meta[name="application-type"]')
                .getAttribute("content");

            let networkFolder = document
                .querySelector('meta[name="network-folder"]')
                .getAttribute("content");

            let sourceFolder = document
                .querySelector('meta[name="source-folder"]')
                .getAttribute("content");
        </script>
        <script>
            $('#btnSearch').click(function() {
                if ($("#searchContainer").hasClass('remove') || $('#searchContainer').hasClass('d-none')) {
                    $("#searchContainer").fadeIn(300).removeClass('remove').removeClass('d-none').trigger('click');
                } else {
                    $("#searchContainer").fadeOut(300).addClass('remove');
                    $('#searchField').val('');
                }
            });
        </script>
        <script>
            let currentContextMenu = null;
            let currentOffcanvas = null;
            let selectedCard = null;
            let isCtrlPressed = false;
            let isShiftPressed = false;
            let lastCheckedCard = $('#files .card:first-child');
            let selectedFiles = {};


            $('#files').on('contextmenu', '.card', function(event) {
                event.preventDefault();

                if (currentContextMenu) {
                    currentContextMenu.remove();
                }

                const card = $(event.target).closest('.card');

                const fileId = card.data('file-id');

                const contextMenu = $('<div class="context-menu"></div>');

                const detailsOption = $(`<div>
                    <i class="mdi mdi-file-document-outline "></i> Details
                </div>`);
                detailsOption.on('click', function() {
                    let directory = card.find('.file-name').attr('data-path');
                    let fileName = card.find(`.file-name`).text();
                    $.ajax({
                        url: route('file.show'),
                        method: 'POST',
                        data: {
                            path: fileName,
                            directory: directory,
                        },
                        success: function(response) {
                            let data = response;

                            let html = $('<div class="row mb-3">');
                            html.append($('<div class="col-12">'));

                            let listGroup = $('<ul class="list-group">');

                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Type:</strong> ' + data.type));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Size:</strong> ' + data.size));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Inode:</strong> ' + data.inode));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Permission:</strong> ' + data.perms));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Access time:</strong> ' + data.atime));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Modified time:</strong> ' + data.mtime));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Creation time:</strong> ' + data.ctime));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Link count:</strong> ' + data.link_count));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Symlink:</strong> ' + data.symlink));
                            listGroup.append($('<li class="list-group-item">').html(
                                '<strong>Directory:</strong> ' + data.directory));

                            html.find('.col-12').append(listGroup);

                            html.append($('<div class="row">'));
                            let fileActivityRow = $('<div class="row">');
                            fileActivityRow.append($('<div class="col-12">'));

                            html.find('.col-12').append(fileActivityRow);

                            let trackUrl = 'http://localhost:3030/api/backtrack-attachments/pdf';

                            if (response.type === 'docx') {
                                trackUrl = 'http://localhost:3030/api/backtrack-attachments/docx';
                            }

                            $.ajax({
                                url: trackUrl,
                                method: 'POST',
                                data: {
                                    file_path: `${data.directory}/${data.name}`,
                                },
                                success: function(data) {
                                    if (response.type === 'docx') {
                                        data.map((attachment) => {
                                            let {
                                                text,
                                                url
                                            } = attachment;
                                            listGroup.append($(
                                                '<li class="list-group-item">'
                                            ).html(
                                                `<strong>Attachments:</strong> <a class="text-decoration-underline" target="_blank" href="${url}">${text}</a>`
                                            ));
                                        });
                                    } else {
                                        let fileAttachments = data.attachments
                                            .split(
                                                "||").filter((e) => !!e);
                                        fileAttachments.forEach((file) => {
                                            let [text, link] = file.split("|");
                                            listGroup.append($(
                                                '<li class="list-group-item">'
                                            ).html(
                                                '<strong>Attachments:</strong> ' +
                                                text));
                                        });
                                    }
                                    $('.offcanvas-body').html(html);
                                    $('#detailsOffcanvas').offcanvas('show');
                                }
                            });
                        }
                    });

                });
                contextMenu.append(detailsOption);

                const showInExplorerOption = $(`<div>
                    <i class="mdi mdi-folder-outline "></i> Open in explorer
                </div>`);
                showInExplorerOption.on('click', function() {
                    let directory = card.find('.file-name').attr('data-path');
                    let fileName = card.find(`.file-name`).text();
                    if (applicationType) {
                        $.ajax({
                            url: route('file.show-in-explorer'),
                            method: 'POST',
                            data: {
                                directory: directory,
                                name: fileName,
                            },
                            success: function(response) {},
                        });
                    } else {
                        let path = directory.replace(/\\/g, '/').replace(
                            sourceFolder,
                            networkFolder
                        );
                        console.log(`${path}\\${fileName}`)
                        localSocket.emit("SHOW_FILE_IN_EXPLORER", {
                            file_path: `${path}\\${fileName}`
                        });
                    }

                });
                contextMenu.append(showInExplorerOption);

                const inspectLink = $(`<div>
                    <i class="mdi mdi-link"></i> Inspect Link</div>`);
                inspectLink.on('click', function() {
                    let fileName = card.find('.file-name').text();
                    let path = card.find('.file-name').attr('data-path');
                    $.ajax({
                        url: route('file.inspect-link'),
                        method: "POST",
                        data: {
                            fileName,
                            path,
                        },
                        success: function(response) {
                            document.querySelector("#viewLinkText").value = response.view_link;
                            $("#viewLink").modal("toggle");
                        }
                    });
                });
                contextMenu.append(inspectLink);

                const previewOption = $(`<div>
                    <i class="mdi mdi-eye-circle-outline"></i> View
                </div>`);
                previewOption.on('click', function() {
                    let fileName = card.find('.file-name').text();
                    let path = card.find('.file-name').attr('data-path');

                    if (!fileName.includes('.pdf')) {
                        if (applicationType) {
                            socket.emit('PREVIEW_DOC_FILE', {
                                file_path: `${path}\\${fileName}`,
                            });
                        } else {
                            path = path.replace(/\\/g, '/').replace(
                                sourceFolder,
                                networkFolder
                            );
                            localSocket.emit("PREVIEW_DOC_FILE", {
                                file_path: `${path}\\${fileName}`
                            });
                        }

                    } else {
                        $.ajax({
                            url: route('file.preview'),
                            method: 'POST',
                            data: {
                                fileName,
                                path,
                            },
                            success: function(response) {
                                $('#previewModal iframe').attr('src', response.destination);
                                $('#previewModal').modal('show');
                            }
                        });
                    }


                });
                contextMenu.append(previewOption);

                const downloadOption = $(`<div>
                    <i class="mdi mdi-download-outline"></i> Download
                </div>`);
                downloadOption.on('click', function() {
                    let fileName = card.find(`.file-name`).text();
                    let directory = card.find('.file-name').attr('data-path');
                    alert(fileName, directory);
                });
                contextMenu.append(downloadOption);

                const renameOption = $(`<div>
                    <i class="mdi mdi-pencil-outline"></i> Rename
                </div>`);
                renameOption.on('click', function() {
                    $('#currentDirectory').val(card.find('.file-name').attr('data-path'));
                    $('#currentFileName').val(card.find(`.file-name`).text());
                    selectedCard = card;
                    $('#renameModal').modal('show');
                });
                contextMenu.append(renameOption);
                contextMenu.append(`<hr>`)

                const deleteOption = $(`<div>
                    <i class="mdi mdi-trash-can-outline"></i> Remove
                </div>`);
                deleteOption.on('click', function() {
                    let directory = card.find('.file-name').attr('data-path');
                    let fileName = card.find(`.file-name`).text();
                    if (_.isObject(selectedFiles) && _.size(selectedFiles) !== 0) {
                        alertify.confirm(
                            'This action will delete all the selected files. Are you sure you want to proceed?',
                            function() {
                                $.ajax({
                                    url: route('file.delete.bulk'),
                                    method: 'DELETE',
                                    data: selectedFiles,
                                    success: function(response) {
                                        notyf.success(response.message);
                                        _.every(selectedFiles, (file) => $(
                                                `[data-index=${file.index}]`).parent()
                                            .remove());
                                        selectedFiles = {};
                                    }
                                });
                            }).set({
                            title: 'Delete Multiple File'
                        });
                    } else {
                        alertify.confirm('This action will delete the file. Are you sure you want to proceed?',
                            function() {
                                $.ajax({
                                    url: route('file.delete'),
                                    method: 'DELETE',
                                    data: {
                                        path: fileName,
                                        directory: directory,
                                    },
                                    success: function(response) {
                                        notyf.success(response.message);
                                        card.parent().remove();
                                    }
                                });
                            }).set({
                            title: 'Delete/Remove File'
                        });
                    }

                });
                contextMenu.append(deleteOption);

                contextMenu.css({
                    left: event.pageX + 'px',
                    top: event.pageY + 'px',
                    position: 'absolute'
                });

                // Add the context menu to the page
                $('body').append(contextMenu);

                // Set the current context menu to the new one
                currentContextMenu = contextMenu;

                // Add a click event listener to the document to close the context menu
                $(document).on('click', function() {
                    contextMenu.remove();
                    currentContextMenu = null;
                });
            });

            $(document).on('keydown keyup', function(event) {
                isCtrlPressed = event.ctrlKey;
                isShiftPressed = event.shiftKey;
            });

            $('#files').on('click', '.card', function(event) {
                let card = $(this);
                let isChecked = Boolean(card.attr('is-checked'));
                let fileName = card.find('.file-name').text();
                let directory = card.find('.file-name').attr('data-path');
                let clickedIndex = parseInt(card.attr('data-index'));

                if (isCtrlPressed) {
                    if (isChecked) {
                        card.removeClass('bg-dark').removeClass('text-white').removeAttr('is-checked');
                        card.find('.file-name').removeClass('text-white');
                        delete selectedFiles[fileName];
                    } else {
                        card.find('.file-name').addClass('text-white');
                        card.addClass('bg-dark').addClass('text-white').attr('is-checked', true);
                        selectedFiles[fileName] = {
                            index: clickedIndex,
                            name: fileName,
                            directory: directory,
                        };
                    }
                } else if (isShiftPressed) {
                    let lastIndex = parseInt(lastCheckedCard.attr('data-index'));

                    let $card = $(`[data-index="${clickedIndex}"]`);
                    $card.find('.file-name').addClass('text-white');
                    $card.addClass('bg-dark').addClass('text-white').attr('is-checked', true);
                    selectedFiles[fileName] = {
                        name: fileName,
                        directory: directory,
                        index: clickedIndex,
                    };

                    if (clickedIndex !== lastIndex) {
                        let startIndex = Math.min(clickedIndex, lastIndex);
                        let endIndex = Math.max(clickedIndex, lastIndex);

                        for (let i = startIndex; i <= endIndex; i++) {
                            let $card = $(`[data-index="${i}"]`);
                            let isChecked = Boolean($card.attr('is-checked'));

                            if (!isChecked) {
                                $card.find('.file-name').addClass('text-white');
                                $card.addClass('bg-dark').addClass('text-white').attr('is-checked', true);
                                let file = $card.find('.file-name').text();
                                let dir = $card.find('.file-name').attr('data-path');
                                selectedFiles[file] = {
                                    name: file,
                                    directory: directory,
                                    index: i,
                                };
                            }
                        }
                    }
                    lastCheckedCard = card;
                }
            });

            $(document).on('click', '.new-upload-file', function() {
                let card = $(this);
                let isChecked = Boolean(card.attr('is-checked'));
                let fileName = card.find('.file-name').text();
                let directory = card.find('.file-name').attr('data-path');
                let clickedIndex = parseInt(card.attr('data-index'));

                if (isCtrlPressed) {
                    if (isChecked) {
                        card.removeClass('bg-dark').removeClass('text-white').removeAttr('is-checked');
                        card.find('.file-name').removeClass('text-white');
                        delete selectedFiles[fileName];
                    } else {
                        card.find('.file-name').addClass('text-white');
                        card.addClass('bg-dark').addClass('text-white').attr('is-checked', true);
                        selectedFiles[fileName] = {
                            index: clickedIndex,
                            name: fileName,
                            directory: directory,
                        };
                    }
                } else if (isShiftPressed) {
                    let lastIndex = parseInt(lastCheckedCard.attr('data-index'));

                    let $card = $(`[data-index="${clickedIndex}"]`);
                    $card.find('.file-name').addClass('text-white');
                    $card.addClass('bg-dark').addClass('text-white').attr('is-checked', true);
                    selectedFiles[fileName] = {
                        name: fileName,
                        directory: directory,
                        index: clickedIndex,
                    };

                    if (clickedIndex !== lastIndex) {
                        let startIndex = Math.min(clickedIndex, lastIndex);
                        let endIndex = Math.max(clickedIndex, lastIndex);

                        for (let i = startIndex; i <= endIndex; i++) {
                            let $card = $(`[data-index="${i}"]`);
                            let isChecked = Boolean($card.attr('is-checked'));

                            if (!isChecked) {
                                $card.find('.file-name').addClass('text-white');
                                $card.addClass('bg-dark').addClass('text-white').attr('is-checked', true);
                                let file = $card.find('.file-name').text();
                                let dir = $card.find('.file-name').attr('data-path');
                                selectedFiles[file] = {
                                    name: file,
                                    directory: directory,
                                    index: i,
                                };
                            }
                        }
                    }
                    lastCheckedCard = card;
                }
            });


            $('#btnRename').click(function() {
                $.ajax({
                    url: route('file.update'),
                    method: 'POST',
                    data: {
                        newName: $('#newFileName').val(),
                        oldName: $('#currentFileName').val(),
                        directory: $('#currentDirectory').val(),
                    },
                    success: function(response) {
                        selectedCard.find('.file-name').text($('#newFileName').val());
                        $('#renameModal').modal('toggle');
                        notyf.success(response.message);
                    },
                    error: function(response) {
                        notyf.error(response.responseJSON.message);
                    }
                })
            });
        </script>
        <script>
            function formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        </script>
        <script>
            $(document).ready(function() {
                let breadCrumbTrack = ['Home'];
                let currentPath = "C:\\laragon\\www\\paperless\\storage\\app\\source";
                let directoriesTrack = [currentPath];

                loadFilesAndDirectories(currentPath);

                $('#breadcrumb').on('click', 'a', function(e) {
                    e.preventDefault();
                    let path = $(this).data('path');
                    loadFilesAndDirectories(path);
                });

                $('#directories').on('dblclick', '.col[data-path]', function(e) {
                    e.preventDefault();
                    let path = $(this).data('path');
                    loadFilesAndDirectories(path);
                });

                function updateBreadcrumbNavigation() {
                    let breadcrumb = $('#breadcrumb');
                    breadcrumb.empty().addClass('breadcrumb');
                    for (let i = 0; i < breadCrumbTrack.length; i++) {
                        let listItem = $('<li>').addClass('breadcrumb-item breadcrumb-custom');
                        if (i === breadCrumbTrack.length - 1) {
                            listItem.addClass('active').text(breadCrumbTrack[i]);
                        } else {
                            let item = $('<a>').attr('href', '#').attr('data-path', directoriesTrack[i]).text(
                                breadCrumbTrack[i]);
                            listItem.append(item);
                        }
                        breadcrumb.append(listItem);
                    }
                }

                function loadFilesAndDirectories(path) {
                    $('#files').html('');
                    $('#directories').html(
                        '<div class="text-center"><div class="spinner-border spinner-border-custom-2 text-primary" role="status"></div></div>'
                    );

                    $.ajax({
                        url: route('file.list'),
                        type: 'GET',
                        data: {
                            path: path
                        },
                        success: function(data) {
                            if (path !== currentPath) {
                                var currentPathIndex = directoriesTrack.indexOf(path);
                                if (currentPathIndex === -1) {
                                    breadCrumbTrack.push(data.currentDirectory);
                                    directoriesTrack.push(path);
                                } else {
                                    breadCrumbTrack = breadCrumbTrack.slice(0, currentPathIndex + 1);
                                    directoriesTrack = directoriesTrack.slice(0, currentPathIndex + 1);
                                }
                            } else {
                                breadCrumbTrack = ['Home'];
                                directoriesTrack = [currentPath];
                            }
                            updateBreadcrumbNavigation();

                            var directories = data.directories;
                            var $directoryRow = $('<div>').addClass(
                                'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5');
                            for (var i = 0; i < directories.length; i++) {
                                var directory = directories[i];
                                var numFiles = directory.files.length;
                                var numFolders = directory.directories.length;
                                var fileStr = numFiles == 1 ? 'file' : 'files';
                                var folderStr = numFolders == 1 ? 'folder' : 'folders';
                                if (numFiles > 0 || numFolders > 0) {
                                    var $col = $('<div>').addClass('col mb-3 mb-lg-5')
                                        .attr('data-path', directory.path);
                                    var $card = $('<div>').addClass(
                                        'card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer'
                                    );
                                    var $cardBody = $('<div>').addClass(
                                        'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                                    );
                                    var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                                        '/assets-2/images/widgets/folder-icon.svg').attr('alt',
                                        'Folder Icon');
                                    var $details = $('<div>').addClass('mt-3');
                                    var $title = $('<h6>').addClass('').text(directory.basename);
                                    var $date = $('<p>').addClass('small').text('Last Modified: ' +
                                        new Date(directory.mTime * 1000).toLocaleString());
                                    var $count = $('<p>').addClass('small').text(numFiles + ' ' + fileStr +
                                        ', ' + numFolders + ' ' + folderStr);
                                    $cardBody.append($img);
                                    $details.append($title).append($date).append($count);
                                    $card.append($cardBody).append($details);
                                    $col.append($card);
                                    $directoryRow.append($col);
                                }
                            }

                            $('#directories').empty().append($directoryRow);

                            var files = data.files;
                            var $fileRow = $('<div>').addClass(
                                'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5');
                            $fileRow.attr('id', 'file-list')
                            for (var j = 0; j < files.length; j++) {
                                var file = files[j];
                                var $col = $('<div>').addClass('col mb-3 mb-lg-5');

                                var $card = $('<div>').addClass(
                                    'card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer'
                                );

                                $card.attr('data-index', j);

                                var $cardBody = $('<div>').addClass(
                                    'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                                );

                                var img = null;
                                if (file.basename.includes('.pdf')) {
                                    var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                                        '/assets-2/images/widgets/pdf-icon.svg').attr('alt',
                                        'File Icon');
                                } else if (file.basename.includes('.xlsx') || file.basename.includes(
                                        '.xls')) {
                                    var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                                        '/assets-2/images/widgets/google-sheets-icon.svg').attr('alt',
                                        'File Icon');
                                } else if (file.basename.includes('.png') || file.basename.includes(
                                        '.jpg') || file.basename.includes('.jpeg') || file.basename
                                    .includes(
                                        '.webp')) {
                                    var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                                        '/assets-2/images/widgets/image-placeholder.svg').attr('alt',
                                        'File Icon');
                                } else if (file.basename.includes('.csv')) {
                                    var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                                        '/assets-2/images/widgets/csv.svg').attr('alt',
                                        'File Icon');
                                } else {
                                    var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                                        '/assets-2/images/widgets/word-icon.svg').attr('alt',
                                        'File Icon');
                                }

                                var $details = $('<div>').addClass('mt-3');
                                var $title = $(`<h6 class="file-name" data-path="${data.path}">`).addClass(
                                    '').text(file.basename);
                                var $date = $('<p>').addClass('small').text('Last Modified: ' + new Date(
                                    file.mTime * 1000).toLocaleString());
                                var $size = $('<p>').addClass('small').text('Size: ' + formatBytes(file
                                    .size));
                                $cardBody.append($img);
                                $details.append($title).append($date).append($size);
                                $card.append($cardBody).append($details);
                                $col.append($card);
                                $fileRow.append($col);
                            }
                            $('#files').empty().append($fileRow);
                        },
                        error: function() {
                            $('#directories').html(
                                '<p class="text-center text-danger">There was an error loading the directories. Please try again.</p>'
                            );
                            $('#files').html(
                                '<p class="text-center text-danger">There was an error loading the files. Please try again.</p>'
                            );
                        }
                    });
                }

                $(document).on('click', '.filter-file-type', function() {
                    let fileType = $(this).attr('data-type');
                    $('#buttonFilter').text($(this).text());

                    let [currentDirectory] = directoriesTrack.slice(-1);

                    if (fileType !== '*') {
                        $.ajax({
                            url: route('file.filter'),
                            method: 'POST',
                            data: {
                                type: fileType,
                                directory: currentDirectory,
                            },
                            success: function(data) {
                                updateBreadcrumbNavigation();
                                let directories = data.directories;
                                let directoryRow = $('<div>').addClass(
                                    'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5');
                                for (let i = 0; i < directories.length; i++) {
                                    let directory = directories[i];
                                    let numFiles = directories[i].files.length;
                                    let numFolders = directories[i].directories.length;
                                    let fileStr = numFiles == 1 ? 'file' : 'files';
                                    let folderStr = numFolders == 1 ? 'folder' : 'folders';
                                    let column = $('<div>').addClass('col mb-3 mb-lg-5')
                                        .attr('data-path', directory.path);
                                    let card = $('<div>').addClass(
                                        'card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer'
                                    );
                                    let cardBody = $('<div>').addClass(
                                        'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                                    );
                                    let folderIcon = $('<img>').addClass('img-fluid w-25').attr(
                                        'src',
                                        '/assets-2/images/widgets/folder-icon.svg').attr('alt',
                                        'Folder Icon');
                                    let details = $('<div>').addClass('mt-3');
                                    let title = $('<h6>').addClass('').text(directory.basename);
                                    let date = $('<p>').addClass('small').text('Last Modified: ' +
                                        new Date(directory.mTime * 1000).toLocaleString());
                                    let count = $('<p>').addClass('small').text(numFiles + ' ' +
                                        fileStr + ', ' + numFolders + ' ' + folderStr);
                                    cardBody.append(folderIcon);
                                    details.append(title).append(date).append(count);
                                    card.append(cardBody).append(details);
                                    column.append(card);
                                    directoryRow.append(column);
                                }

                                $('#directories').empty().append(directoryRow);

                                let files = data.files;
                                let fileRow = $('<div>').addClass(
                                    'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5');
                                fileRow.attr('id', 'file-list')
                                for (let j = 0; j < files.length; j++) {
                                    let file = files[j];
                                    let column = $('<div>').addClass('col mb-3 mb-lg-5');

                                    let card = $('<div>').addClass(
                                        'card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer'
                                    );

                                    card.attr('data-index', j);

                                    let cardBody = $('<div>').addClass(
                                        'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                                    );

                                    let fileIcon = null;

                                    if (file.basename.includes('.pdf')) {
                                        fileIcon = $('<img>').addClass('img-fluid w-25').attr('src',
                                            '/assets-2/images/widgets/pdf-icon.svg').attr('alt',
                                            'File Icon');
                                    } else if (file.basename.includes('.xlsx') || file.basename
                                        .includes(
                                            '.xls')) {
                                        fileIcon = $('<img>').addClass('img-fluid w-25').attr('src',
                                                '/assets-2/images/widgets/google-sheets-icon.svg')
                                            .attr(
                                                'alt',
                                                'File Icon');
                                    } else if (file.basename.includes('.png') || file.basename
                                        .includes(
                                            '.jpg') || file.basename.includes('.jpeg') || file
                                        .basename
                                        .includes(
                                            '.webp')) {
                                        fileIcon = $('<img>').addClass('img-fluid w-25').attr('src',
                                                '/assets-2/images/widgets/image-placeholder.svg')
                                            .attr(
                                                'alt',
                                                'File Icon');
                                    } else if (file.basename.includes('.csv')) {
                                        fileIcon = $('<img>').addClass('img-fluid w-25').attr('src',
                                            '/assets-2/images/widgets/csv.svg').attr('alt',
                                            'File Icon');
                                    } else {
                                        fileIcon = $('<img>').addClass('img-fluid w-25').attr('src',
                                            '/assets-2/images/widgets/word-icon.svg').attr(
                                            'alt',
                                            'File Icon');
                                    }

                                    var details = $('<div>').addClass('mt-3');
                                    var title = $(
                                            `<h6 class="file-name" data-path="${file.directory}">`)
                                        .addClass(
                                            '').text(file.basename);
                                    var date = $('<p>').addClass('small').text('Last Modified: ' +
                                        new Date(
                                            file.mTime * 1000).toLocaleString());
                                    var size = $('<p>').addClass('small').text('Size: ' +
                                        formatBytes(
                                            file
                                            .size));
                                    cardBody.append(fileIcon);
                                    details.append(title).append(date).append(size);
                                    card.append(cardBody).append(details);
                                    column.append(card);
                                    fileRow.append(column);
                                }
                                $('#files').empty().append(fileRow);
                            }
                        });
                    } else {
                        // load all the files within the directory.
                        loadFilesAndDirectories(currentDirectory);
                    }
                });

                $('#searchField').keyup(function(e) {
                    if (e.keyCode === 13) {
                        let currentDirectory = directoriesTrack.slice(-1)[0];
                        let value = $(this).val();
                        $.ajax({
                            url: route('file.search'),
                            method: 'POST',
                            data: {
                                directory: currentDirectory,
                                term: value
                            },
                            success: function(data) {
                                if (value !== '') {
                                    updateBreadcrumbNavigation();
                                    let directories = data.directories;
                                    let directoryRow = $('<div>').addClass(
                                        'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5'
                                    );
                                    for (let i = 0; i < directories.length; i++) {
                                        let directory = directories[i];
                                        let numFiles = directories[i].files.length;
                                        let numFolders = directories[i].directories.length;
                                        let fileStr = numFiles == 1 ? 'file' : 'files';
                                        let folderStr = numFolders == 1 ? 'folder' : 'folders';
                                        let column = $('<div>').addClass('col mb-3 mb-lg-5')
                                            .attr('data-path', directory.path);
                                        let card = $('<div>').addClass(
                                            'card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer'
                                        );
                                        let cardBody = $('<div>').addClass(
                                            'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                                        );
                                        let folderIcon = $('<img>').addClass('img-fluid w-25').attr(
                                            'src',
                                            '/assets-2/images/widgets/folder-icon.svg').attr(
                                            'alt',
                                            'Folder Icon');
                                        let details = $('<div>').addClass('mt-3');
                                        let title = $('<h6>').addClass('').text(directory.basename);
                                        let date = $('<p>').addClass('small').text(
                                            'Last Modified: ' +
                                            new Date(directory.mTime * 1000).toLocaleString());
                                        let count = $('<p>').addClass('small').text(numFiles + ' ' +
                                            fileStr + ', ' + numFolders + ' ' + folderStr);
                                        cardBody.append(folderIcon);
                                        details.append(title).append(date).append(count);
                                        card.append(cardBody).append(details);
                                        column.append(card);
                                        directoryRow.append(column);
                                    }

                                    $('#directories').empty().append(directoryRow);

                                    let files = data.files;
                                    let fileRow = $('<div>').addClass(
                                        'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5'
                                    );
                                    fileRow.attr('id', 'file-list')
                                    for (let j = 0; j < files.length; j++) {
                                        let file = files[j];
                                        let column = $('<div>').addClass('col mb-3 mb-lg-5');

                                        let card = $('<div>').addClass(
                                            'card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer'
                                        );

                                        card.attr('data-index', j);

                                        let cardBody = $('<div>').addClass(
                                            'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                                        );

                                        let fileIcon = null;

                                        if (file.basename.includes('.pdf')) {
                                            fileIcon = $('<img>').addClass('img-fluid w-25').attr(
                                                'src',
                                                '/assets-2/images/widgets/pdf-icon.svg').attr(
                                                'alt',
                                                'File Icon');
                                        } else if (file.basename.includes('.xlsx') || file.basename
                                            .includes(
                                                '.xls')) {
                                            fileIcon = $('<img>').addClass('img-fluid w-25').attr(
                                                    'src',
                                                    '/assets-2/images/widgets/google-sheets-icon.svg'
                                                )
                                                .attr(
                                                    'alt',
                                                    'File Icon');
                                        } else if (file.basename.includes('.png') || file.basename
                                            .includes(
                                                '.jpg') || file.basename.includes('.jpeg') || file
                                            .basename
                                            .includes(
                                                '.webp')) {
                                            fileIcon = $('<img>').addClass('img-fluid w-25').attr(
                                                    'src',
                                                    '/assets-2/images/widgets/image-placeholder.svg'
                                                )
                                                .attr(
                                                    'alt',
                                                    'File Icon');
                                        } else if (file.basename.includes('.csv')) {
                                            fileIcon = $('<img>').addClass('img-fluid w-25').attr(
                                                'src',
                                                '/assets-2/images/widgets/csv.svg').attr('alt',
                                                'File Icon');
                                        } else {
                                            fileIcon = $('<img>').addClass('img-fluid w-25').attr(
                                                'src',
                                                '/assets-2/images/widgets/word-icon.svg').attr(
                                                'File Icon');
                                        }

                                        var details = $('<div>').addClass('mt-3');
                                        var title = $(
                                                `<h6 class="file-name" data-path="${file.path}">`)
                                            .addClass(
                                                '').text(file.basename);
                                        var date = $('<p>').addClass('small').text(
                                            'Last Modified: ' +
                                            new Date(
                                                file.mTime * 1000).toLocaleString());
                                        var size = $('<p>').addClass('small').text('Size: ' +
                                            formatBytes(
                                                file
                                                .size));
                                        cardBody.append(fileIcon);
                                        details.append(title).append(date).append(size);
                                        card.append(cardBody).append(details);
                                        column.append(card);
                                        fileRow.append(column);
                                    }
                                    $('#files').empty().append(fileRow);
                                } else {
                                    loadFilesAndDirectories(currentDirectory);
                                }
                            }
                        });
                    }
                });
            });
        </script>


        <script>
            Dropzone.autoDiscover = false;
            let myDropzone = new Dropzone("#files", {
                url: route('file.store'),
                success: function(file, response) {
                    var progressBar = document.querySelector(".progress-bar");
                    progressBar.style.width = 0 + "%";
                    progressBar.setAttribute("aria-valuenow", 0);

                    var $col = $('<div>').addClass('col mb-3 mb-lg-5');
                    var $card = $('<div>').addClass(
                        'card card-sm card-hover-shadow card-header-borderless h-100 text-center new-upload-file'
                    );

                    // assign data-index by getting the number of cards with .file-name class
                    $card.attr('data-index', $('.file-name').length + 1);

                    var $cardBody = $('<div>').addClass(
                        'card-body bg-light d-flex flex-column align-items-center justify-content-center'
                    );
                    var img = null;
                    if (response.fileName.includes('.pdf')) {
                        var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                            '/assets-2/images/widgets/pdf-icon.svg').attr('alt',
                            'File Icon');
                    } else if (response.fileName.includes('.xlsx') || response.fileName.includes(
                            '.xls')) {
                        var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                            '/assets-2/images/widgets/google-sheets-icon.svg').attr('alt',
                            'File Icon');
                    } else if (response.fileName.includes('.png') || response.fileName.includes('.jpg') || response
                        .fileName.includes('.jpeg') || response.fileName.includes('.webp')) {
                        var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                            '/assets-2/images/widgets/image-placeholder.svg').attr('alt',
                            'File Icon');
                    } else if (response.fileName.includes('.csv')) {
                        var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                            '/assets-2/images/widgets/csv.svg').attr('alt',
                            'File Icon');
                    } else {
                        var $img = $('<img>').addClass('img-fluid w-25').attr('src',
                            '/assets-2/images/widgets/word-icon.svg').attr('alt',
                            'File Icon');
                    }

                    var $details = $('<div>').addClass('mt-3');
                    var $title = $(`<h6 class="file-name" data-path="${response.path}">`).addClass(
                        '').text(response.fileName);
                    var $date = $('<p>').addClass('small').text('Last Modified: ' + new Date(
                        response.mTime * 1000).toLocaleString());
                    var $size = $('<p>').addClass('small').text('Size: ' + formatBytes(file
                        .size));
                    $cardBody.append($img);
                    $details.append($title).append($date).append($size);
                    $card.append($cardBody).append($details);
                    $col.append($card);

                    $('#file-list').append($col);
                },
                error: function(file, message) {
                    // This function is executed when an error occurs during the file upload
                    console.log("Error uploading file:", message);
                }
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                // Update the progress bar when the file upload starts
                var progressBar = document.querySelector(".progress-bar");
                progressBar.style.width = "0%";
                progressBar.setAttribute("aria-valuenow", 0);
            });

            myDropzone.on("uploadprogress", function(file, progress, bytesSent) {
                // Update the progress bar while the file is uploading
                var progressBar = document.querySelector(".progress-bar");
                progressBar.style.width = progress + "%";
                progressBar.setAttribute("aria-valuenow", progress);
            });
        </script>
    @endpush
@endsection
