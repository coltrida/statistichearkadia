<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Associa;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $ragazzi = Client::whereNotNull('created_at')->orderBy('name')->get();
        return ClientResource::collection($ragazzi);
    }

    public function inserisci(Request $request)
    {
        $ragazzo = new Client();
        $ragazzo->name = $request->nomeRagazzo;
        $ragazzo->voucher = $request->voucher;
        $ragazzo->scadenza = $request->scadenza;
        $ragazzo->save();
        return new ClientResource($ragazzo);
    }

    public function elimina(Client $client)
    {
        Associa::where('client_id', $client->id)->delete();
        $client->update(['created_at' => null]);
    }
}
