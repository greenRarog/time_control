<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lesson extends Model
{
    use HasFactory;
    protected $with = ['user'];
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
