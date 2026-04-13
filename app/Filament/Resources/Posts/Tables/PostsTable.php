<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ColorColumn::make('color')
                    ->toggleable(),

                ImageColumn::make('image')
                    ->disk('public')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('published')
                    ->boolean()
                    ->toggleable(),
            ])->defaultSort('created_at', 'asc')
            ->filters([
                Filter::make('created_at')
                    ->label('Creation Date')
                    ->schema([
                        DatePicker::make('created_at')
                            ->label('Select Date : ')
                    ])
                    ->query(function ($query, $data) {
                        return $query
                            ->when(
                                $data['created_at'],
                                fn($query, $date) => $query->whereDate('created_at', $date),
                            );
                    }),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),
            ])
            ->recordActions([
                ReplicateAction::make()
                    ->icon('heroicon-o-document-duplicate'),

                EditAction::make()
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->icon('heroicon-o-trash'),

                Action::make('toggle_publish')
                    ->label(fn($record) => $record->published ? 'Unpublish' : 'Publish')
                    ->icon(fn($record) => $record->published
                        ? 'heroicon-o-eye-slash'
                        : 'heroicon-o-eye')
                    ->color(fn($record) => $record->published
                        ? 'danger'
                        : 'success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'published' => !$record->published,
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
