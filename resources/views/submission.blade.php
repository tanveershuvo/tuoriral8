@extends('components.app')

@section('title', 'Submission')

@section('content')
    <div class="row">
        <div class="col text-center">
            <h1 class="mb-4">Submission List</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-secondary btn-lg mb-4" data-bs-toggle="modal"
                    data-bs-target="#submissionModal">
                Submit a New Paper
            </button>
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
                            <a type="button" id="reviewer" class="btn btn-info" data-id="{{ encrypt($paper->id)}}">Reviewer</a>
                            <a type="button" class="btn btn-primary" href="{{ url('submission/'.encrypt($paper->id).'/edit') }}">Edit</a>
                            <form method="POST" id="deleteRecord" action="{{route('submission.destroy',encrypt($paper->id))}}">
                                @csrf
                                @method('DELETE')
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


<!-- Modal -->
<div class="modal fade" id="updatePaperModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="updatePaperModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePaperModalLabel">Update Paper Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update_paper_form">
                    <input type="hidden" name="update_paper_id" class="form-control"
                           id="update_paper_id">
                    <div class="mb-3">
                        <label for="update_author_name" class="form-label">Author</label>
                        <input type="text" name="update_author_name" class="form-control"
                               id="update_author_name">
                    </div>
                    <div class="mb-3">
                        <label for="update_submission_type" class="form-label">Type of paper</label> <br>
                        <select name="update_submission_type" class="form-control" id="update_submission_type">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="update_title" class="form-label">Title</label>
                        <input type="text" name="update_title" class="form-control"
                               id="update_title">
                    </div>
                    <div class="mb-3">
                        <label for="update_abstract" class="form-label">Abstract</label>
                        <input type="text" name="update_abstract" class="form-control"
                               id="update_abstract">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit_update_paper" class="btn btn-info">Update Paper</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submissionModalLabel">Submit a New Paper</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="submissionForm">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="inputType" id="inputType" value="check">
                            <input type="hidden" name="authorId" id="authorId" value="">
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" name="author" placeholder="Input Author Name"
                                       class="form-control required checkData"
                                       id="author">
                                <div class="text-danger" id="authorError"></div>

                            </div>
                            <div class="mb-3">

                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" placeholder="Input Author email"
                                       class="form-control required checkData"
                                       id="email">
                                <div class="text-danger" id="emailError"></div>

                            </div>
                            <div class="mb-3">

                                <label for="affiliate" class="form-label">Affiliate</label>
                                <input type="text" name="affiliate" placeholder="Input Author affiliate"
                                       class="form-control required checkData"
                                       id="affiliate">
                                <div class="text-danger" id="affiliateError"></div>
                            </div>

                        </div>
                        <div class="col" style="display: none;" id="afterCheckInput">
                            <div class="mb-3">
                                <label for="paper_type" class="form-label">Type of paper</label> <br>
                                <select name="submission_type" class="form-control" id="submission_type">
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" placeholder="Input Paper title"
                                       class="form-control required"
                                       id="title">
                                <div class="text-danger" id="titleError"></div>
                            </div>
                            <div class="mb-3">
                                <label for="abstract" class="form-label">Abstract</label>
                                <input type="text" name="abstract" placeholder="Input Paper abstract"
                                       class="form-control required"
                                       id="abstract">
                                <div class="text-danger" id="abstractError"></div>
                            </div>
                        </div>
                        <div class="text-center" id="message"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closSubmissionModal"
                                data-bs-dismiss="modal">Close
                        </button>
                        <button type="submit" id="next" class="btn btn-primary">Next</button>
                        <button type="button" id="show_paper" style="display: none;" class="btn btn-success">Show
                            Paper
                        </button>
                        <button type="button" id="next2" style="display: none;" class="btn btn-primary">Next</button>
                        <button type="submit" id="save" style="display: none;" class="btn btn-success">Submit Paper
                        </button>
                    </div>
                </form>
            </div>
            @foreach ($papers as $paper)
                <li>{{ $paper->paper_title }}</li>
                <li>{{ $paper->abstract }}</li>
                <hr>
            @endforeach

        </div>
    </div>
</div>


@section('script')
    <script src="{{ asset('js/submission.js') }}"></script>
@endsection
