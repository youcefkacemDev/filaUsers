<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use League\Csv\Serializer\CastToArray;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Carbon;

class UserWidget extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $users = Trend::model(User::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(),
                end: $end ? Carbon::parse($end) : now(),
            )
            ->perDay()
            ->count();

        $posts = Trend::model(Post::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(),
                end: $end ? Carbon::parse($end) : now(),
            )
            ->perDay()
            ->count();

        $categories = Trend::model(Category::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(),
                end: $end ? Carbon::parse($end) : now(),
            )
            ->perDay()
            ->count();

        return [
            Stat::make(
                "Users",
                User::when($start, fn($query) => $query->where('created_at', '>', $start))
                    ->when($end, fn($query) => $query->where('created_at', '<', $end))
                    ->count()
            )
                ->description('New Users That Have Join')
                ->descriptionIcon('heroicon-s-user-group', IconPosition::Before)
                ->descriptionColor('success')
                ->chart($users->map(fn(TrendValue $value) => $value->aggregate)->toarray())
                ->chartColor('info'),

            Stat::make(
                "Posts",
                Post::when($start, fn($query) => $query->where('created_at', '>', $start))
                    ->when($end, fn($query) => $query->where('created_at', '<', $end))
                    ->count()
            )
                ->description('New Posts Created')
                ->descriptionIcon('heroicon-s-document-chart-bar', IconPosition::Before)
                ->descriptionColor('success')
                ->chart($posts->map(fn(TrendValue $value) => $value->aggregate)->toarray())
                ->chartColor('info'),

            Stat::make(
                "Categories",
                Category::when($start, fn($query) => $query->where('created_at', '>', $start))
                    ->when($end, fn($query) => $query->where('created_at', '<', $end))
                    ->count()
            )
                ->description('New Categories Created')
                ->descriptionIcon('heroicon-s-tag', IconPosition::Before)
                ->descriptionColor('success')
                ->chart($categories->map(fn(TrendValue $value) => $value->aggregate)->toarray())
                ->chartColor('info')
        ];
    }
}
