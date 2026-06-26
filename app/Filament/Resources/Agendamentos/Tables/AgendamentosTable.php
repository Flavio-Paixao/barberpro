<?php

namespace App\Filament\Resources\Agendamentos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgendamentosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barbeiro.id')
                    ->searchable(),
                TextColumn::make('servico.id')
                    ->searchable(),
                TextColumn::make('cliente_nome')
                    ->searchable(),
                TextColumn::make('cliente_telefone')
                    ->searchable(),
                TextColumn::make('data')
                    ->date()
                    ->sortable(),
                TextColumn::make('horario')
                    ->time()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                IconColumn::make('lembrete_enviado')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
