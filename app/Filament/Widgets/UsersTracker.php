<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UsersTracker extends ChartWidget
{
    protected int | string | array $columnSpan = 1;

    protected static ?string $heading = 'Users';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->subMonths(),
                end: now(),
            )
            ->perDay()
            ->count();
            
        return [
            'datasets' => [
                [
                    'label' => 'users join in months ',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
