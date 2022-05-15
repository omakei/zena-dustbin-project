<?php

namespace App\Filament\Widgets;

use App\Models\Dustbin;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Users', User::count())
                ->color('success')
                ->description('Number of users registered')
                ->descriptionIcon('heroicon-s-user-group'),
            Card::make('Dustbin', Dustbin::count())
                ->color('success')
                ->description('Number of dustbins registered')
                ->descriptionIcon('heroicon-s-trash'),
            Card::make('Full Dustbin', Dustbin::where('is_full',true)->count())
                ->color('danger')
                ->description('Number of full dustbins available')
                ->descriptionIcon('heroicon-s-trash'),
        ];
    }
}
