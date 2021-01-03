<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PresenzeController;
use App\Http\Controllers\Api\StatisticheController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VettureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);

});

/*--------------- Attivita -----------------*/
Route::get('/attivita', [ActivityController::class, 'index']);
Route::post('/inserisciAttivita', [ActivityController::class, 'inserisci']);
Route::delete('/attivita/{activity}', [ActivityController::class, 'elimina']);

Route::get('/associazioni', [ActivityController::class, 'associazioni']);
Route::post('/attivita/ragazzo/associa', [ActivityController::class, 'associa']);
Route::delete('/associazioni/{associa}', [ActivityController::class, 'dissocia']);

Route::get('/attivita/ragazzo/', [ActivityController::class, 'attivitaCliente']);
Route::post('/attivita/ragazzo/', [ActivityController::class, 'inserisciAttivitaCliente']);
Route::delete('/attivita/ragazzo/{attivitaCliente}', [ActivityController::class, 'eliminaAttivitaCliente']);

Route::get('/attivita/ragazzo/{activity}', [ActivityController::class, 'attivitaragazzi']);

/*--------------- Ragazzi -----------------*/
Route::get('/ragazzi', [ClientController::class, 'index']);
Route::post('/inserisciRagazzo', [ClientController::class, 'inserisci']);
Route::delete('/ragazzi/{client}', [ClientController::class, 'elimina']);

/*--------------- Vetture -----------------*/
Route::get('/vetture', [VettureController::class, 'index']);
Route::post('/vetture/inserisci', [VettureController::class, 'inserisci']);
Route::delete('/vetture/{car}', [VettureController::class, 'elimina']);

/*--------------- Login -----------------*/
/*Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);*/

/*--------------- Presenze -----------------*/
Route::get('/presenze/{id}', [PresenzeController::class, 'index']);
Route::post('/presenze', [PresenzeController::class, 'inserisci']);
Route::delete('/presenze/{presenze}', [PresenzeController::class, 'elimina']);

/*--------------- Km -----------------*/
Route::get('/chilometri', [TripController::class, 'index']);
Route::post('/chilometri/inserisci', [TripController::class, 'inserisci']);
Route::delete('/chilometri/{trip}', [TripController::class, 'elimina']);

/*--------------- Operatori -----------------*/
Route::get('/operatori', [UserController::class, 'index']);

/*--------------- Statistiche -----------------*/
Route::post('/statistiche/presenzeRagazzi', [StatisticheController::class, 'presenzeRagazzi']);
Route::post('/statistiche/presenzeOperatori', [StatisticheController::class, 'presenzeOperatori']);
Route::post('/statistiche/chilometriVetture', [StatisticheController::class, 'chilometriVetture']);
Route::post('/statistiche/chilometriRagazzi', [StatisticheController::class, 'chilometriRagazzi']);
Route::get('/statistiche/settimanaAttuale', [StatisticheController::class, 'getSettimanaAttuale']);
Route::get('/statistiche/meseAttuale', [StatisticheController::class, 'getMeseAttuale']);
Route::get('/statistiche/annoAttuale', [StatisticheController::class, 'getAnnoAttuale']);

