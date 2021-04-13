<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Http\Resources\TripResource;
use App\Models\ClientTrip;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $items = Trip::with('user', 'car', 'clienttrip')->latest()->take(100)->get();
        return TripResource::collection($items);
    }

    public function inserisci(TripRequest $request)
    {
        //dd($request);
        $viaggio = new Trip();
        $viaggio->kmPercorsi = $request->kmfinali - $request->kminiziali;
        $viaggio->user_id = $request->utente;
        $viaggio->car_id = $request->car;
        $viaggio->giorno = $request->giorno;

        $d = date_parse_from_format("Y-m-d", $request->giorno);
        $viaggio->mese = $d["month"];
        $viaggio->anno = $d["year"];

        $viaggio->save();

        foreach ($request->raga as $ragazzo_id){
            $clienteviaggio = new ClientTrip();
            $clienteviaggio->client_id = $ragazzo_id;
            $clienteviaggio->trip_id = $viaggio->id;
            $clienteviaggio->mese = $d["month"];
            $clienteviaggio->anno = $d["year"];
            $clienteviaggio->save();
        }
        return new TripResource($viaggio);
    }

    public function elimina(Trip $trip)
    {
        $trip->delete();
    }
}
