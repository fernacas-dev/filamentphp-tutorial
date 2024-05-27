<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user())),
            Stat::make('Approved Holidays', $this->getApproveHolidays(Auth::user())),
            Stat::make('Total Work', $this->getTotalWork(Auth::user())),
        ];
    }

    protected function getPendingHolidays(User $user)
    {
        $totalPendingHolidays = Holiday::where('user_id', '=', $user->id)
            ->where('type', 'pending')->get()->count();

        return $totalPendingHolidays;
    }

    protected function getApproveHolidays(User $user)
    {
        $totalApprovedHolidays = Holiday::where('user_id', '=', $user->id)
            ->where('type', 'approve')->get()->count();

        return $totalApprovedHolidays;
    }

    protected function getTotalWork(User $user)
    {
        $timesheets = Timesheet::query()->where('user_id', '=', $user->id)
            ->where('type', 'work')
            ->get();

        $sum = 0;

        foreach($timesheets as $timesheet) {
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);
            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sum += $totalDuration;
        }

        $tiempoCarbon = gmDate('H:i:s', $sum);

        return $tiempoCarbon;
    }
}
