<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatisticsWidget extends BaseWidget
{
    public ?User $record;

    protected function getStats(): array
    {
        return [
            Stat::make('user posts', $this->record->posts()->count())
                ->description('these all the posts that this user created')
                ->descriptionColor('success')
                ->icon('heroicon-s-squares-plus'),

            Stat::make('user categories', $this->record->categories()->count())
                ->description('these all the categories that this user created')
                ->descriptionColor('warning')
                ->icon('heroicon-s-tag'),

            Stat::make('user comments', $this->record->comments()->count())
                ->description('these all the comments that this user created')
                ->descriptionColor('info')
                ->icon('heroicon-s-chat-bubble-left-ellipsis'),
        ];
    }
}
