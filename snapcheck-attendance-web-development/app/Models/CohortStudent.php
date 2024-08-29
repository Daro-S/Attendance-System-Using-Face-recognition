<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CohortStudent extends Model
{
    use HasFactory;
    protected $table = 'cohort_students';

    protected $fillable = [
        'cohort_id',
        'student_id'
    ];
    public function cohort(){
        return $this->belongsTo(Cohort::class,'cohort_id','id');
    }

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
}
