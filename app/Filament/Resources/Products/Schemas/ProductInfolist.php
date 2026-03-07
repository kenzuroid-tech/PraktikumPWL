<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Product Tabs')
                    ->tabs([

                        // ✅ No.4 - Icon berbeda tiap tab
                        Tab::make('Product Details')
                            ->icon('heroicon-o-information-circle') // icon ditambah
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('id')
                                    ->label('Product ID'),

                                // ✅ No.2 - Badge SKU warna berbeda
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('warning'), // warna berbeda dari success

                                TextEntry::make('description')
                                    ->label('Product Description'),
                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y')
                                    ->color('info'),
                            ]),

                        // ✅ No.1 - Badge dinamis berdasarkan jumlah stok
                        // ✅ No.2 - Warna badge berbeda (info/warning/danger) sesuai stok
                        Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar') // ✅ No.4
                            ->badge(fn($record) => $record?->stock ?? 0) // dinamis dari DB
                            ->badgeColor(fn($record) => match(true) {
                                ($record?->stock ?? 0) > 20  => 'success', // hijau: stok banyak
                                ($record?->stock ?? 0) > 5   => 'warning', // kuning: stok sedang
                                default                      => 'danger',  // merah: stok sedikit
                            })
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                TextEntry::make('stock')
                                    ->label('Stock')
                                    ->icon('heroicon-o-archive-box'),
                            ]),

                        Tab::make('Media & Status')
                            ->icon('heroicon-o-photo') // ✅ No.4
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),
                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                            ]),

                    ])
                    ->columnSpanFull()
                    ->vertical(), // ✅ No.3 - Tampilan vertical

            ]);
    }
}