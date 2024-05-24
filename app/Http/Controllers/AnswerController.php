<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function create(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('You must be logged in');
            return redirect('/login');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'assessment_id' => 'required|exists:assessments,id',
                'data' => 'required'
            ],
            [
                'user_id.required' => 'User ID is required',
                'user_id.exits' => 'User ID does not exists',
                'assessment_id.required' => 'Assessment ID is required',
                'assessment_id.exists' => 'Assessment ID does not exists',
                'data.required' => 'Answer data is required'
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        $answerForm = [
            'user_id' => $request->user_id,
            'assessment_id' => $request->assessment_id,
            'data' => $request->data
        ];

        Answer::create($answerForm);
        flash()->addSuccess('Answer submitted successfully');
        return back();
    }


    public function grade(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('You must be logged in');
            return redirect('/login');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:answers,id',
                'score' => 'required|numeric'
            ],
            [
                'id.required' => 'Answer ID is required',
                'id.exits' => 'Answer ID does not exists',
                'score.required' => 'Score is required',
                'score.numeric' => 'Score should be a number'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        $answer = Answer::find($request->id);
        if ($request->score < 0 || $request->score > $answer->assessment->total) {
            flash()->addError('Score should be between zero and assessment total points');
            return back();
        }

        $answer->score = $request->score;
        $answer->save();

        flash()->addSuccess('Grade has been updated successfully');
        return back();
    }
}
