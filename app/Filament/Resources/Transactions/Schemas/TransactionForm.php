<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                TextInput::make('customer_name'),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $product = \App\Models\Product::find($state);
                                if ($product) {
                                    $total = collect($state)->sum('subtotal');
                                    $set('total_price', $total);
                                    $set('price', $product->price);
                                    $set('subtotal', $product->price * 1);
                                }
                            }),
                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $price = $get('price');
                                $set('subtotal', $price * $state);
                            })
                            ->reactive(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),
                    ])
            ]);
    }
}
