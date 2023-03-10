@extends('layouts.app')
@section('page-title', 'Sangguniang Panlalawigan Members')
@prepend('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <style>
        .dataTables_filter input {
            margin-bottom: 10px;
        }
    </style>
@endprepend
@section('content')
    @if (Session::has('success'))
        <div class="card mb-2 bg-success shadow-sm text-white">
            <div class="card-body">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header justify-content-between align-items-center d-flex">
            <h6 class="card-title m-0">Sangguniang Panlalawigan Members</h6>
            <div class="dropdown">
                <a href="{{ route('sanggunian-members.create') }}" class="btn btn-primary btn-sm">
                    Add New Member
                </a>
            </div>
        </div>
        <div class="card-body">

            <!-- User Listing Table-->
            <div class="table-responsive">
                <table class="table table-striped border" id="members-table">
                    <thead>
                        <tr>
                            <th class="text-center">Fullname</th>
                            <th class="text-center">District</th>
                            <th>Sanggunian</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td class="text-muted ">{{ $member->fullname }}</td>
                                <td class="text-muted ">{{ $member->district }}</td>
                                <td class="text-muted ">{{ $member->sanggunian }}</td>
                                <td class="text-muted text-center">

                                    <form action="{{ route('sanggunian-members.destroy', $member) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('sanggunian-members.edit', $member) }}"
                                            class="btn btn-success text-white btn-sm">Edit</a>
                                        <button type="submit" class="btn btn-danger text-white btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('page-scripts')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#members-table').DataTable({});
            });
        </script>
    @endpush
@endsection
