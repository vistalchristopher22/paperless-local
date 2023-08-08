@extends('layouts.app-2')
@section('tab-title', 'Modify Schedule')
@prepend('page-css')
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
    @foreach($records as $date => $record)
        <div class="accordion" style="max-width: 2000px;">
            <div class="accordion-item border-top-0">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button bg-soft-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panel-{{ $date }}" aria-expanded="true"
                            aria-controls="panel-{{ $date }}">
                        <div class="card-title">
                            {{--                            The 56th regular session of 2023 is scheduled for July 26th.--}}
                            @isset($record?->first()?->regular_session)
                                <span class="text-capitalize me-1 text-primary fw-bolder">Session - </span>
                                - <span
                                    class="text-primary fw-bolder">{{ $record?->first()?->regular_session?->number }}</span>
                                Regular
                                Session <span
                                    class="text-lowercase">of</span> {{ $record?->first()?->regular_session?->year }}
                                <span class="text-lowercase">is scheduled for</span> <span
                                    class="fw-bolder text-primary">{{ date('F d, Y', strtotime($date)) }}</span>
                            @endisset
                        </div>
                    </button>
                </h2>
                <div id="panel-{{ $date }}" class="accordion-collapse collapse"
                     aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        @foreach($record as $key => $session)
                            <div class="card">
                                <div class="card-header bg-light p-3">
                                    <div class="card-title">
                                        {{ $session->name }}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion" id="session-{{ $session->id }}">
                                        <div class="accordion-item border-top-0">
                                            <h2 class="accordion-header mt-0 d-flex flex-row rounded-0"
                                                id="orderBusiness">
                                                <button class="accordion-button bg-light collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#session-{{ $session->id }}-order-business"
                                                        aria-expanded="true"
                                                        aria-controls="session-{{ $session->id }}-order-business">
                                                    <span class="card-title">
                                                        Order Business
                                                    </span>
                                                </button>
                                                <button
                                                    class="btn-sm btn btn-dark fw-medium btn-preview-document rounded-0 px-3 fw-medium d-flex align-items-center"
                                                    data-url="{{ $session->board_sessions[0]->file_path_view }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="16"
                                                         height="16" fill="currentColor"
                                                         class="bi bi-file-text me-2"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                                        <path
                                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                                                    </svg>
                                                    Document
                                                </button>
                                            </h2>

                                            <div id="session-{{ $session->id }}-order-business"
                                                 class="accordion-collapse collapse"
                                                 aria-labelledby="orderBusiness"
                                                 data-bs-parent="#session-{{ $session->id }}">
                                                <div class="accordion-body">
                                                    @isset($session->board_sessions[0]->order_business_note)
                                                        {!! $session->board_sessions[0]->order_business_note !!}
                                                    @else
                                                        Note Not Available
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>


                                        <div class="accordion-item border-top-0">
                                            <h2 class="accordion-header mt-0 d-flex flex-row rounded-0"
                                                id="orderBusiness">
                                                <button class="accordion-button bg-light collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#session-{{ $session->id }}-un-assigned-business"
                                                        aria-expanded="true"
                                                        aria-controls="session-{{ $session->id }}-un-assigned-business">
                                                    <span class="card-title">
                                                        Unassigned Business
                                                    </span>
                                                </button>
                                            </h2>

                                            <div id="session-{{ $session->id }}-un-assigned-business"
                                                 class="accordion-collapse collapse"
                                                 aria-labelledby="orderBusiness"
                                                 data-bs-parent="#session-{{ $session->id }}">
                                                <div class="accordion-body">
                                                    @isset($session->board_sessions[0]->unassigned_content)
                                                        {!! $session->board_sessions[0]->unassigned_content !!}
                                                    @else
                                                        Content Not Available
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>


                                        <div class="accordion-item">
                                            <h2 class="accordion-header mt-0 d-flex flex-row rounded-0">
                                                <button class="accordion-button collapsed bg-light"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#announcement-{{ $session->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="announcement-{{ $session->id }}">
                                                    <span class="card-title">
                                                        Announcements
                                                    </span>
                                                </button>
                                            </h2>
                                            <div id="announcement-{{ $session->id }}"
                                                 class="accordion-collapse collapse"
                                                 data-bs-parent="#session-{{ $session->id }}"
                                                 style="">
                                                <div class="accordion-body">
                                                    @isset($session->board_sessions[0]->announcement_content)
                                                        {!! $session->board_sessions[0]->announcement_content !!}
                                                    @else
                                                        Note Not Available
                                                    @endisset
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('page-scripts')
        <script>
            $(document).ready(function () {
                $(document).on('click', '.btn-preview-document', function () {
                    let url = $(this).attr('data-url');
                    $('#previewModal').find('iframe').attr('src', `${url}#zoom=190&toolbar=0`);
                    $('#previewModal').modal('show');
                })
            });
        </script>
    @endpush
@endsection
s
