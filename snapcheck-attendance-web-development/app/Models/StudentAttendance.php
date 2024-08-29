<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static get()
 * @method static where(string $string, $id)
 * @property mixed $student_id
 * @property mixed $attendance_id
 * @property mixed|string $status
 * @property mixed $probability
 * @property mixed $cohort_id
 * @property mixed $capture_at
 */
class StudentAttendance extends Model
{
    use HasFactory;

    protected $table = 'student_attendances';
    protected $fillable = [
        'attendance_id',
        'student_id',
        'cohort_id',
        'capture_at',
        'status',
        'capture_image_path',
        'probability'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function cohort(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }
}
