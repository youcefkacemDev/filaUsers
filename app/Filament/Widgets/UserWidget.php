<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use League\Csv\Serializer\CastToArray;

class UserWidget extends BaseWidget
{

    protected function getStats(): array
    {
        $users = Trend::model(User::class)
        ->between(
            start: now()->subMonths(),
            end: now(),
        )
        ->perDay()
        ->count();

        $posts = Trend::model(Post::class)
        ->between(
            start: now()->subMonths(),
            end: now(),
        )
        ->perDay()
        ->count();

        $categories = Trend::model(Category::class)
        ->between(
            start: now()->subMonths(),
            end: now(),
        )
        ->perDay()
        ->count();
        return [
            Stat::make("Users", User::count())
                ->description('New Users That Have Join')
                ->descriptionIcon('heroicon-s-user-group', IconPosition::Before)
                ->descriptionColor('success')
                ->chart($users->map(fn (TrendValue $value) => $value->aggregate)->toarray())
                ->chartColor('info'),

            Stat::make("Posts", Post::count())
                ->description('New Posts Created')
                ->descriptionIcon('heroicon-s-document-chart-bar', IconPosition::Before)
                ->descriptionColor('success')
                ->chart($posts->map(fn (TrendValue $value) => $value->aggregate)->toarray())
                ->chartColor('info'),

            Stat::make("Categories", Category::count())
                ->description('New Categories Created')
                ->descriptionIcon('heroicon-s-tag', IconPosition::Before)
                ->descriptionColor('success')
                ->chart($categories->map(fn (TrendValue $value) => $value->aggregate)->toarray())
                ->chartColor('info')
        ];
    }
}
