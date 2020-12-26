<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AssociaController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresenzeController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('home'); });
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// --------------------- attività --------------------------
Route::get('/inserisciattivita', [ActivityController::class, 'index'])->name('attivita');
Route::post('/inserisciattivita', [ActivityController::class, 'inserisci'])->name('inserisci_attivita');
Route::delete('/eliminaattivita/{activity}', [ActivityController::class, 'elimina'])->name('elimina_attivita');
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
Route::delete('/eliminadati/{attivitaCliente}', [HomeController::class, 'elimina'])->name('elimina_dati');

// ---------------------- Operatori ----------------------
Route::get('/inseriscipresenze', [PresenzeController::class, 'index'])->name('presenze');
Route::post('/inseriscipresenze', [PresenzeController::class, 'inserisci'])->name('inserisci_presenze');
Route::delete('/eliminapresenze/{presenze}', [PresenzeController::class, 'elimina'])->name('elimina_presenza');

// --------------------- chilometri --------------------------
Route::get('/inseriscichilometri', [TripController::class, 'index'])->name('chilometri');
Route::post('/inseriscichilometri', [TripController::class, 'inserisci'])->name('inserisci_chilometri');
Route::delete('/eliminachilometri/{trip}', [TripController::class, 'elimina'])->name('elimina_chilometri');


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
