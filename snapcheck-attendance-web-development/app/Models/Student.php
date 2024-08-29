<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(mixed $student_id)
 * @property mixed id
 * @property mixed name
 */
class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'students';
    protected $fillable = [
        'name',
        'profile_path',
        'gender',
        'cohort_id',
        'label_id'
    ];

    public function cohort()
    {
        return $this->hasOneThrough(Cohort::class, CohortStudent::class, 'student_id', 'id', 'id', 'cohort_id');
    }
    public function studentDetails(): HasMany
    {
        return $this->hasMany(StudentDetail::class, 'student_id');
    }
    public function cohortStudent(): HasOne
    {
        return $this->hasOne(CohortStudent::class,'student_id');
    }
}
