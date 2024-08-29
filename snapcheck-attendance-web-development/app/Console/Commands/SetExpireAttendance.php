<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetExpireAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-expire-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = now();
        $expiredAttendance = Attendance::where(function ($query) use ($now) {
                $query->whereDate('date', '<', $now->toDateString())
                    ->orWhere(function ($query) use ($now) {
                        $query->whereDate('date', '=', $now->toDateString())
                            ->where(DB::raw('CONCAT(date, " ", time_end)'), '<', $now->toDateTimeString());
                    });
            })
            ->where('is_expired', 0)
            ->first();
//        dd($expiredAttendance);
        if (empty($expiredAttendance)) {
            $this->info('No expired attendance found');
            return;
        }
        $expiredAttendance->is_expired = 1;
        $expiredAttendance->save();
        $this->info('1 Expired attendance set successfully');
        //$this->info('Custom task executed successfully!');
    }
}
