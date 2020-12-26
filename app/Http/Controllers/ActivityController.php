<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttivitaRequest;
use App\Models\Activity;
use App\Models\Client;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $attivita = Activity::latest()->get();
        return view('attivita.inserisci', compact('attivita'));
    }

    public function inserisci(AttivitaRequest $request)
    {
        $attivita = new Activity();
        $attivita->name =$request->nomeattivita;
        $attivita->cost =$request->costo;
        $attivita->tipo =$request->tipo;
        $attivita->save();
        return redirect()->back();
    }

    public function elimina(Activity $activity)
    {
        $res = $activity->delete();
        return ''.$res;
    }

    public function attivitaragazzi(Activity $activity)
    {
        //dd($activity->clientsAssocia->toArray());
         return $activity->clientsAssocia->toArray();
    }
}
