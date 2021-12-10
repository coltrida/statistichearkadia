<?php

namespace App\Http\Controllers;

use App\Models\Primanota;
use App\Services\PrimaNotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PrimanotaController extends Controller
{
    public function uscita()
    {
        return view('primaNota.inserisciUscita');
    }

    public function inserisciUscita(Request $request, PrimaNotaService $primaNotaService)
    {
        if (!$primaNotaService->inserisciUscita($request)){
            return redirect()->back()->withMessage('Errore inserimento uscita');
        }
        return redirect()->back()->withMessage('Uscita inserita');
    }

    public function entrata()
    {
        return view('primaNota.inserisciEntrata');
    }

    public function inserisciEntrata(Request $request, PrimaNotaService $primaNotaService)
    {
        if (!$primaNotaService->inserisciEntrata($request)){
            return redirect()->back()->withMessage('Errore inserimento entrata');
        }
        return redirect()->back()->withMessage('Entrata inserita');
    }

    public function saldoMese($direzione, PrimaNotaService $primaNotaService)
    {
        $items = $primaNotaService->saldoMese($direzione);
        return view('primaNota.saldoMese', compact('items', 'direzione'));
    }

    public function ricevuta(Primanota $primanota)
    {
        return view('primaNota.ricevuta', compact('primanota'));
    }
}
