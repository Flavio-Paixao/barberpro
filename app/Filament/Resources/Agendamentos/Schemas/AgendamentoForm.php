<?php

namespace App\Filament\Resources\Agendamentos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AgendamentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barbeiro_id')
                    ->relationship('barbeiro', 'id')
                    ->required(),
                Select::make('servico_id')
                    ->relationship('servico', 'id')
                    ->required(),
                TextInput::make('cliente_nome')
                    ->required(),
                TextInput::make('cliente_telefone')
                    ->tel()
                    ->required(),
                DatePicker::make('data')
                    ->required(),
                TimePicker::make('horario')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pendente'),
                Toggle::make('lembrete_enviado')
                    ->required(),
                Textarea::make('observacoes')
                    ->columnSpanFull(),
            ]);
    }
}
