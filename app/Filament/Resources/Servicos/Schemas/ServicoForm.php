<?php

namespace App\Filament\Resources\Servicos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServicoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                Textarea::make('descricao')
                    ->columnSpanFull(),
                TextInput::make('preco')
                    ->required()
                    ->numeric(),
                TextInput::make('duracao_minutos')
                    ->required()
                    ->numeric()
                    ->default(30),
                Toggle::make('ativo')
                    ->required(),
            ]);
    }
}
