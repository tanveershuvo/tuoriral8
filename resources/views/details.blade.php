@extends('components.app')

@section('title', 'Submission')

@section('content')

<h1 class="my-3 text-center">Conference Date: 22-24 September 2023</h1>
<hr>
<h4 class="my-3 text-center">Submission deadlines and page limits</h4>
<div class="table-responsive col-8 mx-auto">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <th></th>
        <th>Page</th>
        <th>Deadline</th>
        </thead>
        <tbody>
        <tr>
            <td>Paper</td>
            <td>6 pages plus 1 page for
                references if required
            </td>
            <td>1 April</td>
        </tr>
        <tr>
            <td>Working group</td>
            <td>2 pages</td>
            <td>1 April</td>
        </tr>
        <tr>
            <td>Poster</td>
            <td>1 page</td>
            <td>15 Jun</td>
        </tr>
        <tr>
            <td>Doctoral consortium</td>
            <td>2 pages</td>
            <td>15 Jun</td>
        </tr>
        <tr>
            <td>Tips, techniques & courseware</td>
            <td>2 pages</td>
            <td>15 Jun</td>
        </tr>
        </tbody>
    </table>
</div>
<hr>
<h4 class="my-3 text-center">Contact Address</h4>
<div class="table-responsive col-5 mb-3 mx-auto text-center">
    <table class="table table-bordered table-hover">
        <tr>
            <td>Conference Chair</td>
            <td>conferencechair@conference.com</td>
        </tr>
        <tr>
            <td>Organisation</td>
            <td>organisation@conference.com</td>
        </tr>
        <tr>
            <td>Support Liaison</td>
            <td>support@conference.com</td>
        </tr>
    </table>
</div>
@endsection
