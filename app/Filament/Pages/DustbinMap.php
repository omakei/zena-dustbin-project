<?php

namespace App\Filament\Pages;

use App\Models\Dustbin;
use Filament\Pages\Page;

class DustbinMap extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static string $view = 'filament.pages.dustbin-map';

    protected static ?string $title = 'Dustbin Location';

    protected static ?string $navigationLabel = 'Dustbin Location';

    protected static ?string $slug = 'dustbin-location';

    public $dustbins;

    public $latitude;

    public function mount(): void
    {
        $this->dustbins = Dustbin::all(['registration_number','longitude', 'latitude'])->map(function ($dustbin){
            $data['lon'] = $dustbin->longitude;
            $data['lat'] = $dustbin->latitude;
            $data['registration_number'] = $dustbin->registration_number;
            return $data;
        })->toArray();
    }
}
