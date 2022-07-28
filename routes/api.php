<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AgricolturaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PresenzeController;
use App\Http\Controllers\Api\PrimanotaController;
use App\Http\Controllers\Api\StatisticheController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VettureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

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
Route::post('/operatori/associaOre', [UserController::class, 'eseguiassociaoperatoreore']);
Route::post('/operatori/inserisci', [UserController::class, 'salvaoperatore']);

/*--------------- Statistiche -----------------*/
Route::post('/statistiche/presenzeRagazzi', [StatisticheController::class, 'presenzeRagazzi']);
Route::post('/statistiche/presenzeOperatori', [StatisticheController::class, 'presenzeOperatori']);
Route::post('/statistiche/chilometriVetture', [StatisticheController::class, 'chilometriVetture']);
Route::post('/statistiche/chilometriRagazzi', [StatisticheController::class, 'chilometriRagazzi']);
Route::get('/statistiche/settimanaAttuale', [StatisticheController::class, 'getSettimanaAttuale']);
Route::get('/statistiche/meseAttuale', [StatisticheController::class, 'getMeseAttuale']);
Route::get('/statistiche/annoAttuale', [StatisticheController::class, 'getAnnoAttuale']);
Route::get('/statistiche/listaSettimane', [StatisticheController::class, 'listaSettimane']);

/*--------------- logs -----------------*/
Route::get('/logs', [UserController::class, 'logs']);

/*--------------- Prima Nota -----------------*/
Route::post('/inserisciUscita', [PrimanotaController::class, 'inserisciUscita']);
Route::post('/inserisciEntrata', [PrimanotaController::class, 'inserisciEntrata']);
Route::get('/saldoMese/{direzione}', [PrimanotaController::class, 'saldoMese']);
Route::delete('/eliminaPrimanota/{primanota}', [PrimanotaController::class, 'eliminaPrimanota']);

// --------------------- agricoltura --------------------------
Route::get('/primoDelMese', [AgricolturaController::class, 'primoDelMese']);
Route::get('/agricoltura/{giorno}/{id?}', [AgricolturaController::class, 'agricoltura']);
Route::get('/agricolturaMeseAnno/{mese}/{anno}', [AgricolturaController::class, 'agricolturaMeseAnno']);
Route::post('/agricoltura', [AgricolturaController::class, 'postagricoltura']);
Route::get('/eliminaagricoltura/{id}', [AgricolturaController::class, 'eliminaagricola']);
