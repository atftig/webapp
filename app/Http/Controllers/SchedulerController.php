<?php

namespace App\Http\Controllers;

use App\Models\ProductIspettori;
use App\Models\ProductDetail;
use App\Models\ProductDetailIspettori;
use App\Models\ProductMedia;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchedulerController extends Controller
{

    public function __invoke(Request $request): mixed
    {
        // Log della richiesta ricevuta
        Log::info("Richiesta ricevuta: " . json_encode($request->all()));
        Log::info("Header X-APIKEY: " . $request->header('X-APIKEY'));

        $apiKey = config('app.scheduler_api_key');
        $myResp = null;
        try {
            if ($request->header('X-APIKEY') == $apiKey) {
                $transactionTimestamp = $request->input('transactionNow');
                if ($request->has('syncTabella')) {
                    $myResp = $this->syncTabella($request->input('syncTabella'));

                    // questo è per la colonna 'inviato'
                } else if ($request->has('confirmSyncTabella') && $transactionTimestamp != null) {
                    $myResp = $this->confirmSyncTabella($request->input('confirmSyncTabella'), $transactionTimestamp);
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
        $transactionNow = now();        //stampa esattamente data e ora di ora
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
    private function confirmSyncTabella(string $tableName, string $transactionTimestamp): JsonResponse
    {
        $transactionNow = now();        //stampa esattamente data e ora di ora
        $updatedRows = 0;
        $status = 'failure';
        // $results = collect();   
        Log::info("Eseguito confirmSyncTabella per tabella: $tableName con transactionTimestamp: $transactionTimestamp");


        // Mappa delle tabelle e dei rispettivi modelli
        switch ($tableName) {
            case 'product_ispettori':
                // ProductIspettori::where('prenotato', $transactionTimestamp)->whereNotNull('prenotato')->update(['inviato' =>  $transactionNow]);
                // $status = 'ok';
                $updatedRows = ProductIspettori::whereNotNull('prenotato')
                    ->where('prenotato', $transactionTimestamp)
                    ->update(['inviato' => $transactionNow]);
                break;

            case 'product_details':
                // ProductDetail::where('prenotato', $transactionTimestamp)->update(['inviato' => $transactionNow]);
                // $status = 'ok';
                $updatedRows = ProductDetail::whereNotNull('prenotato')
                    ->where('prenotato', $transactionTimestamp)
                    ->update(['inviato' => $transactionNow]);
                break;

            case 'product_details_ispettori':
                // ProductDetailIspettori::where('prenotato', $transactionTimestamp)->update(['inviato' => $transactionNow]);
                // $status = 'ok';
                $updatedRows = ProductDetailIspettori::whereNotNull('prenotato')
                    ->where('prenotato', $transactionTimestamp)
                    ->update(['inviato' => $transactionNow]);
                break;

            case 'product_media':
                // ProductMedia::where('prenotato', $transactionTimestamp)->update(['inviato' => $transactionNow]);
                // $status = 'ok';
                $updatedRows = ProductMedia::whereNotNull('prenotato')
                    ->where('prenotato', $transactionTimestamp)
                    ->update(['inviato' => $transactionNow]);
                break;

            // case 'users':
            //     $idsToUpdate = User::whereNull('prenotato')->pluck('id')->toArray();
            //     User::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);
            //     $results = User::whereIn('id', $idsToUpdate)->get();
            //     $status = 'ok';
            //     break;

            default:
                $status = 'invalid_table';
                Log::warning("Nome tabella non valido: $tableName");
                break;
        }

        // Log per verificare il numero di righe aggiornate e lo stato dell'operazione
        Log::info("Numero di righe aggiornate in `$tableName`: $updatedRows. Stato: $status");

        // Determina lo status in base al numero di righe aggiornate
        if ($updatedRows > 0) {
            $status = 'ok';
        }
        // Ritorniamo i risultati
        return response()->json([
            'transactionNow' => $transactionNow,
            'table' => $tableName,
            'status' => $status,
            'data' => []  // numero di record aggiornati
        ]);
    }
}
