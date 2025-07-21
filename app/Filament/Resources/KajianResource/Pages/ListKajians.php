<?php

namespace App\Filament\Resources\KajianResource\Pages;

use App\Filament\Resources\KajianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKajians extends ListRecords
{
    protected static string $resource = KajianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
