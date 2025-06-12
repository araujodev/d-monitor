<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Enums\MeasurementTypeEnum;
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
        $data1 = $highest1?->created_at?->format('d/m/Y H:i') ?? 'sem dados';

        $highest2 = Measurement::query()
            ->where('measurement_type_enum', 0) // Em Jejum
            ->orderByDesc('value')
            ->orderByDesc('created_at')
            ->first();

        $valor2 = $highest2?->value ?? '–';
        $data2 = $highest2?->created_at?->format('d/m/Y H:i') ?? 'sem dados';

        $highes3 = Measurement::query()
            ->where('measurement_type_enum', MeasurementTypeEnum::PreAlmoco) // Pré Almoco
            ->orderByDesc('value')              // Maior valor primeiro
            ->orderByDesc('created_at')         // Mais recente em caso de empate
            ->first();

        $valor3 = $highes3?->value ?? '–';
        $data3 = $highes3?->created_at?->format('d/m/Y H:i') ?? 'sem dados';

        return [

            Card::make('Maior Glicemia em Jejum', "{$valor2} mg/dL")
                ->description("Registrada em {$data2}")
                ->color('danger') // vermelho
                ->icon('heroicon-o-fire'),

            Card::make('Maior Glicemia em Pré Almoco', "{$valor3} mg/dL")
                ->description("Registrada em {$data3}")
                ->color('danger') // vermelho
                ->icon('heroicon-o-fire'),

            Card::make('Maior Glicemia Pré Jantar', "{$valor1} mg/dL")
                ->description("Registrada em {$data1}")
                ->color('danger') // Amarelo (ou 'danger' se preferir vermelho)
                ->icon('heroicon-o-fire'),
        ];
    }


    protected function getColumns(): int
    {
        return 2;  // 2 cards por linha = lado a lado
    }

}
