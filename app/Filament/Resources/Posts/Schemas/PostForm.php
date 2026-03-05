<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make('Post Details')
                            ->description("Fill in the details of the post.")
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make("title")
                                    ->required()
                                    ->minLength(5)
                                    ->maxLength(255),
                                TextInput::make("slug")
                                    ->required()
                                    ->unique('posts')
                                    ->maxLength(255),
                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->columnSpanFull(),
                                ColorPicker::make("color")
                                    ->columnSpanFull(),
                                MarkdownEditor::make("content")
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        
                        Section::make('Image')
                            ->description("Upload post image")
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')
                                    ->disk('public')
                                    ->directory('post')
                                    ->image()
                                    ->columnSpanFull(),
                            ])
                            ->columns(1),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Meta')
                            ->description("Publish & Tags")
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Checkbox::make('published')
                                    ->label('Published')
                                    ->inline(),
                                DateTimePicker::make('published_at')
                                    ->label('Published At'),
                            ])
                            ->columns(1),

                        Section::make('Tags')
                            ->description("Post tags")
                            ->icon('heroicon-o-tag')
                            ->schema([
                                TagsInput::make('tags')
                                    ->label('Tags'),
                            ])
                            ->columns(1),
                    ]),
            ]);
    }
}