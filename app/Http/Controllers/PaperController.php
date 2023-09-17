<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionEditRequest;
use App\Models\Paper;
use App\Models\Paper_review;
use App\Models\SubmissionType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $papers = Paper::with('authors', 'paper_review', 'submissionType', 'submissionType.venue')->get();
        return view('submission', ['papers' => $papers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Paper $paper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paper = Paper::where('id',decrypt($id))->with('authors')->first(); // Replace 'Item' with your model
        if (!$paper) {
            abort(404); // Handle not found items
        }
        $submission_types = SubmissionType::all('id','type');

        return view('editSubmission',['submissionTypes'=>$submission_types,'paper'=>$paper]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubmissionEditRequest $request, $id)
    {
        Paper::where('id', decrypt($id))
            ->update([
                'paper_title' => $request->update_title,
                'abstract' => $request->update_abstract,
                'submission_type_id'=>$request->update_submission_type
            ]);
        // Flash a success message to the session
        session()->flash('success', 'Record updated successfully');
        return redirect()->route('submission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Paper::where('id',decrypt($id));
        $record->delete();
        session()->flash('success', 'Record deleted successfully');
        return redirect()->route('submission.index');
    }

    public function reviewer($id)
    {
        $paper_review = Paper_review::with('reviewers')
            ->where('paper_id', decrypt($id))
            ->get();
        return response()->json($paper_review);
    }
}
