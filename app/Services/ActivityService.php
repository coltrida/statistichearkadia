<?php


namespace App\Services;


use App\Dto\ActivityCreateDto;
use App\Models\Activity;
use function dd;

class ActivityService
{
    public function create(ActivityCreateDto $request) : bool
    {
        $attivita = new Activity();
        $attivita->name =$request->getName();
        $attivita->cost =$request->getCosto();
        $attivita->tipo =$request->getTipo();
        if(!$attivita->save()){
            return false;
        }
        return true;
    }

    public function delete($id) : bool
    {
        $attivita = Activity::find($id);
        if(!$attivita->delete()){
            return false;
        }
        return true;
    }
}
