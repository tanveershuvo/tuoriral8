@extends('components.app')

@section('title', 'Submission')

@section('content')
    <h2>Add new paper</h2>
    <form id="submissionForm" class="m-4">
        <div class="row">
            <div id="error-messages" class="text-danger"></div>
            <div class="col">

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
                        @foreach($submissionTypes as $submissionType)
                            <option value="{{$submissionType->id}}">{{$submissionType->type}}</option>
                        @endforeach
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

        <a type="button" href="{{route('submission.index')}}" class="btn btn-secondary" >Back
        </a>
        <button type="submit" id="next" class="btn btn-primary">Next</button>
        <button type="button" id="show_paper" style="display: none;" class="btn btn-success">Show
            Paper
        </button>
        <button type="button" id="next2" style="display: none;" class="btn btn-primary">Next</button>
        <button type="submit" id="save" style="display: none;" class="btn btn-success">Submit Paper
        </button>

    </form>
@endsection

@section('script')
    <script src="{{ asset('js/submission.js') }}"></script>
@endsection
