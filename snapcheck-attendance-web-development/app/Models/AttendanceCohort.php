<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCohort extends Model
{
    use HasFactory;

    protected $table = 'attendance_cohorts';

    protected $fillable = [
        'attendance_id',
        'cohort_id'
    ];
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

}
