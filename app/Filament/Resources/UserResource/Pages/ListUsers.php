<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
// use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),

            'admins' => Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_admin', true);
            }),

            'users' => Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_admin', false);
            }),
        ];
    }
}
