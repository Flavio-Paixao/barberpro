<?php

namespace App\Filament\Resources\Barbeiros\Pages;

use App\Filament\Resources\Barbeiros\BarbeiroResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBarbeiro extends EditRecord
{
    protected static string $resource = BarbeiroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
