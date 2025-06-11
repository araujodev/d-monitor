<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;
use App\Models\Measurement;

class Glucose extends StatsOverviewWidget
{

    protected function getCards(): array
    {
        $highest1 = Measurement::query()
            ->where('measurement_type_enum', 5) // Pré Jantar
            ->orderByDesc('value')              // Maior valor primeiro
            ->orderByDesc('created_at')         // Mais recente em caso de empate
            ->first();

        $valor1 = $highest1?->value ?? '–';
        $data1 = $highest1?->created_at?->format('d/m/Y') ?? 'sem dados';

        $highest2 = Measurement::query()
            ->where('measurement_type_enum', 0) // Em Jejum
            ->orderByDesc('value')
            ->orderByDesc('created_at')
            ->first();

        $valor2 = $highest2?->value ?? '–';
        $data2 = $highest2?->created_at?->format('d/m/Y') ?? 'sem dados';

        return [

            Card::make('Maior Glicemia em Jejum', "{$valor2} mg/dL")
                ->description("Registrada em {$data2}")
                ->color('danger') // vermelho
                ->icon('heroicon-o-fire'),

            Card::make('Maior Glicemia Pré-Jantar', "{$valor1} mg/dL")
                ->description("Registrada em {$data1}")
                ->color('warning') // Amarelo (ou 'danger' se preferir vermelho)
                ->icon('heroicon-o-clock'),
        ];
    }


    protected function getColumns(): int
    {
        return 2;  // 2 cards por linha = lado a lado
    }

}
