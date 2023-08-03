@extends('layouts.app-2')

@section('content')
    <div class="card">

        @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
        @endif

        <div class="card-header bg-light">
            Modify Legislation
        </div>

        <div class="card-body p-4">
            <form action="{{ route('legislation.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="">Session Date</label>
                    <input type="date" class="form-control form-control-md" name="sessionDate" id="sessionDate" value="{{ $sessionDate }}">
                </div>
                <div class="form-group">
                    <label class="text-dark">Classification</label>
                    <select name="classification" id="classification" class="form-select form-select-md">
                        @foreach($classifications as $classification)
                        <option {{ old('classification', $classification) == $data->classification ? 'selected' : '' }} value="{{ $classification }}">{{ ucfirst($classification) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="text-dark">Title</label>
                    <input type="text" class="form-control form-control-md" name="title" id="title" value="{{ $data->title }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="text-dark">Type</label>
                    <select class="form-select" name="type" id="type">
                        @foreach ($types as $type)
                            <option {{ old('type', $typeValue) == $type->name ? 'selected' : '' }} value="{{ $type->name }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label class="text-dark">Description</label>
                    <input type="text" class="form-control form-control-md" name="description" id="description" value="{{ $data->description }}">
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-5">
                    <label class="text-dark">Author</label>
                    <select name="author" id="author" class="form-select form-select-md">
                        @foreach ($sp_members as $sp_member)
                            <option {{ old('author', $author) == $sp_member->sp_id ? 'selected' : '' }} value="{{ $sp_member->sp_id }}">
                                {{ $sp_member->sp_fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($attachment)
                    @php
                        $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                        $originalFilename = preg_replace('/^[^.]+\./', '', $attachment);
                    @endphp

                    @if (strtolower($extension) === 'pdf')
                        <img src="{{ asset('/storage/source/Approved-Legislation/pdf.png') }}" width="100px">
                    @elseif (strtolower($extension) === 'docx')
                        <img src="{{ asset('/storage/source/Approved-Legislation/word.png') }}" width="100px">
                    @else
                        <img src="{{ asset('/storage/source/Approved-Legislation/excel.png') }}" width="100px">
                    @endif
                @endif

                @if($attachment)
                    <h5 class="fw-bold">{{ $originalFilename }}</h5>
                @endif

                <div class="form-group mt-3">
                    <label class="text-dark">Attachment</label>
                    <input type="file" class="form-control form-control-md" name="attachment" id="attachment">
                    @error('attachment')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('legislation.index') }}" class="text-decoration-underline fw-bold text-primary fs-4">Back</a>
                    <button type="submit" class="btn btn-success" id="btnUpdate">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
