<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static withCount(array $array)
 */
class Cohort extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cohorts';

    protected $fillable = [
        'name',
        'profile_path'
    ];
    public function  students(): belongsToMany
    {
        // it has cohort_students table with cohort_id and student_id as relation between students and cohorts
        return $this->belongsToMany(Student::class, 'cohort_students', 'cohort_id', 'student_id');
    }
    public function attendanceCohorts()
    {
        return $this->hasMany(AttendanceCohort::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_cohorts');
    }

}
