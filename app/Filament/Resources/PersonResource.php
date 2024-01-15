<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use App\Filament\Resources\PersonResource\RelationManagers;
use App\Models\Person;
use App\Models\Team;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;
    protected static ?string $label = 'Pessoa';
    protected static ?string $pluralModelLabel = 'Pessoas';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tipo')
                    ->schema([
                        Radio::make('is_teen')
                            ->label('Adolescente ou Tio?')
                            ->options([
                                true => 'Adolescente',
                                false => 'Tio',
                            ])
                            ->inline(),
                        Radio::make('is_coordinator')
                            ->label('Coordenador ou equipista?')
                            ->options([
                                true => 'Coordenador',
                                false => 'Equipista',
                                null => 'Não informar',
                            ])
                            ->inline(),
                    ]),
                    Section::make('Dados')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nome')
                                ->required(),
                            TagsInput::make('phones')
                                ->label('Telefone(s)'),
                            TextInput::make('address')
                                ->label('Endereço'),
                            TextInput::make('city')
                                ->label('Bairro - Cidade'),
                            
                        ]),
                Section::make('Sobre')
                    ->columns(2)
                    ->schema([
                        Select::make('status_id')
                            ->label('Status')
                            ->relationship(name: 'status', titleAttribute: 'name')
                            ->default(1),
                        Select::make('team_id')
                            ->label('Equipe')
                            ->preload()
                            ->searchable()
                            ->relationship(name: 'team', titleAttribute: 'name'),
                    ])
                
                
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_teen')
                    ->label('Adolescente')
                    ->boolean(),
                IconColumn::make('is_coordinator')
                    ->label('Coordenador')
                    ->icon(fn (bool $state): string => match ($state) {
                        true => 'heroicon-o-check-circle',
                        false => 'heroicon-o-x-circle',
                    }),
             
                TextColumn::make('address')
                    ->label('Endereço'),
                TextColumn::make('city')
                    ->label('Bairro - Cidade'),
                TextColumn::make('phones')
                    ->label('Telefone(s)'),
                TextColumn::make('team.name')
                    ->label('Equipe'),
            ])
            ->filters([
                SelectFilter::make('team_id')
                    ->label('Equipe')
                    ->relationship('team', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }
}
