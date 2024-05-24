<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    public function create(Request $request, $code)
    {
        if (!Auth::check()) {
            flash()->addError('Please login first');
            return redirect('/login');
        }

        $classroom = Classroom::where('code', $code)->first();
        if ($classroom == null) {
            flash()->addError('Classroom does not exists');
            return back();
        }

        $userJoinedClass = DB::table('classroom_user')
            ->where('user_id', Auth::user()->id)
            ->where('classroom_id', $classroom->id)
            ->exists();

        if (!$userJoinedClass) {
            flash()->addError('You have not joined this class');
            return back();
        }

        $isOwner = DB::table('classroom_user')
            ->where('user_id', Auth::user()->id)
            ->where('classroom_id', $classroom->id)
            ->where('owner', 1)
            ->exists();

        if (!$isOwner) {
            flash()->addError('You are not allowed to access this page');
            return back();
        }

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'total' => 'required|numeric',
                'data' => 'required',
            ],
            [
                'title.required' => 'Assessment title is required',
                'description.required' => 'Assessment description is required',
                'total.required' => 'Assessment total points is required',
                'total.numeric' => 'Assessment total points must be numeric',
                'data.required' => 'Form data is required'
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        $assessmentForm = [
            'classroom_id' => $classroom->id,
            'title' => $request->title,
            'description' => $request->description,
            'total' => $request->total,
            'data' => $request->data,
        ];

        Assessment::create($assessmentForm);
        flash()->addSuccess('Assessment created successfully');
        return redirect('/classrooms/' . $classroom->code);
    }

    public function delete(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('You must be logged in');
            return redirect('/login');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:assessments,id',
            ],
            [
                'id.required' => 'Assessment ID is required',
                'id.exists' => 'Assessment ID does not exists'
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        Assessment::find($request->id)->delete();
        flash()->addSuccess('Assessment deleted successfully');
        return redirect('/');
    }
}
