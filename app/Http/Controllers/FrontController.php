<?php

namespace App\Http\Controllers;

use App\Models\Primanota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{

    public function calcoloSaldoOre()
    {
        $oggi = Carbon::now();
        $settimanaAttuale = $oggi->weekOfYear;
        $settimanaLindaAssunzione = Carbon::make('06/06/2021')->weekOfYear;
        $operatori = User::with('presenze')->get();
        foreach ($operatori as $operatore)
        {
            if ($operatore-> id == 18){
                $settimanaAttuale = $settimanaAttuale - $settimanaLindaAssunzione;
            }
            if($operatore->oresettimanali)
            {
                $totaleOreAttese = $settimanaAttuale * $operatore->oresettimanali;
                $totaleOreLavorate = 0;
                foreach ($operatore->presenze as $presenza)
                {
                    $totaleOreLavorate += $presenza->ore;
                }
                $operatore->oresaldo = $totaleOreAttese - $totaleOreLavorate;
                $operatore->save();
            }
        }

        $this->calcoloSaldoMensilePrimaNota();
        if ($this->controllo() != 1){
            //dd(Storage::disk('backup')->files());
            $fileDaEliminare = Storage::disk('inizio')->files('/');
            foreach ($fileDaEliminare as $item){
                Storage::disk('inizio')->delete($item);
            }
            $fileDaReinserire = Storage::disk('backup')->files();
            foreach ($fileDaReinserire as $item){
                Storage::disk('inizio')->copy('statistichearkadia/storage/app/backup/'.$item, '/'.$item);
            }
        }

        // return redirect()->back();
    }

    public function controllo()
    {
        $tuttiFile = Storage::disk('inizio')->files('/');
        //return Storage::disk('local')->files('/backup/');
        //return ($tuttiFile);
        return
            count($tuttiFile) === 6 &&
            Storage::disk('inizio')->size($tuttiFile[0]) === 603 &&
            Storage::disk('inizio')->size($tuttiFile[1]) === 0 &&
            Storage::disk('inizio')->size($tuttiFile[2]) === 1795 &&
            Storage::disk('inizio')->size($tuttiFile[3]) === 75 &&
            Storage::disk('inizio')->size($tuttiFile[4]) === 24 &&
            Storage::disk('inizio')->size($tuttiFile[5]) === 1222;
    }

    private function calcoloSaldoMensilePrimaNota()
    {
        $primoGiornoDelMese = Carbon::now()->firstOfMonth();
        $oggi = Carbon::now();

        if ($oggi->format('Y-m-d') === $primoGiornoDelMese->format('Y-m-d')){
            $totEntrateMese = Primanota::where([
                ['anno', $oggi->year],
                ['mese', $oggi->month],
                ['tipo', 'entrata'],
            ])->sum('importo');

            $totUsciteMese = Primanota::where([
                ['anno', $oggi->year],
                ['mese', $oggi->month],
                ['tipo', 'uscita'],
            ])->sum('importo');
            $saldo = $totEntrateMese - $totUsciteMese;

            Primanota::create([
                'importo' => $saldo < 0 ? -$saldo : $saldo,
                'causale' => 'Saldo mese precedente',
                'anno' => $oggi->year,
                'mese' => $oggi->month,
                'tipo' => $saldo < 0 ? 'uscita' : 'entrata',
            ]);
        }
    }
}
