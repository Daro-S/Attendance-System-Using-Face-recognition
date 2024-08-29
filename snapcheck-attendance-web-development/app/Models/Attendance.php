<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attendance
 * @package App\Models
 * @property int id
 * @property int cohort_id
 * @property int course_id
 * @property string time_start
 * @property string time_end
 * @property bool is_expired
 * @property bool is_defined_absent
 * @property string date
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attendances';
    protected $fillable = [
        'course_id',
        'time_start',
        'time_end',
        'date'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // Define the relationship with cohort
    /*public function cohort() {
        return $this->belongsTo(Cohort::class);
    }*/
    public function cohorts(): BelongsToMany
    {
        return $this->belongsToMany(Cohort::class, 'attendance_cohorts', 'attendance_id', 'cohort_id');
    }
    public function cohortattendances(): HasMany
    {
        return $this->hasMany(AttendanceCohort::class);
    }

}
