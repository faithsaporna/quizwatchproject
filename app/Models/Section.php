<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'classroom_id',
        'name',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('classroom_id')->groupBy('classroom_id');
    }
}
