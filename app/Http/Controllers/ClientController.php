<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ragazzi = Client::latest()->get();
        return view('ragazzo.inserisci', compact('ragazzi'));
    }

    public function inserisci(ClientRequest $request)
    {
        $ragazzo = new Client();
        $ragazzo->name = $request->nomeragazzo;
        $ragazzo->voucher = $request->voucher;
        $ragazzo->scadenza = $request->scadenza;
        $ragazzo->save();
        return redirect()->back();
    }

    public function edit(Client $client)
    {
        return view('ragazzo.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $client->name = $request->nomeragazzo;
        $client->voucher = $request->voucher;
        $client->scadenza = $request->scadenza;
        $client->save();
        return redirect()->route('inserisci_ragazzo');
    }

    public function delete()
    {
        
    }
}
