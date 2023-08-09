<div class="dd" style="max-width:  100%;">
    @if (count($data['attachments']) > 0)
        <div class="dd-item cursor-pointer" data-file-path=="{{ $data['file_path'] }}"">
            <div class="dd-handle">
                <div class="d-flex align-items-center">
                    <img src="{{ getIconByFileName($data['file_name']) }}"
                         style="width : 20px;"
                         alt="" class="mx-1 border">
                    <span class="fw-medium">
                        {{ removeFileExtension(removeTimestampPrefix($data['file_name'])) }}
                    </span>
                </div>
            </div>
            <div class="dd-list">
                @foreach ($data['attachments'] as $attachment)
                    @include('admin.regular-sessions.treeview', ['data' => $attachment])
                @endforeach
            </div>
        </div>
    @else
        <div class="dd-item cursor-pointer" data-file-path="{{ $data['file_path'] }}">
            <div class="dd-handle">
                <div class="d-flex align-items-center">
                    <img src="{{ getIconByFileName($data['file_name']) }}"
                         style="width : 20px;"
                         alt="" class="me-1 border">
                    <span class="fw-medium">
                        {{ removeFileExtension(removeTimestampPrefix($data['file_name'])) }}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>

