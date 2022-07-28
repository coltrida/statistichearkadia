<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Primanota;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrimanotaController extends Controller
{
    public function inserisciUscita(Request $request)
    {
        $giorno = Carbon::make($request->giorno);
        return Primanota::create([
            'importo' => $request->importo,
            'causale' => $request->causale,
            'user_id' => 1,
            'anno' => $giorno->year,
            'mese' => $giorno->month,
            'giorno' => $giorno,
            'tipo' => 'uscita',
        ]);
    }

    public function inserisciEntrata(Request $request)
    {
        $giorno = Carbon::make($request->giorno);
        $annoAttuale = $giorno->year;
        $progressivo = Primanota::where([
            ['anno', $annoAttuale],
            ['tipo', 'entrata'],
            ['causale', '!=', 'Saldo mese precedente']
        ])->count();
        return Primanota::create([
            'importo' => $request->importo,
            'causale' => $request->causale,
            'user_id' => 1,
            'anno' => $annoAttuale,
            'mese' => $giorno->month,
            'giorno' => $giorno,
            'tipo' => 'entrata',
            'progressivo' => (int)$progressivo + 1,
            'fornitore' => $request->fornitore,
        ]);
    }

    public function saldoMese($direzione)
    {
        $giornoCalcolato = Carbon::now()->firstOfMonth()->addMonths($direzione);
        $anno = $giornoCalcolato->year;
        $mese = $giornoCalcolato->month;
        $ele = Primanota::with('user')->where([
            ['mese', $mese],
            ['anno', $anno],
        ])->orderBy('giorno', 'DESC')->paginate(10);

        $sommaEntrate = Primanota::where([
            ['mese', $mese],
            ['anno', $anno],
            ['tipo', 'entrata'],
        ])->sum('importo');

        $sommaUscite = Primanota::where([
            ['mese', $mese],
            ['anno', $anno],
            ['tipo', 'uscita'],
        ])->sum('importo');

        $saldo = $sommaEntrate - $sommaUscite;

        return [$ele, $anno, $mese, $sommaEntrate, $sommaUscite, $saldo];
    }

    public function eliminaPrimanota(Primanota $primanota)
    {
        $primanota->delete();
    }
}
