<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Corrunt User', auth()->user()->name)
                ->description(auth()->user()->email)
                ->descriptionColor('info')
                ->icon('heroicon-s-user'),
            Stat::make('Admin Users', User::where('is_admin', '1')->count())
                ->description('users that can access the admin panel')
                ->descriptionColor('success')
                ->icon('heroicon-s-user-circle'),
            Stat::make('Regular Users', User::where('is_admin', '0')->count())
                ->description('users the have apility to use the platform')
                ->descriptionColor('warning')
                ->icon('heroicon-s-user-group')
        ];
    }
}
