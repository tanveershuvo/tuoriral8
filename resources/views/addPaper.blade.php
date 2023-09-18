@extends('components.app')

@section('title', 'Submission')

@section('content')
    <h2>Add new paper</h2>
    <form id="submissionForm" class="m-4">
        <div class="row">
            <div id="error-messages" class="text-danger"></div>
            <div class="col">
                <input type="hidden" name="lastInsertedUser" id="lastInsertedUser" value="">
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" placeholder="Input Author Name"
                           class="form-control required checkData"
                           id="author">

                </div>
                <div class="mb-3">

                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" placeholder="Input Author email"
                           class="form-control required checkData"
                           id="email">

                </div>
                <div class="mb-3">

                    <label for="affiliate" class="form-label">Affiliate</label>
                    <input type="text" name="affiliate" placeholder="Input Author affiliate"
                           class="form-control required checkData"
                           id="affiliate">
                </div>

            </div>
            <div class="col" style="display: none;" id="afterCheckInput">
                <div class="mb-3">
                    <label for="paper_type" class="form-label">Type of paper</label> <br>
                    <select name="submission_type" id="submission_type" class="form-control" id="submission_type">
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
                </div>
                <div class="mb-3">
                    <label for="abstract" class="form-label">Abstract</label>
                    <input type="text" name="abstract" placeholder="Input Paper abstract"
                           class="form-control required"
                           id="abstract">
                </div>
            </div>
            <div class="text-center" id="message"></div>
        </div>

        <a type="button" href="{{route('submission.index')}}" class="btn btn-secondary">Back
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
    <script>
        $(document).on("submit", "#submissionForm", function (event) {
            event.preventDefault();
            let formData = $(this).serialize();

            sendAjaxRequest('POST', "{{route('submission.store')}}", formData, function (response) {
                console.log(response.data)
                if (response.type === 'redirect') {
                    window.location.href = response.data;
                } else if (response.type === "createdUser") {
                    $('#message').addClass('text-primary').text('Do you want to continue to submit the paper?')
                    $("#next2").show();
                    $("#lastInsertedUser").val(response.data);

                } else if (response.type === "existedUser") {
                    $('#message').addClass('text-info').text('Author already submitted a paper');
                    $("#title").val(response.data.paper_title).prop('readonly', true);
                    $("#abstract").val(response.data.abstract).prop('readonly', true);
                    $("#submission_type").val(response.data.submission_type_id).prop('readonly', true);
                    $("#authorId").val(response.data.author_id);
                    $("#show_paper").show();
                } else if (response.type === "newUser") {
                    $('#message').addClass('text-primary').text(' You have already provided the author information. Do you want to continue to submit the paper?');
                    $("#next2").show();
                }
                $("#next").hide();
                $(".checkData").prop("readonly", true);

            });
        });


    </script>
@endsection
