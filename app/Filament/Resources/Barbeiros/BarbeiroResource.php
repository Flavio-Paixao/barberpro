<?php

namespace App\Filament\Resources\Barbeiros;

use App\Filament\Resources\Barbeiros\Pages\CreateBarbeiro;
use App\Filament\Resources\Barbeiros\Pages\EditBarbeiro;
use App\Filament\Resources\Barbeiros\Pages\ListBarbeiros;
use App\Filament\Resources\Barbeiros\Schemas\BarbeiroForm;
use App\Filament\Resources\Barbeiros\Tables\BarbeirosTable;
use App\Models\Barbeiro;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BarbeiroResource extends Resource
{
    protected static ?string $model = Barbeiro::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return BarbeiroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BarbeirosTable::configure($table);
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
            'index' => ListBarbeiros::route('/'),
            'create' => CreateBarbeiro::route('/create'),
            'edit' => EditBarbeiro::route('/{record}/edit'),
        ];
    }
}
