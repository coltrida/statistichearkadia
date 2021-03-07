<?php


namespace App\Services;


use App\Dto\ActivityCreateDto;
use App\Models\Activity;

class ActivityService
{
    public function getAll()
    {
        return Activity::latest()->get();
    }

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

    public function delete(int $id) : bool
    {
        $attivita = Activity::find($id);
        if(!$attivita->delete()){
            return false;
    }
        return true;
    }
}
