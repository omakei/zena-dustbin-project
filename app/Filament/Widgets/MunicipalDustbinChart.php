<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;

class MunicipalDustbinChart extends LineChartWidget
{
    protected static ?string $heading = 'Municipal Dustbin Chart';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = User::query()->withCount('dustbins')->groupBy('municipal')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Municipal Dustbin Chart',
                    'data' => $data->map(fn(User $user) => $user->dustbins_count),
                    'backgroundColor' => ['lime'],
                    'borderColor' => ['lime'],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $data->map(fn(User $user) => $user->municipal),
        ];
    }
}
