<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Inwork')
                ->keyBindings(['command+s', 'ctrl+s'])
                ->color('success')
                ->requiresConfirmation()
                ->label('Entrar a trabajar')
                ->action(function() {
                    $user = Auth::user();
                    $timesheet = new Timesheet();
                    $timesheet->user_id = $user->id;
                    $timesheet->calendar_id = 1;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->day_out = Carbon::now();
                    $timesheet->save();
                })
                ,
            Action::make('InPause')
                ->color('info')
                ->requiresConfirmation()
                ->label('Comenzar pausa'),

            Actions\CreateAction::make(),
        ];
    }
}
