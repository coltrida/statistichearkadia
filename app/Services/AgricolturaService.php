<?php


namespace App\Services;


use App\Models\Agricoltura;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Str;
use function dd;
use function substr;

class AgricolturaService
{
    public function getPersone()
    {
        return Client::orderBy('name')->get();
    }

    public function nomeDelMese($giorno)
    {
        return Str::upper(Carbon::make($giorno)->monthName);
    }

    public function numeroDelMese($giorno)
    {
        $mese = Carbon::make($giorno)->month;
        return $mese < 10 ? '0'.$mese : $mese;
    }

    public function anno($giorno)
    {
        return Carbon::make($giorno)->year;
    }

    public function numeroSettimaneNelMese($giorno)
    {
        return Carbon::make(Carbon::make($giorno)->endOfMonth())->weekOfMonth;
    }

    public function posizionePrimoGiornoDelMese($giorno)
    {
        return Carbon::make(Carbon::make($giorno)->firstOfMonth())->dayOfWeek;
    }

    public function ultimoGiornoDelMese($giorno)
    {
        return Carbon::make($giorno)->endOfMonth()->day;
    }

    public function salvaPresenze($request)
    {
        foreach ($request->switch as $key => $value){
            $presenza = new Agricoltura();
            $presenza->user_id = $request->persona;
            $arr = explode("/", $key);
            $gg = $arr[0];;
            $settimana = $arr[1];;
            $giorno = $gg < 10 ? '0'.$gg : $gg;
            $mese = $request->mese;
            $anno = $request->anno;
            $presenza->settimana = $settimana;
            $presenza->giorno = $giorno.'/'.$mese.'/'.$anno;
            $presenza->tipo = $value;
            $presenza->mese = $mese;
            $presenza->anno = $anno;
            $presenza->save();
        }
    }

    public function listaAgricoltura($mese, $anno)
    {
        return Agricoltura::with('client')->where([
            ['anno', $anno],
            ['mese', $mese]
        ])
            ->orderBy('giorno')
            ->get();
    }

    public function salvaAgricoltura($request)
    {
        foreach ($request->giorno as $value){
            $presenza = new Agricoltura();
            $presenza->user_id = $request->utente;
            $presenza->giorno = Carbon::make($value['id'])->format('d/m/Y');
            $presenza->settimana = Carbon::make($value['id'])->weekOfMonth;
            $presenza->mese = Carbon::make($value['id'])->month;
            $presenza->anno = Carbon::make($value['id'])->year;
            $presenza->tipo = $request->tipologia;

            $presenza->save();
        }
    }
}
