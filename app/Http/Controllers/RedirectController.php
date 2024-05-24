<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assessment;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    public function redirectToLoginPage(Request $request)
    {
        if (Auth::check()) {
            return back();
        }
        return view('login');
    }

    public function redirectToRegisterPage(Request $request)
    {
        if (Auth::check()) {
            return back();
        }
        return view('register');
    }

    public function redirectToDashboardPage(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('dashboard');
    }

    public function redirectToClassroomsPage(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('Please login first');
            return redirect('/login');
        }

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = Auth::user();
        $ownedClassrooms = $user->classrooms()->wherePivot('owner', 1)->get();
        $joinedClassrooms = $user->classrooms()
            ->wherePivot('owner', 0)
            ->get();

        foreach ($joinedClassrooms as $classroom) {
            $section = Section::find($classroom->pivot->section_id);
            $classroom->section = $section;
        }

        return view('classrooms', [
            'owned_classrooms' => $ownedClassrooms,
            'joined_classrooms' => $joinedClassrooms,
        ]);
    }

    public function redirectToClassroomPage(Request $request, $code)
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

        foreach ($classroom->users as $user) {
            $section = Section::find($user->pivot->section_id);
            $user->section = $section;
        }

        return view('classroom', [
            'classroom' => $classroom,
            'is_owner' => $isOwner
        ]);
    }

    public function redirectToAssessmentBuilderPage(Request $request, $code)
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

        return view('formbuilder', [
            'classroom' => $classroom
        ]);
    }

    public function redirectToAssessmentPreviewPage(Request $request, $code)
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

        return view('formpreview', [
            'classroom' => $classroom,
            'title' => $request->title,
            'description' => $request->description,
            'data' => $request->data,
        ]);
    }

    public function redirectToAssessmentPage(Request $request, $code, $id)
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

        foreach ($classroom->users as $user) {
            $section = Section::find($user->pivot->section_id);
            $user->section = $section;
        }

        $assessment = Assessment::find($id);
        if ($assessment == null) {
            flash()->addError('Assessment does not exist');
            return back();
        }

        if ($isOwner) {
            foreach ($assessment->classroom->users as $user) {
                $section = Section::find($user->pivot->section_id);
                $user->section = $section;
            }

            return view('assessment_owned', [
                'assessment' => $assessment,
            ]);
        }

        $answer = Answer::where('user_id', Auth::user()->id)
            ->where('assessment_id', $assessment->id)
            ->first();

        if ($answer != null) {
            return view('assessment_answered', [
                'answer' => $answer
            ]);
        }

        return view('assessment_unanswered', [
            'assessment' => $assessment,
        ]);
    }

    public function redirectToGradeAssessmentPage(Request $request, $code, $assessment_id, $user_id)
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
            flash()->addError('You are not allowed to access this');
            return back();
        }

        $assessment = Assessment::find($assessment_id);
        if ($assessment == null) {
            flash()->addError('Assessment does not exist');
            return back();
        }

        $user = User::find($user_id);
        if ($user == null) {
            flash()->addError('User does not exists');
            return back();
        }

        $userJoinedClass = DB::table('classroom_user')
            ->where('user_id', $user_id)
            ->where('classroom_id', $classroom->id)
            ->exists();

        if (!$userJoinedClass) {
            flash()->addError('User have not joined this class');
            return back();
        }

        $answer = Answer::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->first();

        if ($answer == null) {
            flash()->addError('This user has not answered yet');
            return back();
        }
        return view('assessment_grade', [
            'answer' => $answer,
        ]);
    }

    public function redirectToLatestAssementPage(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('Please login first');
            return redirect('/login');
        }

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = Auth::user();
        $latestAssessment = $user->getLatestAssessment();
        if ($latestAssessment == null) {
            flash()->addError('No assessment yet!');
            return back();
        }
        $code = $latestAssessment->classroom->code;
        return $this->redirectToClassroomPage($request, $code);
    }

    public function redirectToAccountPage(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('Please login first');
            return redirect('/login');
        }

        return view('account');
    }
}
