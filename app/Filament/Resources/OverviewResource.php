<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OverviewResource\Pages;
use App\Filament\Resources\OverviewResource\RelationManagers;
use App\Models\Overview;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OverviewResource extends Resource
{
    protected static ?string $model = Overview::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('project_name')
                ->required()
                ->maxLength(255)
                ->label('Project Name'),

            TextInput::make('contract_value')
                ->numeric()
                ->required()
                ->label('Contract Value'),

            TextInput::make('work_done')
                ->numeric()
                ->required()
                ->label('Work Done'),
                Select::make('status')
                    ->options([
                        'Done' => 'Done',
                        'Work in Progress' => 'Work in Progress',
                    ])
                    ->required()
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_name')->label('Project Name')->sortable()->searchable(),
                TextColumn::make('contract_value')->label('Contract Value')->sortable(),
                TextColumn::make('work_done')->label('Work Done')->sortable(),
                TextColumn::make('status')->label('Status')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOverviews::route('/'),
            'create' => Pages\CreateOverview::route('/create'),
            'edit' => Pages\EditOverview::route('/{record}/edit'),
        ];
    }
}
