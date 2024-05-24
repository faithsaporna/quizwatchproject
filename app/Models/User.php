<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)->withPivot('owner', 'section_id');;
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getAnswer($assessment_id)
    {
        return Answer::where('user_id', $this->id)->where('assessment_id', $assessment_id)->first();
    }

    public function getOwnedClassrooms()
    {
        return $this->classrooms()->wherePivot('owner', 1)->get();
    }

    public function getJoinedClassrooms()
    {
        return $this->classrooms()->wherePivot('owner', 0)->get();
    }

    public function getLatestAssessment()
    {
        $classrooms = $this->classrooms()->with('assessments')->get();
        $assessments = collect();
        foreach ($classrooms as $classroom) {
            $assessments = $assessments->merge($classroom->assessments);
        }
        $assessment = $assessments->sortByDesc('created_at')->first();
        return $assessment;
    }
}
