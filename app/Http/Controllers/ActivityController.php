<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttivitaRequest;
use App\Models\Activity;
use App\Models\Client;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use function redirect;

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

    public function inserisci(AttivitaRequest $request, ActivityService $activityService)
    {
        if (!$activityService->create($request->getDto())){
            return redirect()->back()->withMessage('Errore di creazione attività');
        }
        return redirect()->back()->withMessage('Attività creata');
    }

    public function elimina($id, ActivityService $activityService)
    {
        if (!$activityService->delete($id)){
            return redirect()->route('attivita')->withMessage('Errore di eliminazione attività');
        }
        return redirect()->route('attivita')->withMessage('Attività eliminata');
    }

    public function attivitaragazzi(Activity $activity)
    {
        //dd($activity->clientsAssocia->toArray());
         return $activity->clientsAssocia->toArray();
    }
}
