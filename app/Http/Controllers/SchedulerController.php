<?php

namespace App\Http\Controllers;

use App\Models\ProductIspettori;
use App\Models\ProductDetail;
use App\Models\ProductDetailIspettori;
use App\Models\ProductMedia;
use App\Models\User;
use Date;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchedulerController extends Controller
{

    public function __invoke(Request $request): mixed       //metodo definito per gestire le richieste HTTP
    {
        // I dati della richiesta e il valore dell'header X-APIKEY vengono registrati nei log
        Log::info("Richiesta ricevuta: " . json_encode($request->all()));
        Log::info("Header X-APIKEY: " . $request->header('X-APIKEY'));
        
        $apiKey = config('app.scheduler_api_key');      //questo è il valore utilizzato per autenticare la richiesta  
        $myResp = null;     //variabile per ottenere una risposta che verrà resstituita
        
        try {
            if ($request->header('X-APIKEY') == $apiKey) {
                $transactionTimestamp = $request->input('transactionNow');
                if ($request->has('syncTabella')) {
                    $myResp = $this->syncTabella($request->input('syncTabella'));       //Se la richiesta contiene il parametro syncTabella, viene chiamato il metodo syncTabella e passata la tabella specificata.
                    
                    // questo è per la colonna 'inviato'
                } else if ($request->has('confirmSyncTabella') && $transactionTimestamp != null) {
                    Log::info("prima di confirmSyncTabella digital ocean");
                    $myResp = $this->confirmSyncTabella(
                        $request->input('confirmSyncTabella'),
                        transactionTimestamp: $transactionTimestamp
                    );      //Se la richiesta contiene il parametro confirmSyncTabella e transactionTimestamp non è nullo, chiama il metodo confirmSyncTabella, passando il nome della tabella e il timestamp della transazione.
                } else {
                    $myResp = response('not found');
                }
            } else {
                $myResp = response()->json([
                    'error' => 'apikey not valid',
                ]);
            }
        } catch (\Throwable $th) {
            $myResp = response()->json([
                'error' => $th->getMessage(),
            ]);
        }



        return $myResp;
    }

    // metodo per la colonna 'prenotato'
    private function syncTabella(string $tableName): JsonResponse
    {  
        $transactionNow = date('Y-m-d H:i:s'); //now();        //stampa esattamente data e ora di ora
        Log::info("Eseguito syncTabella per tabella: $tableName con transactionNow: $transactionNow");
        $status = 'failure';
        $results = collect();

        $idsToUpdate = [];
        // Mappa delle tabelle e dei rispettivi modelli
        switch ($tableName) {
            case 'product_ispettori':
                $idsToUpdate = ProductIspettori::whereNull('prenotato')->pluck('id')->toArray();
                ProductIspettori::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
                $results = ProductIspettori::whereIn('id', $idsToUpdate)->get();
                Log::info("ID aggiornati in product_ispettori: ", $idsToUpdate);
                $status = 'ok';
                break;

            case 'product_details':
                $idsToUpdate = ProductDetail::whereNull('prenotato')->pluck('id')->toArray();
                ProductDetail::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
                $results = ProductDetail::whereIn('id', $idsToUpdate)->get();
                $status = 'ok';
                break;

            case 'product_details_ispettori':
                $idsToUpdate = ProductDetailIspettori::whereNull('prenotato')->pluck('id')->toArray();
                ProductDetailIspettori::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
                $results = ProductDetailIspettori::whereIn('id', $idsToUpdate)->get();
                $status = 'ok';
                break;

            case 'product_media':
                $idsToUpdate = ProductMedia::whereNull('prenotato')->pluck('id')->toArray();
                ProductMedia::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
                $results = ProductMedia::whereIn('id', $idsToUpdate)->get();
                $status = 'ok';
                break;

            // case 'users':
            //     $idsToUpdate = User::whereNull('prenotato')->pluck('id')->toArray();
            //     User::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
            //     $results = User::whereIn('id', $idsToUpdate)->get();
            //     $status = 'ok';
            //     break;

            default:
                $status = 'invalid_table';
                break;
        }

        // Ritorniamo i risultati
        return response()->json([
            'transactionNow' => $transactionNow,
            'table' => $tableName,
            'status' => $status,
            'data' => $results
        ]);
    }

    // per la colonna 'inviato'
    // private function confirmSyncTabella(string $tableName, string $transactionTimestamp): JsonResponse
    // {
    //     // $transactionNow = now();        //stampa esattamente data e ora di ora
    //     // $updatedRows = 0;
    //     // $status = 'failure';
    //     // // $results = collect();   
    //     // Log::info("Eseguito confirmSyncTabella per tabella: $tableName con transactionTimestamp: $transactionTimestamp");

    //     $transactionNow = now();        //stampa esattamente data e ora di ora
    //     Log::info("Eseguito syncTabella per tabella: $tableName con transactionNow: $transactionNow");
    //     $status = 'failure';
    //     $results = collect();



    //     // Mappa delle tabelle e dei rispettivi modelli
    //     switch ($tableName) {
    //         case 'product_ispettori':
    //             // ProductIspettori::where('prenotato', $transactionTimestamp)->whereNotNull('prenotato')->update(['inviato' =>  $transactionNow]);
    //             // $status = 'ok';
    //             $updatedRows = ProductIspettori::whereNotNull('prenotato')
    //                 ->where('prenotato', $transactionNow)
    //                 ->update(['inviato' => $transactionNow]);
    //             break;

    //         case 'product_details':
    //             // ProductDetail::where('prenotato', $transactionTimestamp)->update(['inviato' => $transactionNow]);
    //             // $status = 'ok';
    //             $updatedRows = ProductDetail::whereNotNull('prenotato')
    //                 ->where('prenotato', $transactionNow)
    //                 ->update(['inviato' => $transactionNow]);
    //             break;

    //         case 'product_details_ispettori':
    //             // ProductDetailIspettori::where('prenotato', $transactionTimestamp)->update(['inviato' => $transactionNow]);
    //             // $status = 'ok';
    //             $updatedRows = ProductDetailIspettori::whereNotNull('prenotato')
    //                 ->where('prenotato', $transactionNow)
    //                 ->update(['inviato' => $transactionNow]);
    //             break;

    //         case 'product_media':
    //             // ProductMedia::where('prenotato', $transactionTimestamp)->update(['inviato' => $transactionNow]);
    //             // $status = 'ok';
    //             $updatedRows = ProductMedia::whereNotNull('prenotato')
    //                 ->where('prenotato', $transactionNow)
    //                 ->update(['inviato' => $transactionNow]);
    //             break;

    //         // case 'users':
    //         //     $idsToUpdate = User::whereNull('prenotato')->pluck('id')->toArray();
    //         //     User::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
    //         //     $results = User::whereIn('id', $idsToUpdate)->get();
    //         //     $status = 'ok';
    //         //     break;

    //         default:
    //             $status = 'invalid_table';
    //             Log::warning("Nome tabella non valido: $tableName");
    //             break;
    //     }

    //     // Log per verificare il numero di righe aggiornate e lo stato dell'operazione
    //     Log::info("Numero di righe aggiornate in `$tableName`: $updatedRows. Stato: $status");

    //     // Determina lo status in base al numero di righe aggiornate
    //     return response()->json([
    //         'transactionNow' => $transactionNow,
    //         'table' => $tableName,
    //         'status' => $status,
    //         'data' => $results
    //     ]);
    // }
// }

    private function confirmSyncTabella(string $tableName, string $transactionTimestamp): JsonResponse
    {
        $transactionNow = date_parse_from_format('Y-m-d H:i:s', $transactionTimestamp);        //stampa esattamente data e ora di ora
        Log::info("Sto eseguendo digitalocean confirmSyncTabella per tabella: $tableName con transactionNow: $transactionNow");
        $status = 'failure';
        $results = collect();
        
        
        // Mappa delle tabelle e dei rispettivi modelli
        switch ($tableName) {
            case 'product_ispettori':
                // Aggiorna direttamente il campo 'inviato' per i record dove 'prenotato' non è nullo
                ProductIspettori::whereNotNull('prenotato')                 //dove prenotato non è nullo
                ->whereColumn('prenotato', $transactionNow)     //ed è uguale a $transactionNow ricevuto in argomento
                ->update(['inviato' => $transactionNow]);
                
                Log::info("eseguita digitalocean confirmSyncTabella per tabella: $tableName con transactionNow: $transactionNow");
                // Recupera i record aggiornati per conferma
                $results = ProductIspettori::whereNotNull('prenotato')->get();

                // Logga gli ID dei record aggiornati per monitoraggio
                Log::info("ID aggiornati in product_ispettori: ", $results->pluck('id')->toArray());
                $status = 'ok';
                break;

            case 'product_details':
                ProductDetail::whereNotNull('prenotato')->update(['inviato' => $transactionNow]);
                $results = ProductDetail::whereNotNull('prenotato')->get();
                Log::info("ID aggiornati in product_details: ", $results->pluck('id')->toArray());
                $status = 'ok';
                break;

            case 'product_details_ispettori':
                ProductDetailIspettori::whereNotNull('prenotato')->update(['inviato' => $transactionNow]);
                $results = ProductDetailIspettori::whereNotNull('prenotato')->get();
                Log::info("ID aggiornati in product_details_ispettori: ", $results->pluck('id')->toArray());
                $status = 'ok';
                break;

            case 'product_media':
                ProductMedia::whereNotNull('prenotato')->update(['inviato' => $transactionNow]);
                $results = ProductMedia::whereNotNull('prenotato')->get();
                Log::info("ID aggiornati in product_media: ", $results->pluck('id')->toArray());
                $status = 'ok';
                break;


            default:
                $status = 'invalid_table';
                break;
        }

        // Ritorniamo i risultati
        return response()->json([
            'transactionNow' => $transactionNow,
            'table' => $tableName,
            'status' => $status,
            'data' => $results
        ]);
    }
}