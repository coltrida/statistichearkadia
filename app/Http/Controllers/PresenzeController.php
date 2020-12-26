<?php

namespace App\Http\Controllers;

use App\Models\Presenze;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresenzeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = auth()->id();
        $mese = Carbon::now()->format('m') + 0;
        $anno = Carbon::now()->format('Y') + 0;
        $presenze = Presenze::orderBy('giorno')
            ->where([
                ['user_id', $id],
                ['anno', $anno],
                ['mese', $mese],
            ])->get();

        return view('operatori.presenze', compact('presenze'));
    }

    public function inserisci(Request $request)
    {
        $presenza = new Presenze();
        $presenza->user_id = auth()->id();
        $giorno = $request->giorno;
        $presenza->giorno = $giorno;
        $presenza->ore = $request->ore;

        $d = date_parse_from_format("Y-m-d", $giorno);
        $presenza->mese = $d["month"];
        $presenza->anno = $d["year"];

        $settimana = Carbon::parse($giorno)->weekOfYear;
        $presenza->settimana = $settimana;

        $presenza->save();

        // recupero le presenze di una data settimana, di un dato user, di un dato anno
        $calcolaore = Presenze::where([
            ['settimana', $settimana],
            ['user_id', auth()->id],
            ['anno', $d["year"]]
        ])->get();

        // se il count è uguale a 1 vuol dire che ho cambiato settimana e devo calcolare le ore

        return redirect()->back();
    }

    public function elimina(Presenze $presenze)
    {
        //dd('ciao');
        $res = $presenze->delete();
        return ''.$res;
    }
}
