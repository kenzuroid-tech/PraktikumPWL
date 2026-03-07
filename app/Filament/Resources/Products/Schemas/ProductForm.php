<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Product Info')
                        ->description('Isi Informasi Produk')
                        ->icon(Heroicon::OutlinedInformationCircle)
                        ->schema([
                            Group::make([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('sku')
                                    ->required()
                            ])->columns(2),
                            MarkdownEditor::make('description')

                        ]),

                    Step::make('Pricing & Stock')
                        ->description('Isi harga dan jumlah stok')
                        ->icon(Heroicon::OutlinedCurrencyDollar)
                        ->schema([
                            TextInput::make('price')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->validationMessages([
                                    'min' => 'Harga harus lebih besar dari 0',
                                ]),
                            TextInput::make('stock')
                                ->numeric()
                                ->required(),
                        ]),
                    Step::make('Media & Status')
                        ->description('Upload gambar dan atur status')
                        ->icon(Heroicon::OutlinedPhoto)
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products'),
                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ]),

                ])
                    ->columnSpanFull()
                    ->submitAction(
                        Action::make('save')
                            ->label('Save Product')
                            ->button()
                            ->color('primary')
                            ->submit('save')
                    )
            ]);
    }
}
