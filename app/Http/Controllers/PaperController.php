<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionEditRequest;
use App\Models\Paper;
use App\Models\Paper_review;
use App\Models\Participant;
use App\Models\SubmissionType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $submission_types = SubmissionType::all('id','type');

        return view('addPaper',['submissionTypes'=>$submission_types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if($request->lastInsertedUser === null){
            $validator = Validator::make($request->all(), [
                'author' => 'required|string|max:255',
                'affiliate' => 'required|string|max:10',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $email = $request->input('email');
            $author = $request->input('author');
            $affiliate = $request->input('affiliate');

            $participant = Participant::where('email', $email)->first();

            if ($participant) {
                $paperSubmission = Paper::where('author_id', $participant->id)->first();

                if ($paperSubmission) {
                    $Paper = Paper::where('author_id',$participant->id)->first();
                    return response()->json(['data' => $Paper,'type'=>'existedUser'], 200);
                } else {
                    return response()->json(['data' => '','type'=>'newUser'], 200);
                }
            } else {
                $names = explode(' ', $author);
                $newRecord = Participant::create([
                    'first_name' => $names[0],
                    'last_name' => $names[1] ?? '',
                    'email' => $email,
                    'Affiliation' => $affiliate,
                    'password' => 'sample',
                    'is_active' => 'active',
                    'conference_id' => 1
                ]);

                $lastInsertedId = $newRecord->id;

                return response()->json(['data' => $lastInsertedId,'type'=>'createdUser'], 200);
            }
        }else{

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:100',
                'abstract' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $email = $request->input('email');
            $title = $request->input('title');
            $abstract = $request->input('abstract');

            $author_id = Participant::where('email',$email)->first('id');
            Paper::create([
                'author_id'=>$author_id->id,
                'submission_type_id'=>1,
                'paper_title'=> $title,
                'abstract'=> $abstract,
                'is_accepted'=>0
            ]);
            session()->flash('success', 'Record added successfully');
            return response()->json(['data' => route('submission.index'),'type'=>'redirect'], 200);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paper = Paper::where('id',decrypt($id))->with('authors')->first();
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
        $record = Paper::where('id','=',decrypt($id));

        $record->delete();
        session()->flash('success', 'Record deleted successfully');
        return response()->json('', 200);
    }

    public function reviewer($id)
    {
        $paper_review = Paper_review::with('reviewers')
            ->where('paper_id', decrypt($id))
            ->get();
        return response()->json($paper_review);
    }
}
