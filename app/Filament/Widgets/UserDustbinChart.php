<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\BarChartWidget;

class UserDustbinChart extends BarChartWidget
{
    protected static ?string $heading = 'User Dustbin Chart';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = User::query()->withCount('dustbins')->get();

        return [
            'datasets' => [
                [
                    'label' => 'User Dustbin Chart',
                    'data' => $data->map(fn(User $user) => $user->dustbins_count),
                    'backgroundColor' => ['lime'],
                    'borderColor' => ['lime'],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $data->map(fn(User $user) => $user->name),
        ];
    }
}
