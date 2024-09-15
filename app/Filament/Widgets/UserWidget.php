<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make("Users", User::count())
                ->description('New Users That Have Join')
                ->descriptionIcon('heroicon-s-user-group', IconPosition::Before)
                ->descriptionColor('success')
                ->chart([1, 10, 2, 0, 12, 23, 43, 1, 33, 2, 12])
                ->chartColor('info')
        ];
    }
}
