<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'color',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('owner', 'section_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class)->latest();
    }

    public function getScoreAverage()
    {
        $avg = $this->assessments()->with('answers')->get()->map(function ($assessment) {
            return $assessment->answers()->avg('score');
        });
        return $avg->first();
    }
}
