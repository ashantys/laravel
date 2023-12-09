<?php

namespace App\Filament\Pages\Calendar\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Task::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Task::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->name,
                    'start' => $task->start,
                    'end' => $task->end,
                    
                ];
            })
            ->all();
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /* protected function viewAction(): Action
    {
        return Actions\ViewAction::make();
    } */

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name'),

            Grid::make()
                ->schema([
                    DateTimePicker::make('start'),

                    DateTimePicker::make('end'),
                ]),
        ];
    }
}
