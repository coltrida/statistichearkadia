<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatistichePresenzeRagazziResource;
use App\Http\Resources\TripClientResource;
use App\Http\Resources\TripResource;
use App\Models\AttivitaCliente;
use App\Models\Client;
use App\Models\ClientTrip;
use App\Models\Presenze;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function compact;
use function view;

class StatisticheController extends Controller
{
    public function presenzeRagazzi(Request $request)
    {
        $ragazzo = $request->ragazzo;

        $mese = $request->mese;
        $anno = $request->anno;
        $items = AttivitaCliente::with('activity', 'client')
            ->orderBy('activity_id')
            ->where([
                ['client_id', $ragazzo],
                ['anno', $anno],
                ['mese', $mese],
            ])
            ->get()
            ->groupBy('activity_id');

        $totale = 0;

        $nome = '';

        foreach ($items as $item) {
            $nome = $item[0]->client->name;
            if($item[0]->activity->tipo <> 'orario'){
                $totale = $totale + $item[0]->activity->cost;
                //dd($totale);
            } else {
                foreach ($item as $ele) {
                    $totale = $totale + ($ele->costo);
                }
            }
        }



        $valori = AttivitaCliente::with('activity', 'client')
            ->orderBy('activity_id')
            ->where([
                ['client_id', $ragazzo],
                ['anno', $anno],
                ['mese', $mese],
            ])
            ->get();

        //return [StatistichePresenzeRagazziResource::collection($valori)->collection->groupBy('attivita'), $totale];
        return [$items, $totale, $nome];
        /*return [StatistichePresenzeRagazziResource::collection($valori), $totale, $nome];*/
        //return $items;
    }

    public function presenzeOperatori(Request $request)
    {
        $annooggi = Carbon::now()->format('Y') + 0;
        $settimana = $request->settimana;

        $presenze = Presenze::with('user')
            ->where([
                ['user_id', $request->user],
                ['anno', $annooggi],
                ['settimana', $settimana],
            ])
            ->get();
        $totale = 0;
        foreach ($presenze as $presenza){
            $totale = $totale + $presenza->ore;
        }

        $oreSaldo = User::find($request->user)->oresaldo;

        return [$presenze, $totale, $oreSaldo];
    }

    public function listaSettimane()
    {
        $settimanaAttuale = Carbon::now()->weekOfYear;
        $date = Carbon::now(); // or $date = new Carbon();
        $annooggi = $date->format('Y') + 0;
        $settimane = [];
        $settimanafinale = Carbon::create($annooggi, 12, 31, 0, 0, 0, null)->weekOfYear;

        for ($j = 1; $j <= $settimanafinale; $j++){
            $date->setISODate($annooggi,$j);
            $settimane[$j] = $j.' - dal:'.$date->startOfWeek()->format('d/m/Y');
        }

        return [$settimane, $settimanaAttuale];
    }

    public function getSettimanaAttuale()
    {
        return Carbon::now()->weekOfYear;
    }

    public function getMeseAttuale()
    {
        return Carbon::now()->month;
    }

    public function getAnnoAttuale()
    {
        return Carbon::now()->year;
    }

    public function chilometriVetture(Request $request)
    {
        $anno = $request->anno;
        $vettura = $request->vettura;
        $mese = $request->mesi[0];
        $totkm = 0;

        $queryBuilder = Trip::with('clienttrip', 'user');
        $queryBuilder->where([
            ['car_id', $vettura],
            ['anno', $anno],
            ['mese', $mese],
        ]);

        if (count($request->mesi) > 1){
            for($i = 1; $i < count($request->mesi); $i++){
                //dd($i);
                $queryBuilder->orWhere([
                    ['car_id', $vettura],
                    ['anno', $anno],
                    ['mese', $request->mesi[$i]],
                ]);
            }
        }

        $viaggi = $queryBuilder->orderBy('giorno')->get();

        //isset($viaggi[0]) ? $nomecar = $viaggi[0]->car->name : $nomecar = '';

        foreach ($viaggi as $viaggio){
            $totkm = $totkm + $viaggio->kmPercorsi;
        }
        return [TripResource::collection($viaggi), $totkm];
    }

    public function chilometriragazzi(Request $request)
    {
        /*--------------- id ragazzo della request ---------------*/
        $id = $request->ragazzo;

        /*--------------- anno della request ---------------*/
        $anno = $request->anno;

        /*--------------- primo mese scelto della request ---------------*/
        $mese = $request->mesi[0];

        $totkm = 0;

        /*--------------- risultati del primo mese della request ---------------*/
        $queryBuilder = ClientTrip::with('ragazzi', 'trip');
        $queryBuilder->where([
            ['client_id', $id],
            ['anno', $anno],
            ['mese', $mese],
        ]);

        /*--------------- se ci sono altri mesi nella request ---------------*/
        if (count($request->mesi) > 1){
            for($i = 1; $i < count($request->mesi); $i++){
                //dd($i);
                $queryBuilder->orWhere([
                    ['client_id', $id],
                    ['anno', $anno],
                    ['mese', $request->mesi[$i]],
                ]);
            }
        }

        /*--------------- collection dei viaggi ---------------*/
        $viaggi = $queryBuilder->get();


        /*--------------- calcolo km ---------------*/
        foreach ($viaggi as $viaggio){
            $totkm = $totkm + $viaggio->trip[0]->kmPercorsi;
        }
        return [TripClientResource::collection($viaggi), $totkm];
    }
}
