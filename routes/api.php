<?php

use App\Models\Dustbin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('dustbin-update', function (\Illuminate\Http\Request $request) {

updateDustbins();

$data_raw = 'Packet received from: 30:83:98:a3:1e:f0
Board ID 2: 12 bytes
Distance: 31
Weight: 94

Packet received from: 30:83:98:a3:1e:f0
Board ID 1: 12 bytes
Distance: 37
Weight: 0

Packet received from: 30:83:98:a3:1e:f0
Board ID 3: 12 bytes
Distance: 34
Weight: 0 ';
    $data = preg_split("/\\r\\n|\\r|\\n/", $data_raw);
    $sensor_id = $data[1];
    $dustbin = Dustbin::where('registration_number', $data[1])->first();
    $distance_percent = 100 - (((int)explode(':',$data[2])[1]/100)*100);
    $weight_percent = (((int)explode(':',$data[3])[1]/100)*100);

    if($distance_percent > $weight_percent) {
        $dustbin->update([
           'filling_percent' => $distance_percent
        ]);
    }else{
        $dustbin->update([
            'filling_percent' => $weight_percent
        ]);
    }
    updateDustbins();
    return response()->json([
        'message' => 'Dustbin updated successful',
        'data' => $sensor_id
    ]);
})->name('dustbin.update');


function updateDustbins()
{
    if(Dustbin::count()>0) {
        Dustbin::where('filling_percent','>=', 90)
            ->where('is_full', false)->get()
            ->each(function ($dustbin){
                $dustbin->update(['is_full' => true]);
            });

        Dustbin::where('filling_percent','<=', 90)
            ->where('is_full', true)->get()
            ->each(function ($dustbin){
                $dustbin->update(['is_full' => false]);
            });
    }
}
