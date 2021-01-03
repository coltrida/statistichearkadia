<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripRequest;
use App\Models\Car;
use App\Models\Client;
use App\Models\ClientTrip;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Trip::with('user', 'car', 'clienttrip')->latest()->paginate(10);
        //dd($items);
        $ragazzi = Client::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $vetture = Car::orderBy('name')->get();
        return view('chilometri.inserisci', compact('items', 'ragazzi', 'users', 'vetture'));
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
            activity()->useLog('InserisciKm')->log(auth()->user()->name." ha inserito un viaggio di $viaggio->kmPercorsi km con la vettura ".$viaggio->car->name." portando ".$clienteviaggio->ragazzi[0]->name);
        }
        return redirect()->back();
    }

    public function elimina(Trip $trip)
    {
        $passeggeri = [];
        foreach ($trip->clienttrip as $item){
            array_push($passeggeri, $item->ragazzi[0]->name);
        }
        activity()->useLog('InserisciKm')->log(auth()->user()->name." ha eliminato il viaggio del giorno $trip->giorno con i passeggeri ".implode(",", $passeggeri));
        $res = $trip->delete();
        return ''.$res;
    }
}
