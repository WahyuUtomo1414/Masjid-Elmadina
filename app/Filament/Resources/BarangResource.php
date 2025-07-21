<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use App\Models\Pengurus;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Barang';

    protected static ?string $label = 'Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pengurus_id')
                    ->required()
                    ->label('Pengurus')
                    ->searchable()
                    ->columnSpanFull()
                    ->options(Pengurus::pluck('nama', 'id')),
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Barang')
                    ->maxLength(128),
                TextInput::make('stok')
                    ->required()
                    ->label('Stok Barang')
                    ->numeric(),
                Select::make('status_barang')
                    ->required()
                    ->options([
                        'layak' => 'Layak',
                        'tidak layak' => 'Tidak Layak',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pengurus.nama')
                    ->label('Nama Pengurus'),
                TextColumn::make('nama')
                    ->searchable()
                    ->label('Nama Barang'),
                TextColumn::make('stok')
                    ->label('Stok Barang')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status_barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
