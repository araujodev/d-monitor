<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Models\Measurement;
use Filament\Widgets\ChartWidget;

class MeasurementChart extends ChartWidget
{
    protected static ?string $heading = 'Glicemia - Últimos 7 dias por tipo de medição';

    protected static ?int $sort = 1;

    public function getColumnSpan(): int | string | array
    {
        return 'full'; // Isso faz ocupar 100% da largura disponível
    }

    protected function getData(): array
    {
        $labels = [];
        $dias = [];

        // Últimos 7 dias
        foreach (range(6, 0) as $i) {
            $data = now()->subDays($i)->startOfDay();
            $dias[] = $data;
            $labels[] = $data->format('d/m');
        }

        // Mapeamento dos tipos de medição
        $tipos = [
            0 => 'Em Jejum',
            1 => 'Pós Café',
            2 => 'Pré Almoço',
            3 => 'Pós Almoço',
            4 => 'Pós Lanche da Tarde',
            5 => 'Pré Jantar',
            6 => 'Pós Jantar',
        ];

        $datasets = [];

        foreach ($tipos as $enum => $label) {
            $valores = [];

            foreach ($dias as $dia) {
                $media = Measurement::query()
                    ->where('measurement_type_enum', $enum)
                    ->whereDate('created_at', $dia)
                    ->avg('value');

                $valores[] = round($media ?? 0, 2);
            }

            $datasets[] = [
                'label' => $label,
                'data' => $valores,
                'fill' => false,
                'borderColor' => $this->getColorByIndex($enum),
                'tension' => 0.3,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getColorByIndex(int $index): string
    {
        $colors = [
            '#36A2EB', // Azul
            '#FF6384', // Vermelho
            '#FFCE56', // Amarelo
            '#4BC0C0', // Verde água
            '#9966FF', // Roxo
            '#FF9F40', // Laranja
            '#00B894', // Verde
        ];

        return $colors[$index % count($colors)];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
