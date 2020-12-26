<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vetture = Car::latest()->get();
        return view('vettura.inserisci', compact('vetture'));
    }

    public function inserisci(Request $request)
    {
        $vettura = new Car();
        $vettura->name =$request->nomevettura;
        $vettura->save();
        return redirect()->back();
    }
}
