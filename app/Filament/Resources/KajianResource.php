<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kajian;
use App\Models\Ustadz;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KajianResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KajianResource\RelationManagers;

class KajianResource extends Resource
{
    protected static ?string $model = Kajian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ustadz_id')
                    ->required()
                    ->label('Ustadz')
                    ->searchable()
                    ->columnSpanFull()
                    ->options(Ustadz::pluck('nama', 'id')),
                Textarea::make('judul_kajian')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                DatePicker::make('tanggal_kajian')
                    ->native(false)
                    ->required(),
                TextInput::make('jam_kajian')
                    ->label('Jam Kajian')
                    ->type('time')
                    ->required(),
                Textarea::make('keterangan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ustadz_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul_kajian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kajian')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_kajian')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListKajians::route('/'),
            'create' => Pages\CreateKajian::route('/create'),
            'edit' => Pages\EditKajian::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
