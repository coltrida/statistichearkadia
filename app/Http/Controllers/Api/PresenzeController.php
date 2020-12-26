<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presenze;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresenzeController extends Controller
{
    public function index($id)
    {
        $mese = Carbon::now()->format('m') + 0;
        $anno = Carbon::now()->format('Y') + 0;
        $presenze = Presenze::orderBy('giorno')
            ->where([
                ['user_id', $id],
                ['anno', $anno],
                ['mese', $mese],
            ])->get();

        return $presenze;
    }

    public function inserisci(Request $request)
    {
        $presenza = new Presenze();
        $presenza->user_id = $request->id;
        $giorno = $request->giorno;
        $presenza->giorno = $giorno;
        $presenza->ore = $request->ore;

        $d = date_parse_from_format("Y-m-d", $giorno);
        $presenza->mese = $d["month"];
        $presenza->anno = $d["year"];

        $presenza->settimana = Carbon::parse($giorno)->weekOfYear;

        $presenza->save();

        return $presenza;
    }

    public function elimina(Presenze $presenze)
    {
        $presenze->delete();
    }
}
