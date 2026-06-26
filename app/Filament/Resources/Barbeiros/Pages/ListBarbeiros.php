<?php

namespace App\Filament\Resources\Barbeiros\Pages;

use App\Filament\Resources\Barbeiros\BarbeiroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBarbeiros extends ListRecords
{
    protected static string $resource = BarbeiroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
