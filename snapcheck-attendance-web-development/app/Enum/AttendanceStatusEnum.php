<?php

namespace App\Enum;

enum AttendanceStatusEnum
{
    const ON_TIME = 'on_time';
    const LATE = 'late';

    const ABSENT = 'absent';

    public static function getStatuses(): array
    {
        return [
            self::ON_TIME,
            self::LATE,
            self::ABSENT
        ];
    }
}
