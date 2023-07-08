@extends('layouts.app')
@prepend('page-css')
    @endpush
    @section('page-title', 'New Ordered Business')
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
        <form action="{{ route('board-sessions.update', $boardSession) }}" id="orderBusinessForm" method="POST"
              enctype="multipart/form-data">
            @method('PUT')
            <div class="card shadow-none mb-5">
                <div class="card-header d-flex flex-row justify-content-between align-items-center">
                    <span class="fw-bold">Ordered Business</span>
                </div>

                <div class="card-body p-0 mb-0">
                    <div class="p-4">
                        <div class="mb-3">
                            <label for="title" class="form-label">Order Business title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                   value="{{ old('title', $boardSession->title) }}" id="title" title="title"
                                   name="title"
                                   placeholder="Enter title">
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
                            <label for="unassigned_title" class="form-label">Unassigned Business title</label>
                            <input type="text"
                                   class="form-control {{ $errors->has('unassigned_title') ? 'is-invalid' : '' }}"
                                   value="{{ old('unassigned_title', $boardSession->unassigned_title) }}"
                                   id="unassigned_title" name="unassigned_title"
                                   placeholder="Enter title">
                            @error('unassigned_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unassigned_business" class="form-label">Content</label>
                            <textarea class="form-control {{ $errors->has('unassigned_business') ? 'is-invalid' : '' }}"
                                      id="unassigned_business"
                                      name="unassigned_business"
                                      rows="3">{{ old('unassigned_business', $boardSession->unassigned_business) }}</textarea>
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
                            <label for="announcement_title" class="form-label">Announcement title</label>
                            <input type="text" class="form-control @error('announcement_title') is-invalid @enderror"
                                   value="{{ old('announcement_title', $boardSession->announcement_title) }}"
                                   id="announcement_title"
                                   name="announcement_title" placeholder="Enter title">
                            @error('announcement_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="announcement_content" class="form-label">Announcement Content</label>
                            <textarea class="form-control @error('announcement_content') is-invalid @enderror"
                                      id="announcement_content"
                                      name="announcement_content"
                                      rows="3">{{ old('announcement_content', $boardSession->announcement_content) }}</textarea>
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

                        <button type="submit" id="btnSubmit"
                                class="btn btn-success text-white float-end">Update
                        </button>
                    </div>
                </div>
            </div>
        </form>



        @push('page-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                (function () {
                    if (localStorage.getItem('tab')) {
                        // If it does, set the active tab to the tab in localStorage
                        $(`#${localStorage.getItem('tab')}`).trigger('click');

                        // Remove the tab from localStorage
                        localStorage.removeItem('tab');
                    }
                })();

                $(document).ready(function () {
                    $('#file_path').change(function () {
                        // Check file extension
                        var fileExtension = ['pdf', 'docx', 'doc'];
                        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                            $(this).val('');
                            // display an error message at the bottom if there's an error and also add a is-invalid in the input
                            $(this).addClass('is-invalid');
                            $(this).after(
                                `<div class="invalid-feedback">Only formats are allowed : ${fileExtension.join(', ')}
                            </div>`
                            );
                        }
                    });
                });
            </script>
        @endpush
    @endsection
