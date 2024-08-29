<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


class Course extends Model
{
    use SoftDeletes;

    /**
     * App\Models\Group
     * @property int $id
     * @property string $name
     * @property string $description
     * @property string $color
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     */
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'description',
        'color'
    ];
}
