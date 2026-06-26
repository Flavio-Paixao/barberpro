<?php

namespace App\Filament\Resources\Agendamentos;

use App\Filament\Resources\Agendamentos\Pages\CreateAgendamento;
use App\Filament\Resources\Agendamentos\Pages\EditAgendamento;
use App\Filament\Resources\Agendamentos\Pages\ListAgendamentos;
use App\Filament\Resources\Agendamentos\Schemas\AgendamentoForm;
use App\Filament\Resources\Agendamentos\Tables\AgendamentosTable;
use App\Models\Agendamento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AgendamentoResource extends Resource
{
    protected static ?string $model = Agendamento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'cliente_nome';

    public static function form(Schema $schema): Schema
    {
        return AgendamentoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgendamentosTable::configure($table);
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
            'index' => ListAgendamentos::route('/'),
            'create' => CreateAgendamento::route('/create'),
            'edit' => EditAgendamento::route('/{record}/edit'),
        ];
    }
}
