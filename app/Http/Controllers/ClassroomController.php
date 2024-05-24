<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ClassroomController extends Controller
{
    public function create(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('You must be logged in to do that!');
            return redirect('/');
        }

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = Auth::user();
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'sections' => 'required|regex:/.+,/',
                'description' => 'required',
            ],
            [
                'name.required' => 'Class name is required',
                'sections.required' => 'Class sections is required',
                'sections.regex' => 'Invalid section format',
                'description.required' => 'Class description is required',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        $colors = [
            'bg-blue-700', 'bg-gray-700', 'bg-red-600', 'bg-green-600',
            'bg-yellow-600', 'bg-orange-700', 'bg-purple-700', 'bg-amber-800',
            'bg-fuchsia-900', 'bg-indigo-700', 'bg-sky-800',
        ];

        $classroom_form = [
            'name' => $request->name,
            'code' => fake()->bothify('????-????-##'),
            'color' => $colors[array_rand($colors)],
            'description' => $request->description,
        ];
        $classroom = Classroom::create($classroom_form);
        $user->classrooms()->syncWithoutDetaching([$classroom->id => ['owner' => true]]);

        $sections = explode(',', $request->sections);
        $sections = array_filter($sections, 'strlen');
        foreach ($sections as $section) {
            $section_form = [
                'classroom_id' => $classroom->id,
                'name' => $section
            ];
            Section::create($section_form);
        }

        flash()->addSuccess('Classroom added successfully');
        return back();
    }

    public function join(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|exists:classrooms,code',
                'section' => 'required|not_in:null|exists:sections,id',
            ],
            [
                'code.required' => 'Class code is required',
                'code.exists' => 'Class does not exists',
                'section.required' => 'Class section is required',
                'section.not_in' => 'Please section class section',
                'section.exists' => 'Section does not exists'
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = Auth::user();
        $classroom = Classroom::where('code', $request->code)->first();

        if (!$classroom->sections()->where('id', $request->section)->exists()) {
            flash()->addError('Selected section is not associated with selected class');
            return back();
        }

        $isOwner = DB::table('classroom_user')
            ->where('user_id', Auth::user()->id)
            ->where('classroom_id', $classroom->id)
            ->where('owner', 1)
            ->exists();

        if ($isOwner) {
            flash()->addError('You created this class');
            return back();
        }

        $user->classrooms()->syncWithoutDetaching([$classroom->id => ['owner' => false, 'section_id' => $request->section]], true);
        flash()->addSuccess('Joined class successfully');
        return back();
    }

    public function getSections(Request $request, $code)
    {
        $classroom = Classroom::where('code', $code)->first();
        if ($classroom == null) {
            return response()->json([
                'message' => 'Classroom not found',
                'sections' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Section fetched successfully',
            'sections' => $classroom->sections,
        ], 200);
    }
}
