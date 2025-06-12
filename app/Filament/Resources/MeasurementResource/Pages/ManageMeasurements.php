<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Resources\MeasurementResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageMeasurements extends ManageRecords
{
    protected static string $resource = MeasurementResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderByDesc('created_at');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
