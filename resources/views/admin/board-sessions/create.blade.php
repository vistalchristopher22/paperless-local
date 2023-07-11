@extends('layouts.app-2')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
          type="text/css"/>
    @endpush
    @section('tab-title', 'New Ordered Business')
    @section('content')
        @if ($errors->any())
            <div class="card mb-2 bg-danger shadow-sm text-white">
                <div class="card-body">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="card mb-2 bg-success shadow-sm text-white">
                <div class="card-body d-flex flex-row justify-content-between align-items-center">
                    {{ Session::get('success') }}
                    <a href="{{ route('board-sessions.index') }}"
                       class="fw-medium text-decoration-underline text-white">Back</a>
                </div>
            </div>
        @endif
        <form action="{{ route('board-sessions.store') }}" id="orderBusinessForm" method="POST"
              enctype="multipart/form-data">

            <div class="card shadow-none mb-5">
                <div class="card-header bg-light p-3 d-flex flex-row justify-content-between align-items-center">
                    <div class="card-title fw-medium">Ordered Business</div>
                </div>

                <div class="card-body p-0 mb-0">
                    <div class="p-3">
                        <div class="mb-3">
                            <label for="title" class="form-label">Order Business Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                   value="{{ old('title') }}" id="title" title="title" name="title"
                                   placeholder="">
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file_path" class="form-label">Order Business Content</label>
                            <input type="file" class="form-control" value="{{ old('file_path') }}" id="file_path"
                                   name="file_path" placeholder="Enter file path">
                            @error('file_path')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="p-3 border border-start-0 border-end-0 bg-light">
                        <div class="card-title">Unassigned Business</div>
                    </div>
                    <div class="p-3">

                        <div class="mb-3">
                            <label for="unassigned_title" class="form-label">Unassigned Business Title</label>
                            <input type="text"
                                   class="form-control {{ $errors->has('unassigned_title') ? 'is-invalid' : '' }}"
                                   value="{{ old('unassigned_title') }}" id="unassigned_title" name="unassigned_title"
                                   placeholder="">
                            @error('unassigned_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file_path" class="form-label">Unassigned Business Content</label>
                            <input type="file" class="form-control" id="unassigned_business"
                                   name="unassigned_business">
                            @error('unassigned_business')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="p-3 border border-start-0 border-end-0 bg-light">
                        <div class="card-title">Announcements</div>
                    </div>

                    <div class="p-3">
                        <div class="mb-3">
                            <label for="announcement_title" class="form-label">Announcement Title</label>
                            <input type="text" class="form-control @error('announcement_title') is-invalid @enderror"
                                   value="{{ old('announcement_title') }}" id="announcement_title"
                                   name="announcement_title" placeholder="">
                            @error('announcement_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="announcement_content" class="form-label">Announcement Content</label>
                            <textarea class="form-control @error('announcement_content') is-invalid @enderror"
                                      id="announcement_content"
                                      name="announcement_content" rows="3">{{ old('announcement_content') }}</textarea>
                            @error('announcement_content')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>


                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('board-sessions.index') }}"
                           class="btn btn-default text-primary text-decoration-underline fw-bold">Back</a>
                        <button type="submit" id="btnSubmit" class="btn btn-primary fw-medium float-end">Submit</button>
                    </div>
                </div>
            </div>
        </form>







        @push('page-scripts')
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
            <script>
                new FroalaEditor('textarea', {
                    tabSpaces: 10
                });
            </script>
            <script>
                const ALLOWED_FILE_EXTENSIONS = ['pdf', 'docx', 'doc'];

                $('#btnSubmit').click(e => {
                    e.preventDefault();
                    alertify.confirm('Are you sure you want to perform this action?', () => {
                        $('#orderBusinessForm').submit();
                    }, () => {
                    }).set({
                        labels: {
                            ok: 'Yes',
                            cancel: 'No'
                        }
                    }).setHeader('Confirmation');
                });

                const orderBusinessContent = document.querySelector('#file_path');
                orderBusinessContent.addEventListener('change', () => {
                    const ext = orderBusinessContent.value.split('.').pop().toLowerCase();
                    if (!ALLOWED_FILE_EXTENSIONS.includes(ext)) {
                        orderBusinessContent.value = '';
                        orderBusinessContent.classList.add('is-invalid');
                        orderBusinessContent.insertAdjacentHTML('afterend', `<div class="invalid-feedback">Only formats are allowed: ${ALLOWED_FILE_EXTENSIONS.join(', ')}</div>`);
                    }
                });

                const unassignedBusinessFilePath = document.querySelector('#unassigned_business');
                unassignedBusinessFilePath.addEventListener('change', () => {
                    const ext = unassignedBusinessFilePath.value.split('.').pop().toLowerCase();
                    if (!ALLOWED_FILE_EXTENSIONS.includes(ext)) {
                        unassignedBusinessFilePath.value = '';
                        unassignedBusinessFilePath.classList.add('is-invalid');
                        unassignedBusinessFilePath.insertAdjacentHTML('afterend', `<div class="invalid-feedback">Only formats are allowed: ${ALLOWED_FILE_EXTENSIONS.join(', ')}</div>`);
                    }
                });
            </script>
        @endpush
    @endsection
