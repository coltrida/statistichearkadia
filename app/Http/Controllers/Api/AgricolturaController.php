<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agricoltura;
use App\Models\Client;
use App\Services\AgricolturaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgricolturaController extends Controller
{
    public function primoDelMese()
    {
        return Carbon::now()->firstOfMonth();
    }

    public function agricolturaMeseAnno($mese, $anno, AgricolturaService $agricolturaService)
    {
        return $agricolturaService->listaAgricoltura($mese, $anno);
    }

    public function agricoltura($giorno, AgricolturaService $agricolturaService, $id='')
    {
        $persone = $agricolturaService->getPersone();
        setlocale(LC_TIME, 'it_IT');
        Carbon::setLocale('it');
        $mese = $agricolturaService->nomeDelMese($giorno);
        $successivo = Carbon::make($giorno)->addMonth();
        $precedente = Carbon::make($giorno)->subMonth();
        $giornoInizioSecondaSettimana = Carbon::make($giorno)->firstOfMonth()->endOfWeek()->day + 1;
        $mesenumero = $agricolturaService->numeroDelMese($giorno);

        $utente = $id ? $utente = Client::with(['agricoltura' => function ($query) use($mesenumero) {
            $query->where('mese', $mesenumero);
        }])->find($id) : null;

        $totaleSettimaneLavorate = $id ? $utente->agricoltura->where('tipo', 'P')->groupBy('settimana')->count() : null;

        $anno = $agricolturaService->anno($giorno);
        $nrsettimane = $agricolturaService->numeroSettimaneNelMese($giorno);
        $numero = $agricolturaService->posizionePrimoGiornoDelMese($giorno);
        $numerodispazi = $numero == 0 ? 7 : $numero;
        $settimana = ['lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
        $lastDay = $agricolturaService->ultimoGiornoDelMese($giorno);
        return [
            'settimana' => $settimana,
            'totaleSettimaneLavorate' => $totaleSettimaneLavorate,
            'giornoInizioSecondaSettimana' => $giornoInizioSecondaSettimana,
            'numerodispazi' => $numerodispazi,
            'mese' => $mese,
            'lastDay' => $lastDay,
            'nrsettimane' => $nrsettimane,
            'mesenumero' => $mesenumero,
            'anno' => $anno,
            'successivo' => $successivo,
            'precedente' => $precedente,
            'giorno' => $giorno,
            'utente' => $utente
        ];
    }

    public function postagricoltura(Request $request, AgricolturaService $agricolturaService)
    {
        //dd($request);
        $agricolturaService->salvaAgricoltura($request);
    }

    public function eliminaagricola($id)
    {
        Agricoltura::find($id)->delete();
        return redirect()->back();
    }
}
