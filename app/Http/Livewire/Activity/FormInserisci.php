<?php

namespace App\Http\Livewire\Activity;

use App\Http\Requests\AttivitaRequest;
use App\Services\ActivityService;
use Livewire\Component;
use function dd;
use function redirect;
use function session;

class FormInserisci extends Component
{

    public $nomeattivita;
    public $costo;
    public $tipo;

    public function addActivity(AttivitaRequest $request, ActivityService $activityService)
    {
        dd($request->getDto());
        if (!$activityService->create($request->getDto())){
            session()->flash('message', 'Errore di creazione attività');
        }
        $this->nomeattivita = '';
        $this->costo = '';
        $this->tipo = '';
        session()->flash('message', 'Attività creata');
    }

    public function render()
    {
        return view('livewire.activity.form-inserisci');
    }
}
