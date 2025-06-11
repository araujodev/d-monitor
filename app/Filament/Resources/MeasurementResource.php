<?php

namespace App\Filament\Resources;

use App\Enums\MeasurementTypeEnum;
use App\Filament\Resources\MeasurementResource\Pages;
use App\Models\Measurement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;

class MeasurementResource extends Resource
{
    protected static ?string $model = Measurement::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->label('Glicemia mg/dL')
                    ->numeric(),
                Forms\Components\Select::make('measurement_type_enum')
                    ->label('Tipo de medida (horario)')
                    ->options(MeasurementTypeEnum::getMappedLabels())
                    ->required(),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->numeric()
                    ->label('Glicemia mg/dL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('measurement_type_enum')
                    ->getStateUsing(function (Measurement $record) {
                        return MeasurementTypeEnum::getDescription($record->measurement_type_enum);
                    })
                    ->label('Tipo de medida (horario)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Data/Hora da medicao')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('measurement_type_enum')
                    ->options(MeasurementTypeEnum::getMappedLabels()),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMeasurements::route('/'),
        ];
    }
}
