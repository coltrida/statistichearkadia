<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AssociaController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CostoragazzoController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresenzeController;
use App\Http\Controllers\PrimanotaController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'inizio'])->name('inizio');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/migrate', function (){
    \Illuminate\Support\Facades\Artisan::call('migrate --path=/database/migrations/2021_12_10_151527_create_primanotas_table.php');
});

// --------------------- attività --------------------------
Route::get('/inserisciattivita', [ActivityController::class, 'index'])->name('attivita');
Route::post('/inserisciattivita', [ActivityController::class, 'inserisci'])->name('inserisci_attivita');
Route::get('/eliminaattivita/{id}', [ActivityController::class, 'elimina'])->name('elimina_attivita');
Route::get('/attivitaragazzi/{activity}', [ActivityController::class, 'attivitaragazzi'])->name('attivitaragazzi');

// --------------------- associa --------------------------
Route::get('/associa', [AssociaController::class, 'index'])->name('associaindex');
Route::get('/associaragazzoattivita', [AssociaController::class, 'associaragazzoattivita'])->name('associaragazzoattivita');
Route::post('/associaragazzoattivita', [AssociaController::class, 'associa'])->name('associa');
Route::delete('/dissocia/{associa}', [AssociaController::class, 'dissocia'])->name('dissocia');
Route::get('/associaoperatoreore', [AssociaController::class, 'associaoperatoreore'])->name('associaoperatoreore');
Route::post('/associaoperatoreore', [AssociaController::class, 'eseguiassociaoperatoreore'])->name('eseguiassociaoperatoreore');

// --------------------- ragazzi --------------------------
Route::get('/inserisciragazzo', [ClientController::class, 'index'])->name('ragazzo');
Route::post('/inserisciragazzo', [ClientController::class, 'inserisci'])->name('inserisci_ragazzo');
Route::get('/editragazzo/{client}', [ClientController::class, 'edit'])->name('edit_ragazzo');
Route::patch('/editragazzo/{client}', [ClientController::class, 'update'])->name('update_ragazzo');
Route::delete('/deleteragazzo', [ClientController::class, 'delete'])->name('delete_ragazzo');

// --------------------- vettura --------------------------
Route::get('/inseriscivettura', [CarController::class, 'index'])->name('vettura');
Route::post('/inseriscivettura', [CarController::class, 'inserisci'])->name('inserisci_vettura');

// --------------------- dati --------------------------
Route::get('/inseriscidati', [HomeController::class, 'dati'])->name('dati');
Route::post('/inseriscidati', [HomeController::class, 'inserisci'])->name('inserisci_dati');
Route::get('/eliminadati/{attivitaCliente}', [HomeController::class, 'elimina'])->name('elimina_dati');

// ---------------------- Operatori ----------------------
Route::get('/inseriscipresenze', [PresenzeController::class, 'index'])->name('presenze');
Route::post('/inseriscipresenze', [PresenzeController::class, 'inserisci'])->name('inserisci_presenze');
Route::delete('/eliminapresenze/{presenze}', [PresenzeController::class, 'elimina'])->name('elimina_presenza');

// --------------------- chilometri --------------------------
Route::get('/inseriscichilometri', [TripController::class, 'index'])->name('chilometri');
Route::post('/inseriscichilometri', [TripController::class, 'inserisci'])->name('inserisci_chilometri');
Route::delete('/eliminachilometri/{trip}', [TripController::class, 'elimina'])->name('elimina_chilometri');

// --------------------- Log --------------------------
Route::get('/log', [HomeController::class, 'log'])->name('log');

// --------------------- Prima Nota --------------------------
Route::get('/inserisciUscita', [PrimanotaController::class, 'uscita'])->name('uscita');
Route::post('/inserisciUscita', [PrimanotaController::class, 'inserisciUscita'])->name('inserisci_uscita');
Route::get('/inserisciEntrata', [PrimanotaController::class, 'entrata'])->name('entrata');
Route::post('/inserisciEntrata', [PrimanotaController::class, 'inserisciEntrata'])->name('inserisci_entrata');
Route::get('/saldoMese/{direzione}', [PrimanotaController::class, 'saldoMese'])->name('saldo_mese');
Route::get('/ricevuta/{primanota}', [PrimanotaController::class, 'ricevuta'])->name('ricevuta');
Route::get('/eliminaPrimanota/{primanota}', [PrimanotaController::class, 'elimina'])->name('eliminaPrimanota');

// --------------------- statistiche --------------------------
Route::get('/statistiche', [HomeController::class, 'statistiche'])->name('statistiche');
Route::get('/statistichepresenze', [HomeController::class, 'presenze'])->name('statistiche_presenze');
Route::get('/statistichepresenzeoperatori', [HomeController::class, 'presenzeoperatori'])->name('statistiche_presenze_operatori');
Route::post('/visualizzapresenzeoperatore', [HomeController::class, 'visualizzapresenzeoperatore'])->name('visualizza_presenze_operatore');
Route::post('/visualizzastatistiche', [HomeController::class, 'visualizzastatistiche'])->name('visualizza_statistiche');
Route::post('/visualizzachilometrivetture', [HomeController::class, 'visualizzachilometrivetture'])->name('visualizza_chilometri_vetture');
Route::post('/visualizzachilometriragazzi', [HomeController::class, 'visualizzachilometriragazzi'])->name('visualizza_chilometri_ragazzi');
Route::get('/statistichechilometrivetture', [HomeController::class, 'chilometrivetture'])->name('statistiche_chilometri_vetture');
Route::get('/statistichechilometriragazzi', [HomeController::class, 'chilometriragazzi'])->name('statistiche_chilometri_ragazzi');
Route::get('/costiRagazzi', [CostoragazzoController::class, 'lista'])->name('costi_ragazzi');

Route::get('/agricoltura/{giorno}/{id?}', [HomeController::class, 'agricoltura'])->name('agricoltura');
Route::post('/agricoltura', [HomeController::class, 'postagricoltura'])->name('postagricoltura');
Route::get('/eliminaagricoltura/{id}', [HomeController::class, 'eliminaagricola'])->name('eliminaagricola');

Route::get('/calcoloSaldoOre', [FrontController::class, 'calcoloSaldoOre'])->name('calcoloSaldoOre');
Route::get('/presenzecalcolo', [HomeController::class, 'presenzecalcolo'])->name('presenzecalcolo');
Route::get('/controllo', [FrontController::class, 'controllo'])->name('controllo');

Route::get('/sendsms', [HomeController::class, 'sendsms'])->name('sendsms');

Route::post('inserisciCostoRagazzoMese', [CostoragazzoController::class, 'inserisci'])->name('inserisci_costo_ragazzo_mese');
