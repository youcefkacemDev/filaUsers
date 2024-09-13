<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Create a Post")
                    ->description("here you can create your post")
                    ->collapsible()
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
                        MarkdownEditor::make('content')
                            ->columnSpanFull()
                            ->required(),
                    ])->columnSpan(2)->columns(4),
                Group::make()->schema([
                    Section::make('Image')
                        ->schema([
                            FileUpload::make('thumbnail')
                                ->disk('public')
                                ->directory('thumbnail'),
                        ])->columnSpan(1),
                    Section::make('Meta')
                        ->schema([
                            Radio::make('publish')
                                ->boolean()
                                ->inline(),
                            Select::make('categories')
                                ->relationship('categories', 'name')
                                ->multiple()
                                ->required(),
                        ]),
                    Hidden::make('user_id')
                        ->default(Filament::auth()->id()),
                ]),

            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('slog'),
                TextColumn::make('tags'),
                ToggleColumn::make('publish'),
                ColorColumn::make('color'),
                TextColumn::make('created_at')
                    ->date('d m Y')
                    ->label('posted at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
