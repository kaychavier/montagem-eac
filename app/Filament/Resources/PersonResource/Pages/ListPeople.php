<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPeople extends ListRecords
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'waiting' => Tab::make('Em espera')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('status', fn(Builder $q) => $q->where('name', 'Em espera')))
                ->icon('heroicon-o-clock'),
            'active' => Tab::make('Ativos')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('status', fn(Builder $q) => $q->where('name', 'Ativo')))
                ->icon('heroicon-o-check-circle'),
            'inactive' => Tab::make('Desligados')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('status', fn(Builder $q) => $q->where('name', 'Desligado')))
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
