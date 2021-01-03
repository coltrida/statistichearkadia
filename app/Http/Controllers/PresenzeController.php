<?php

namespace App\Http\Controllers;

use App\Models\Presenze;
use App\Models\User;
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

        $operatore = User::find(auth()->id());

        // recupero le presenze di una data settimana, di un dato user, di un dato anno
        $calcolaore = Presenze::where([
            ['settimana', $settimana],
            ['user_id', auth()->id()],
            ['anno', $d["year"]]
        ])->get();

        // se il count è minore di 1 vuol dire che ho cambiato settimana e devo calcolare le ore considerando le ore settimanali
        if (count($calcolaore) <= 1){
            $operatore->oresaldo += ($operatore->oresettimanali - $request->ore);
        } else {
            $operatore->oresaldo -= $request->ore;
        }
        $operatore->save();

        activity()->useLog('PresenzeOperatore')->log(auth()->user()->name." ha inserito la presenza per il giorno $giorno per $request->ore ore");

        return redirect()->back();
    }

    public function elimina(Presenze $presenze)
    {
        activity()->useLog('PresenzeOperatore')->log(auth()->user()->name." ha eliminato la presenza per il giorno $presenze->giorno per $presenze->ore ore");
        $res = $presenze->delete();
        return ''.$res;
    }
}
