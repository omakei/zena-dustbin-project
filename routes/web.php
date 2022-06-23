<?php

use App\Models\Dustbin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dustbin-map/{dustbin}', function (Dustbin $dustbin) {
    return view('filament.pages.dustbin-map', ['dustbin' => $dustbin]);
})->name('map.show');


