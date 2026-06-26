<?php

namespace App\Filament\Resources\Barbeiros\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BarbeiroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('especialidade'),
                TextInput::make('telefone')
                    ->tel(),
                Toggle::make('ativo')
                    ->required(),
                Textarea::make('dias_trabalho')
                    ->columnSpanFull(),
                TimePicker::make('hora_inicio')
                    ->required(),
                TimePicker::make('hora_fim')
                    ->required(),
            ]);
    }
}
