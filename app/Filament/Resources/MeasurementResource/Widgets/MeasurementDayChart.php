<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Models\Measurement;
use Filament\Widgets\ChartWidget;

class MeasurementDayChart extends ChartWidget
{
    protected static ?string $heading = 'Glicemia por Tipo de Medição no Dia Selecionado';

    protected static ?int $sort = 2;

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }

    protected function getFilters(): array
    {
        return [
            now()->toDateString(),
        ];
    }

    protected function getData(): array
    {
        $dataSelecionada = $this->filter['data'] ?? now()->toDateString();

        $tipos = [
            0 => 'Em Jejum',
            1 => 'Pós Café',
            2 => 'Pré Almoço',
            3 => 'Pós Almoço',
            4 => 'Pós Lanche da Tarde',
            5 => 'Pré Jantar',
            6 => 'Pós Jantar',
        ];

        $valores = [];

        foreach ($tipos as $enum => $label) {
            $media = Measurement::query()
                ->where('measurement_type_enum', $enum)
                ->whereDate('created_at', $dataSelecionada)
                ->avg('value');

            $valores[] = round($media ?? 0, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Glicemia',
                    'data' => $valores,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#007BFF',
                ]
            ],
            'labels' => array_values($tipos),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
