<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Associa;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class AssociaController extends Controller
{
    public function index()
    {
        return view('associa.index');
    }

    public function associaragazzoattivita()
    {
        $attivita = Activity::orderBy('name')->get();
        $ragazzi = Client::orderBy('name')->get();
        $associazioni = Associa::orderBy('activity_id')->get();
        return view('attivita.associa', compact('attivita', 'ragazzi', 'associazioni'));
    }

    public function associaoperatoreore()
    {
        $operatori = User::orderBy('name')->get();
        return view('operatori.associaore', compact('operatori'));
    }

    public function eseguiassociaoperatoreore(Request $request)
    {
        $user = User::find($request->operatore);
        $user->oresettimanali = $request->ore;
        $user->save();
        return redirect()->back();
    }

    public function associa(Request $request)
    {
        $numeroragazzi = count($request->raga);
        for ($i=0; $i < $numeroragazzi; $i++){
            $associa = new Associa();
            $associa->activity_id = $request->attivita;
            $associa->client_id = $request->raga[$i];
            $associa->save();
        }
        return redirect()->back();
    }

    public function dissocia(Associa $associa)
    {
        $res = $associa->delete();
        return ''.$res;
    }
}
