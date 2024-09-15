<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = "Blog";

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $activeNavigationIcon = 'heroicon-s-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(Filament::auth()->id()),
                Tabs::make('create new post')->tabs([
                    Tab::make('Post information')
                        ->icon('heroicon-o-arrow-up-on-square-stack')
                        ->iconPosition(IconPosition::After)
                        ->badge(4)
                        ->badgeColor('success')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->minLength(3)
                                ->maxLength(10),
                            TextInput::make('slog')
                                ->unique(ignoreRecord: true)
                                ->required(),
                            TagsInput::make('tags')
                                ->required(),
                            ColorPicker::make('color')
                                ->required(),
                        ]),

                    Tab::make('Content')
                        ->icon('heroicon-o-chat-bubble-bottom-center')
                        ->iconPosition(IconPosition::After)
                        ->schema([
                            MarkdownEditor::make('content')
                                ->columnSpanFull()
                                ->required(),
                        ]),

                    Tab::make('Meta')
                        ->icon('heroicon-o-document-duplicate')
                        ->iconPosition(IconPosition::After)
                        ->schema([
                            FileUpload::make('thumbnail')
                                ->disk('public')
                                ->directory('thumbnail'),
                            Radio::make('publish')
                                ->boolean()
                                ->inline(),
                            Select::make('categories')
                                ->relationship('categories', 'name')
                                ->hiddenOn('edit')
                                ->preload()
                                ->multiple()
                                ->required(),
                        ]),
                ])->columnSpanFull()->activeTab(1)->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('title')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slog')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tags')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('categories.name')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('created by')
                    ->toggleable()
                    ->searchable(),
                ToggleColumn::make('publish')
                    ->toggleable(isToggledHiddenByDefault: true),
                ColorColumn::make('color')
                    ->toggleable(),
                ImageColumn::make('thumbnail')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->toggleable()
                    ->date('d m Y')
                    ->label('posted at'),
            ])
            ->filters([
                Filter::make('pubished')->query(function (Builder $query) {
                    return $query->where('publish', true);
                }),

                SelectFilter::make('user_id')
                    ->label('users')
                    ->options(User::all()->pluck('name', 'id')),

                SelectFilter::make('categories')
                    ->label('category')
                    ->relationship('categories', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
