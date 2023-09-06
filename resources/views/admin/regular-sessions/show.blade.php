@extends('layouts.app-2')
@section('tab-title', 'View ' . $referenceSession->number . ' Regular Session')
@prepend('page-css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
          type="text/css"/>
@endprepend
@section('content')
    <div class="modal fade" tabindex="-1" id="previewModal">
        <div class="modal-dialog modal-xl modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title card-title h6">Preview Document</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 m-0" style="overflow-y: hidden">
                    <iframe src="" width="100%" height="110%"
                            style="position:absolute; top :0%;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-light mb-0 shadow-none border-0 rounded-0 p-2 text-center" style="width:8%;">
        <h6 class="fw-bolder h5 text-uppercase text-dark">ORDER OF BUSINESS</h6>
    </div>
    <div class="card mb-0 rounded-0 border mb-2">
        @foreach($referenceSession->scheduleSessions as $boardSession)
            <div class="card-header bg-dark justify-content-between align-items-center d-flex">
                <h6 class="fw-medium h6 text-white card-title">{{ $boardSession->name }}</h6>
            </div>
            <div class="card-body">
                @foreach($boardSession->board_sessions as $session)
                    <div class="card-header bg-light p-3 d-flex flex-row justify-content-between align-items-center">
                        <span class="card-title h6 fw-medium">Ordered Business</span>
                    </div>
                    <div class="p-3">
                        <div class="mb-3">
                            <label for="title" class="form-label">Order Business Title</label>
                            <input type="text" class="form-control" readonly
                                   value="{{ $session->title }}" id="title" title="title"
                                   name="title">
                        </div>

                        <div
                            class="mb-3 d-flex flex-column align-items-start justify-content-center cursor-pointer view-order-business-file"
                            data-file-path="{{ $session->file_path_view }}">
                            <img src="{{ getIconByFileName($session->file_path) }}"
                                 style="width : 150px;"
                                 alt="">
                            <a class="text-primary text-decoration-underline">{{ removeTimestampPrefix(removeFileExtension(basename($session->file_path_view))) }}</a>
                        </div>
                    </div>

                    <div class="p-3 border border-start-0 border-end-0 bg-light">
                        <div class="card-title">Unassigned Business</div>
                    </div>
                    <div class="p-3">
                        <div class="d-none mb-3">
                            <label for="unassigned_title" class="form-label">Unassigned Business Title</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $session->unassigned_title }}"
                                   id="unassigned_title" name="unassigned_title">
                        </div>

                        <div class="mb-3">
                            <label for="unassigned_business_content" class="form-label">Unassigned Business
                                Content</label>
                            <textarea class="form-control" id="unassigned_business_content"
                                      name="unassigned_business_content">{!! $session->unassigned_content !!}</textarea>
                        </div>

                    </div>

                    <div class="p-3 border border-start-0 border-end-0 bg-light">
                        <div class="card-title">Announcements</div>
                    </div>

                    <div class="p-3">
                        <div class="d-none mb-3">
                            <label for="announcement_title" class="form-label">Announcement Title</label>
                            <input type="text" class="form-control"
                                   value="{{ $session->announcement_title }}"
                                   id="announcement_title"
                                   name="announcement_title" placeholder="">

                        </div>
                        <div class="mb-3">
                            <label for="announcement_content" class="form-label">Announcement Content</label>
                            <textarea class="form-control"
                                      id="announcement_content"
                                      name="announcement_content"
                                      rows="3">{{ $session->announcement_content }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <hr class="border border-dashed">

    <div class="alert alert-light mb-0 shadow-none border-0 rounded-0 p-2 text-center" style="width:8%;">
        <h6 class="fw-bolder h5 text-uppercase text-dark">Committees</h6>
    </div>
    @foreach($referenceSession->scheduleCommittees as $scheduleCommittee)
        @foreach($scheduleCommittee->committees as $committee)
            <div class="card mb-0 rounded-0 border mb-2">
                <div class="card-header bg-dark  justify-content-between align-items-center d-flex">
                    <h6 class="fw-medium h6 text-white card-title">{{ Str::remove('Committee on', $committee?->lead_committee_information?->title) }}</h6>
                </div>
                <div class="card-body p-4">
                    @isset($committee->file_map)
                        <div class="row">
                            @php
                                $fileMap = json_decode($committee->file_map, TRUE);
                            @endphp
                            <div class="dd-list">
                                @include('admin.regular-sessions.treeview', ['data' => $fileMap, 'base_directory' => dirname($scheduleCommittee?->committees?->first()->file_path)])
                            </div>
                        </div>
                    @else
                        <div class="dd" style="max-width:  100%;">
                            <div class="dd-item cursor-pointer" data-file-path="{{ $committee->file_path }}">
                                <div class="dd-handle">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ getIconByFileName($committee->file_path) }}"
                                             style="width : 20px;"
                                             alt="" class="mx-1 border">
                                        <span class="fw-medium">
                                                {{ removeTimestampPrefix(removeFileExtension($committee->file)) }}
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        @endforeach
    @endforeach

    @push('page-scripts')
        <script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
        <script>
            $(document).on('click', '.dd-item', function (e) {
                e.stopPropagation();
                let fileName = $(this).attr('data-file-path');
                socket.emit("PREVIEW_DOC_FILE", {
                    file_path : fileName,
                })
            });

            $(document).on('click', '.view-order-business-file', function (e) {
                let filePath = $(this).attr('data-file-path');
                $('#previewModal').find('iframe').attr('src', `${filePath}#zoom=190&toolbar=0`);
                $('#previewModal').modal('show');
            });
        </script>
        <script type="text/javascript"
                src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
        <script>
            new FroalaEditor('textarea', {
                tabSpaces: 10,
            });
        </script>
    @endpush

@endsection
