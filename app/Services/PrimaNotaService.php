<?php


namespace App\Services;


use App\Models\Car;
use App\Models\Primanota;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PrimaNotaService
{
    public function inserisciUscita($request)
    {
        return Primanota::create([
            'importo' => $request->importo,
            'causale' => $request->causale,
            'user_id' => Auth::user()->id,
            'anno' => Carbon::now()->year,
            'mese' => Carbon::now()->month,
            'tipo' => 'uscita',
        ]);
    }

    public function inserisciEntrata($request)
    {
        $annoAttuale = Carbon::now()->year;
        $progressivo = Primanota::where([
            ['anno', $annoAttuale],
            ['tipo', 'entrata'],
            ['causale', '!=', 'Saldo mese precedente']
        ])->count();
        return Primanota::create([
            'importo' => $request->importo,
            'causale' => $request->causale,
            'user_id' => Auth::user()->id,
            'anno' => Carbon::now()->year,
            'mese' => Carbon::now()->month,
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
        ])->latest()->paginate(10);

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

    public function elimina(Primanota $primanota)
    {
        return $primanota->delete();
    }
}
