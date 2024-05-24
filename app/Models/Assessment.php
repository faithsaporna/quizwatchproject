<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Assessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'classroom_id',
        'title',
        'description',
        'total',
        'data',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('score', 'desc');
    }

    public function getStatusByUser($user_id)
    {
        $user = User::find($user_id);
        if ($user == null) {
            return "Unknown";
        }
        if ($user->getAnswer($this->id) == null) {
            return "Unanswered";
        }
        if ($user->getAnswer($this->id)->score == null) {
            return "Unmarked";
        }

        return "Marked";
    }

    public function getScoreByUser($user_id)
    {
        $user = User::find($user_id);
        if ($user == null) {
            return null;
        }

        $answer = Answer::where('user_id', $user_id)
            ->where('assessment_id', $this->id)
            ->first();

        if ($answer == null) {
            return null;
        }

        return $answer->score;
    }

    public function getSectionAverage()
    {
        $average = DB::table('answers')
            ->join('classroom_user', 'answers.user_id', '=', 'classroom_user.user_id')
            ->join('sections', 'classroom_user.section_id', '=', 'sections.id')
            ->select('sections.name', DB::raw('AVG(answers.score) as average_score'))
            ->where('answers.assessment_id', $this->id)
            ->groupBy('classroom_user.section_id')
            ->pluck('average_score', 'sections.name')
            ->toArray();

        return $average;
    }
}
