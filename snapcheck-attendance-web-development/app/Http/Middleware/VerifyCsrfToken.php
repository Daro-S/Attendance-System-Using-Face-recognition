<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/attendance/getAttendanceIdByCourseId',
        'api/attendance/getCohortsByAttendanceId',
        'api/attendance/getAttendanceById',
        'admin/attendance_camera_or_statistic',
        'admin/attendance_report_specific_course_session',
        'api/attendance/destroy/*'
    ];
}
