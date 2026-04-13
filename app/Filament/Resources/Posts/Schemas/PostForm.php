<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
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
                                    ->rules('min:5 | max:10' ),

                                TextInput::make("slug")
                                    ->required()
                                    ->unique()
                                    ->rules('min:3')
                                    ->validationMessages([
                                        "unique" => "Slug harus unik"
                                    ]),

                                // TextInput::make("nama")
                                //     ->required(),

                                // TextInput::make("email")
                                //     ->required()
                                //     ->email(),

                                Select::make('category_id')
                                    ->required()
                                    ->options(Category::all()->pluck("name", "id"))
                                    ->relationship('category', 'name')
                                    // ->preload()
                                    ->searchable(),
                                ColorPicker::make("color"),
                                MarkdownEditor::make("content")
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Image')
                            ->description("Upload post image")
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')
                                    ->required()
                                    ->disk('public')
                                    ->directory('post')
                                    ->image()
                                    ->columnSpanFull(),
                            ])
                            ->columns(1),

                        Section::make('Meta Information')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                // TagsInput::make('tags')
                                Select::make("tags")
                                    ->relationship("tags","name")
                                    ->multiple()
                                    ->preload(),
                                Checkbox::make('published')
                                    ->label('Published')
                                    ->inline(),
                                DateTimePicker::make('published_at')
                                    ->label('Published At'),
                            ]),
                    ]),
            ]);
    }
}
