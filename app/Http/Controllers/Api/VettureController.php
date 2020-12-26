<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VettureResource;
use App\Models\Car;
use Illuminate\Http\Request;

class VettureController extends Controller
{
    public function index()
    {
        $vetture = Car::orderBy('name')->get();
        return VettureResource::collection($vetture);
    }

    public function inserisci(Request $request)
    {
        $vettura = new Car();
        $vettura->name =$request->nomevettura;
        $vettura->save();
        return $vettura;
    }

    public function elimina(Car $car)
    {
        $car->delete();
    }
}
