@extends('layouts.app')
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
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex flex-row justify-content-between align-items-center">
            <span class="fw-bold">Ordered Business</span>
            <ul class="nav nav-pills float-end btn-group flex-column flex-sm-row"" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-primary rounded-0" id="business-tab" data-bs-toggle="tab"
                        data-bs-target="#busines-tab" type="button" role="tab" aria-controls="business-tab"
                        aria-selected="true">Ordered Business</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn btn-primary rounded-0" id="unassigned-business-tab" data-bs-toggle="tab"
                        data-bs-target="#unassigned" type="button" role="tab" aria-controls="unassigned"
                        aria-selected="false">Unassigned
                        Business</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn btn-primary rounded-0" id="announcements-tab" data-bs-toggle="tab"
                        data-bs-target="#announcements" type="button" role="tab" aria-controls="announcements"
                        aria-selected="false">Announcements</button>
                </li>
            </ul>
        </div>
        <div class="card-body">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="busines-tab" role="tabpanel"
                    aria-labelledby="order-business-tab">
                    <form action="{{ route('board-sessions.store') }}" id="orderBusinessForm" method="POST"
                        enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" value="{{ old('title') }}" id="title"
                                title="title" name="title" placeholder="Enter title">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- file_path --}}
                        <div class="mb-3">
                            <label for="file_path">File Path</label>
                            <input type="file" class="form-control" value="{{ old('file_path') }}" id="file_path"
                                name="file_path" placeholder="Enter file path">
                            @error('file_path')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- is published --}}
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="publishedCheckbox" name="published">
                            <label class="form-check-label" for="publishedCheckbox">Published</label>
                            @error('published')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="unassigned" role="tabpanel" aria-labelledby="unassigned-business-tab">
                    <form action="{{ route('board-session.unassigned-business.store') }}" id="unassignedBusinessForm"
                        method="POST">
                        <div class="mb-3">
                            <label for="unassigned_title">Title</label>
                            <input type="text" class="form-control" value="{{ old('unassigned_title') }}"
                                id="unassigned_title" name="unassigned_title" placeholder="Enter title">
                            @error('unassigned_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unassigned_business">Content</label>
                            <textarea class="form-control" id="unassigned_business" name="unassigned_business" rows="3">{{ old('unassigned_business') }}</textarea>
                            @error('unassigned_business')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
                    <form action="{{ route('board-session.announcement.store') }}" id="announcementForm" method="POST">
                        <div class="mb-3">
                            <label for="announcement_title">Title</label>
                            <input type="text" class="form-control" value="{{ old('announcement_title') }}"
                                id="announcement_title" name="announcement_title" placeholder="Enter title">
                            @error('announcement_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="announcement_content">Content</label>
                            <textarea class="form-control" id="announcement_content" name="announcement_content" rows="3">{{ old('announcement_content') }}</textarea>
                            @error('announcement_content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('board-sessions.index') }}"
                    class="btn btn-default text-primary text-decoration-underline fw-bold">Back</a>
                <button form="orderBusinessForm" type="submit" id="btnSubmit"
                    class="btn btn-primary float-end">Submit</button>
            </div>
        </div>
    </div>



    @push('page-scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            (function() {
                if (localStorage.getItem('tab')) {
                    // If it does, set the active tab to the tab in localStorage
                    $(`#${localStorage.getItem('tab')}`).trigger('click');
                    // Remove the tab from localStorage
                    localStorage.removeItem('tab');
                }
            })();

            $(document).ready(function() {
                // Check if localStorage has a tab
                $('#business-tab').click(function() {
                    localStorage.setItem('tab', 'business-tab');
                    $('#btnSubmit').attr('form', 'orderBusinessForm');
                });

                $('#unassigned-business-tab').click(function() {
                    localStorage.setItem('tab', 'unassigned-business-tab');
                    $('#btnSubmit').attr('form', 'unassignedBusinessForm');
                });
                $('#announcements-tab').click(function() {
                    localStorage.setItem('tab', 'announcements-tab');
                    $('#btnSubmit').attr('form', 'announcementForm');
                });
            });
        </script>
    @endpush
@endsection
