@extends('components.app')

@section('title', 'Submission')

@section('content')
    <div class="row">
        <div class="col text-center">
            <h1 class="mb-4">Submission List</h1>
            <!-- Button trigger modal -->
            <a type="button" class="btn btn-secondary btn-lg mb-4" href="{{route('submission.create')}}">
                Submit a New Paper
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Table Start -->
            <table class="table table-bordered text-center" id="submissionTable">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Paper ID</th>
                    <th scope="col">Author</th>
                    <th scope="col">Type</th>
                    <th scope="col">Title</th>
                    <th scope="col">Abstract</th>
                    <th scope="col">Location</th>
                    <th scope="col">Score</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($papers as $paper)
                    <tr>
                        <td>{{ $paper->id }}</td>
                        <td>{{ $paper->authors->full_name }}</td>
                        <td>{{ $paper->submissionType->type }}</td>
                        <td>{{ $paper->paper_title }}</td>
                        <td>{{ $paper->abstract }}</td>
                        <td>{{ $paper->submissionType->venue->venue_name }}</td>
                        <td>{{ $paper->paper_review->avg('score') }}</td>
                        <td width="300px">
                             <form method="POST" id="deleteRecord" action="{{route('submission.destroy',encrypt($paper->id))}}">
                                @csrf
                                @method('DELETE')
                                 <a type="button" id="reviewer" class="btn btn-info" data-id="{{ encrypt($paper->id)}}">Reviewer</a>
                                 <a type="button" class="btn btn-primary" href="{{ url('submission/'.encrypt($paper->id).'/edit') }}">Edit</a>

                                 <button type="submit" class="btn btn-danger" onclick="deleteRecord()">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
            <!-- Table End -->
        </div>
    </div>
@endsection


<!-- Modal -->
<div class="modal fade" id="reviewerInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reviewer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Table Start -->
                        <table class="table table-bordered text-center" id="reviewerTable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Reviewer name</th>
                                <th scope="col">Reviewer Comment</th>
                                <th scope="col">Reviewer Score</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- Table End -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@section('script')
    <script src="{{ asset('js/submission.js') }}"></script>
@endsection
