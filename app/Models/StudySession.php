<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    use HasFactory;

    protected $table = 'study_session';

    protected $fillable = ['user_id', 'subject', 'duration', 'memo', 'study_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
