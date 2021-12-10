<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Costoragazzo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CostoragazzoController extends Controller
{
    public function inserisci(Request $request)
    {
        Costoragazzo::updateOrCreate(
            ['client_id' => $request->client_id, 'mese' => $request->mese, 'anno' => $request->anno],
            [
                'saldo' => $request->saldo,
                'totale' => $request->totaleCosto,
                'contributo' => $request->contributo,
            ]
        );

        return redirect()->route('costi_ragazzi');
    }

    public function lista()
    {
        $anno = Carbon::now()->year;
        $ragazzi = Client::whereHas('costi', function($k) use($anno){
            $k->where('anno', $anno);
        })
            ->with(['costi' => function($q) use($anno){
                $q->where('anno', $anno);
        }])->orderBy('name')->paginate(4);

        $raga = Costoragazzo::where('anno', $anno);

        $totale = $raga->sum('totale');
        $saldo = $raga->sum('saldo');
        $contributo = $raga->sum('contributo');

        return view('statistiche.costi', compact('ragazzi', 'totale', 'saldo', 'contributo'));
    }
}
