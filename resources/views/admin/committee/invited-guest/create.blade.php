@extends('layouts.app-2')
@section('tab-title', 'Add new Committee')
@prepend('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endprepend
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-light p-3 justify-content-between align-items-center d-flex">
            <h6 class="card-title h6 text-dark m-0">Add Invited Guest for <span
                    class="text-uppercase fw-bold">{{ $committee?->lead_committee_information?->title }}</span></h6>
        </div>
        <div class="card-body">
            <form action="{{ route('committee.invited-guest.store', $committee->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="float-end">
                        <button type="button" class="btn btn-info btn-md" id="addGuest">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1
                                    h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div id="dynamicGuestContainer">
                    @foreach($committee->committee_invited_guests as $guest)
                        <div class="form-group mt-2" id="defaultGuestField">
                            <label>Guest Fullname</label>
                            <input type="text" class="form-control" placeholder="Enter Guest Fullname" value="{{ $guest->fullname }}" name="guests[]">
                        </div>
                    @endforeach
                    <div class="form-group mt-2" id="defaultGuestField">
                        <label>Guest Fullname</label>
                        <input type="text" class="form-control" placeholder="Enter Guest Fullname" name="guests[]">
                    </div>


                </div>

                <div class="float-end">
                    <button class="btn btn-dark shadow">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @push('page-scripts')
        <script>
            $('#addGuest').click(function () {
                const $clone = $('#defaultGuestField').clone();
                $clone.removeAttr('id');
                $clone.find('input').val('');
                $clone.appendTo('#dynamicGuestContainer');
                $clone.find('input').focus();
            });
        </script>
    @endpush
@endsection
