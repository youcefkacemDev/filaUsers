<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use App\Filament\Exports\UserExporter;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use function GuzzleHttp\default_ca_bundle;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\UserResource\RelationManagers\PostsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\CategoriesRelationManager;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = "Users";

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $activeNavigationIcon = 'heroicon-s-users';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email(),
                TextInput::make('password')->password()->visibleOn('create'),
                Select::make('is_admin')
                    ->options([
                        true => 'admin',
                        false => 'user',
                    ]),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('posts_count')->counts('posts'),
                TextColumn::make('categories_count')->counts('categories'),
                TextColumn::make('is_admin')
                    ->label('Role')
                    ->badge()
                    ->color(
                        function(string $state) : string
                        {
                            return match($state){
                                "1" => "success",
                                "0" => "info",
                            };
                        }
                    )
                    ->formatStateUsing(
                        function (string $state): string {
                            if ($state) {
                                return "ADMIN";
                            } else {
                                return "USER";
                            }
                        }
                    ),
            ])
            ->filters([
                TernaryFilter::make('is_admin')
                    ->falseLabel('user')
                    ->placeholder('all')
                    ->trueLabel('admin'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    // ->formats([ExportFormat::Csv])
                    ->exporter(UserExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->exporter(UserExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,
            CategoriesRelationManager::class,
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
