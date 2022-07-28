<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Agricoltura;
use App\Models\AttivitaCliente;
use App\Models\Car;
use App\Models\Client;
use App\Models\ClientTrip;
use App\Models\Presenze;
use App\Models\Primanota;
use App\Models\Trip;
use App\Models\User;
use App\Services\AgricolturaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nexmo\Laravel\Facade\Nexmo;
use function compact;
use function dd;
use function redirect;
use function view;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function inizio()
    {
        $giorno = Carbon::now()->firstOfMonth();
        return view('home', compact('giorno'));
    }

    public function index()
    {
        $giorno = Carbon::now()->firstOfMonth();
        return view('home', compact('giorno'));
    }

    public function dati()
    {
        $items = AttivitaCliente::with('client', 'activity')->latest()->paginate(10);
        $attivita = Activity::latest()->get();
        $ragazzi = Client::orderBy('name')->get();

        return view('dati.inserisci', compact('items', 'attivita', 'ragazzi'));
    }

    public function inserisci(Request $request)
    {
        //dd($request);
        $date = $request->giorno;
        $d = date_parse_from_format("Y-m-d", $date);
        $mese = $d["month"];
        $anno = $d["year"];

        foreach ($request->raga as $ragazzo){

            $inserimento = new AttivitaCliente();

            $inserimento->activity_id = $request->attivita;
            $inserimento->client_id = $ragazzo;
            $inserimento->quantita = $request->quantita;
            $inserimento->costo = $request->costo;
            $inserimento->giorno = $date;
            $inserimento->mese = $mese;
            $inserimento->anno = $anno;
            $inserimento->note = $request->note;

            $client = Client::find($ragazzo);

            if ($inserimento->activity->tipo == 'mensile') {
                $attivitasvolte = AttivitaCliente::where([
                    ['client_id', $ragazzo],
                    ['activity_id', $request->attivita],
                    ['mese', $mese],
                    ['anno', $anno]
                ])->get();
                if(count($attivitasvolte) < 1){
                    $client->voucher -= $request->costo;
                };
            } else {
                $client->voucher -= $request->costo;
            }
            $client->save();

            $inserimento->save();

            \activity()->useLog('PresenzeAttivita')->log(auth()->user()->name." ha inserito $client->name per il giorno $date per l'attivita' ".Activity::find($inserimento->activity_id)->name);
        }
        return redirect()->back();
    }

    public function elimina(AttivitaCliente $attivitaCliente)
    {
        \activity()->useLog('PresenzeAttivita')->log(auth()->user()->name." ha eliminato ".$attivitaCliente->client->name. " per il giorno $attivitaCliente->giorno per l'attivita' ".Activity::find($attivitaCliente->activity_id)->name);
        $res = $attivitaCliente->delete();
        return 1;
    }

    public function statistiche()
    {
        return view('statistiche.index');
    }

    public function presenze()
    {
        $ragazzi = Client::orderBy('name')->get();
        $annooggi = Carbon::now()->format('Y') + 0;
        return view('statistiche.presenze', compact('ragazzi', 'annooggi'));
    }

    public function visualizzastatistiche(Request $request)
    {
        $ragazzi = Client::orderBy('name')->get();
        $annooggi = Carbon::now()->format('Y') + 0;

        $ragazzo = $request->ragazzo;
        $client = Client::find($ragazzo);

        $mese = $request->mese;
        $anno = $request->anno;
        $items = AttivitaCliente::with('activity', 'client')
            ->orderBy('activity_id')
            ->where([
            ['client_id', $ragazzo],
            ['anno', $anno],
            ['mese', $mese],
        ])
            ->get()
            ->groupBy('activity_id');

        $totale = 0;

        $nome = '';

        foreach ($items as $item) {
            $nome = $item[0]->client->name;
            if($item[0]->activity->tipo <> 'orario'){
                $totale = $totale + $item[0]->activity->cost;
                //dd($totale);
            } else {
                foreach ($item as $ele) {
                      $totale = $totale + ($ele->costo);
                }
            }
        }
//dd($items);
        return view('statistiche.visualizza', compact('ragazzi', 'client', 'items', 'annooggi', 'totale', 'nome', 'mese', 'anno'));
    }

    public function chilometrivetture()
    {
        $vetture = Car::orderBy('name')->get();
        $annooggi = Carbon::now()->format('Y') + 0;
        return view('statistiche.chilometrivetture', compact('vetture', 'annooggi'));
    }

    public function visualizzachilometrivetture(Request $request)
    {
        $vetture = Car::orderBy('name')->get();
        $annooggi = Carbon::now()->format('Y') + 0;
        $anno = $request->anno;

        $totkm = 0;
        $queryBuilder = Trip::with('clienttrip', 'user');
        $queryBuilder->where([
            ['car_id', $request->vettura],
            ['anno', $anno],
            ['mese', $request->mesi[0]],
        ]);

        $mese = $request->mesi[0];
        if (count($request->mesi) > 1){
            for($i = 1; $i < count($request->mesi); $i++){
                //dd($i);
                $queryBuilder->orWhere([
                    ['car_id', $request->vettura],
                    ['anno', $anno],
                    ['mese', $request->mesi[$i]],
                ]);

                $mese = $mese.'-'.$request->mesi[$i];
            }
        }

        $viaggi = $queryBuilder->orderBy('giorno')->get();

        isset($viaggi[0]) ? $nomecar = $viaggi[0]->car->name : $nomecar = '';

        foreach ($viaggi as $viaggio){
            $totkm = $totkm + $viaggio->kmPercorsi;
        }
        return view('statistiche.visualizzachilometri', compact('viaggi', 'vetture', 'annooggi', 'nomecar', 'mese', 'anno', 'totkm'));
    }

    public function chilometriragazzi()
    {
        $ragazzi = Client::orderBy('name')->get();
        $annooggi = Carbon::now()->format('Y') + 0;
        return view('statistiche.chilometriragazzi', compact('ragazzi', 'annooggi'));
    }

    public function visualizzachilometriragazzi(Request $request)
    {
        /*--------------- nome ragazzo ---------------*/
        $nomeragazzo = Client::find($request->ragazzo)->name;

        /*--------------- lista dei ragazzi ---------------*/
        $ragazzi = Client::orderBy('name')->get();

        /*--------------- anno di oggi ---------------*/
        $annooggi = Carbon::now()->format('Y') + 0;

        /*--------------- anno della request ---------------*/
        $anno = $request->anno;

        /*--------------- primo mese scelto della request ---------------*/
        $mese = $request->mesi[0];

        $totkm = 0;

        /*--------------- risultati del primo mese della request ---------------*/
        $queryBuilder = ClientTrip::with('ragazzi', 'trip');
        $queryBuilder->where([
            ['client_id', $request->ragazzo],
            ['anno', $anno],
            ['mese', $mese],
        ]);

        /*--------------- se ci sono altri mesi nella request ---------------*/
        if (count($request->mesi) > 1){
            for($i = 1; $i < count($request->mesi); $i++){
                //dd($i);
                $queryBuilder->orWhere([
                    ['client_id', $request->ragazzo],
                    ['anno', $anno],
                    ['mese', $request->mesi[$i]],
                ]);

                $mese = $mese.'-'.$request->mesi[$i];
            }
        }

        /*--------------- collection dei viaggi ---------------*/
        $viaggi = $queryBuilder->get();


        /*--------------- calcolo km ---------------*/
        foreach ($viaggi as $viaggio){
            $totkm = $totkm + $viaggio->trip[0]->kmPercorsi;
        }
        return view('statistiche.visualizzaragazzi', compact('viaggi', 'ragazzi', 'annooggi', 'nomeragazzo', 'mese', 'anno', 'totkm'));
    }

    public function presenzeoperatori()
    {
        $operatori = User::orderBy('name')->get();
        $settimanaAttuale = Carbon::now()->weekOfYear;
        $date = Carbon::now(); // or $date = new Carbon();
        $annooggi = $date->format('Y') + 0;
        $settimane = [];
        $settimanafinale = Carbon::create($annooggi, 12, 31, 0, 0, 0, null)->weekOfYear;

        for ($j = 1; $j <= $settimanafinale; $j++){
            $date->setISODate($annooggi,$j);
            $settimane[$j] = 'settimana:'.$j.' - dal: '.$date->startOfWeek()->format('d/m/Y');
        }

        return view('statistiche.presenzeoperatori', compact('operatori', 'settimanaAttuale', 'settimane'));
    }

    public function visualizzapresenzeoperatore(Request $request)
    {
        $operatori = User::orderBy('name')->get();
        $user = User::find($request->operatore);
        $date = Carbon::now(); // or $date = new Carbon();
        $annooggi = Carbon::now()->format('Y') + 0;
        $settimane = [];
        $settimanafinale = Carbon::create($annooggi, 12, 31, 0, 0, 0, null)->weekOfYear;

        for ($j = 1; $j <= $settimanafinale; $j++){
            $date->setISODate($annooggi,$j);
            $settimane[$j] = 'settimana:'.$j.' - dal: '.$date->startOfWeek()->format('d/m/Y');
        }

        $settimana = $request->settimana;

        $presenze = Presenze::with('user')
            ->where([
                ['user_id', $user->id],
                ['anno', $annooggi],
                ['settimana', $settimana],
            ])
            ->get();
        $totale = 0;
        foreach ($presenze as $presenza){
            $totale = $totale + $presenza->ore;
        }
        return view('statistiche.settimaneoperatore', compact('presenze', 'user', 'totale', 'operatori', 'settimana', 'settimane'));
    }

    public function log()
    {
        $logs = \Spatie\Activitylog\Models\Activity::latest()->paginate(10);
        return view('log.index', compact('logs'));
    }

    public function presenzecalcolo()
    {
        $settimanaAttuale = Carbon::now()->weekOfYear;
        $operatore = User::with('presenze')->where('name', 'Manuela')->first();

            if($operatore->oresettimanali)
            {
                $totaleOreAttese = $settimanaAttuale * $operatore->oresettimanali;
                //dd($totaleOreAttese);
                //dd("$totaleOreAttese - $settimanaAttuale - $operatore->oresettimanali");
                $totaleOreLavorate = 0;
                foreach ($operatore->presenze as $presenza)
                {
                    $totaleOreLavorate += $presenza->ore;
                }
                //dd($totaleOreLavorate);
                $operatore->oresaldo = $totaleOreAttese - $totaleOreLavorate;
                $operatore->save();
                dd('saldo: '.$operatore->oresaldo.' ore fatte:'.$totaleOreLavorate.' ore che doveva fare:'.$totaleOreAttese);
            }

    }

    public function agricoltura($giorno, AgricolturaService $agricolturaService, $id='')
    {
        $persone = $agricolturaService->getPersone();
        setlocale(LC_TIME, 'it_IT');
        Carbon::setLocale('it');
        $mese = $agricolturaService->nomeDelMese($giorno);
        $successivo = Carbon::make($giorno)->addMonth();
        $precedente = Carbon::make($giorno)->subMonth();
        $giornoInizioSecondaSettimana = Carbon::make($giorno)->firstOfMonth()->endOfWeek()->day + 1;
        $mesenumero = $agricolturaService->numeroDelMese($giorno);

        $utente = $id ? $utente = Client::with(['agricoltura' => function ($query) use($mesenumero) {
                $query->where('mese', $mesenumero);
            }])->find($id) : null;

        $totaleSettimaneLavorate = $id ? $utente->agricoltura->where('tipo', 'P')->groupBy('settimana')->count() : null;

        $anno = $agricolturaService->anno($giorno);
        $nrsettimane = $agricolturaService->numeroSettimaneNelMese($giorno);
        $numero = $agricolturaService->posizionePrimoGiornoDelMese($giorno);
        $numerodispazi = $numero == 0 ? 7 : $numero;
        $settimana = ['lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
        $lastDay = $agricolturaService->ultimoGiornoDelMese($giorno);
        return view('agricoltura.index2', compact('settimana', 'totaleSettimaneLavorate', 'giornoInizioSecondaSettimana', 'numerodispazi', 'mese', 'lastDay', 'nrsettimane', 'persone', 'mesenumero', 'anno', 'successivo', 'precedente', 'giorno', 'utente'));
    }

    public function stampa($giorno, AgricolturaService $agricolturaService, $id)
    {
        setlocale(LC_TIME, 'it_IT');
        Carbon::setLocale('it');
        $mese = $agricolturaService->nomeDelMese($giorno);

        $mesenumero = $agricolturaService->numeroDelMese($giorno);

        $utente = $id ? $utente = Client::with(['agricoltura' => function ($query) use($mesenumero) {
            $query->where('mese', $mesenumero);
        }])->find($id) : null;

        $totaleSettimaneLavorate = $id ? $utente->agricoltura->where('tipo', 'P')->groupBy('settimana')->count() : null;

        $anno = $agricolturaService->anno($giorno);
        $nrsettimane = $agricolturaService->numeroSettimaneNelMese($giorno);

        $settimana = ['lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
        $lastDay = $agricolturaService->ultimoGiornoDelMese($giorno);
        return view('agricoltura.stampa', compact('settimana', 'totaleSettimaneLavorate',  'mese', 'lastDay', 'nrsettimane', 'mesenumero', 'anno', 'giorno', 'utente'));
    }

    public function postagricoltura(Request $request, AgricolturaService $agricolturaService)
    {
        $agricolturaService->salvaPresenze($request);
        return redirect()->route('agricoltura', ['giorno' => $request->giorno, 'id' => $request->persona]);
    }

    public function eliminaagricola($id)
    {
        Agricoltura::find($id)->delete();
        return redirect()->back();
    }

    public function sendsms()
    {
        Nexmo::message()->send([
            'to' => '+393923126074',
            'from' => '+393920222125',
            'text' => 'Marco Pirla!'
        ]);
    }

}
