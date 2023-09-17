@extends('components.app')

@section('title', 'Edit Submission')

@section('content')

    <div class="row col-md-11 m-4">
        <h5 class="md-4">Update Paper Details</h5>
        <form action="{{route('submission.update',encrypt($paper->id))}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="update_author_name" class="form-label">Author</label>
                <input type="text" name="update_author_name" value="{{$paper->authors->full_name}}" class="form-control" readonly >
            </div>
            <div class="mb-3">
                <label for="update_submission_type" class="form-label">Type of paper</label>
                <select name="update_submission_type" class="form-control">

                    @foreach($submissionTypes as $submissionType)
                        <option value="{{$submissionType->id}}" @if ($submissionType->id === $paper->submission_type_id) selected @endif>{{$submissionType->type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="update_title" class="form-label">Title</label>
                <input type="text" name="update_title" value="{{$paper->paper_title}}" class="form-control">
                @error('update_title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="update_abstract" class="form-label">Abstract</label>
                <textarea name="update_abstract" class="form-control" rows="3">{{$paper->abstract}}</textarea>
                @error('update_abstract')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <a type="button" href="{{route('submission.index')}}" class="btn btn-secondary col-2">Back</a>
            <button type="submit" class="btn btn-info col-3">Update Paper</button>

        </form>
    </div>

@endsection
