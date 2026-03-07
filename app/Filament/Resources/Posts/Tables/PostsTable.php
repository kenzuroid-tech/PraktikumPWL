<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable(), // ✅ No.1 - sudah ada

                TextColumn::make('slug')
                    ->sortable(), // ✅ No.1 - sudah ada

                TextColumn::make('category.name')
                    ->sortable(), // ✅ No.1 - sudah ada

                ColorColumn::make('color'),
                // ColorColumn tidak support sortable

                ImageColumn::make('image')
                    ->disk('public'),
                // ImageColumn tidak support sortable

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(), // ✅ No.1 - sudah ada
            ])
            ->defaultSort('created_at', 'desc') // ✅ No.2 - ubah 'asc' -> 'desc'
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}