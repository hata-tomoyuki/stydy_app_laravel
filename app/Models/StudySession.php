<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function scopeBetweenDate($query, $startDate, $endDate)
    {
        return $query->whereBetween('study_date', [$startDate, $endDate]);
    }
}
