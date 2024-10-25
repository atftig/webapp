<?php

namespace App\Http\Controllers;

use App\Models\ProductIspettori;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function __invoke(Request $request) : mixed
    {
        $apiKey = config('app.scheduler_api_key');
        $myResp = null;

        if ($request->header('X-APIKEY') == $apiKey)
        {
            if($request->has('syncTabella')){
                $myResp = $this->syncTabella($request->input('syncTabella'));
            }
            else{
                $myResp = response('not found');
            }
        }else
        {
          
            $myResp = response()->json([
                'error' => 'apikey not valid',
            ]);
        }
        return $myResp;
    }

    private function syncTabella(string $tableName): JsonResponse{
        $transactionNow = now();
        $status = 'failure';
        $results = collect();

        if($tableName == 'product_ispettori'){
            $idsToUpdate = ProductIspettori::whereNull('prenotato')->pluck('id')->toArray(); // prendo gli id delle righe da ritornare(prenotato = null)
            ProductIspettori::whereIn('id', $idsToUpdate)->update(['prenotato' => $transactionNow]);   //qui li aggiorna
            $results = ProductIspettori::whereIn('id', $idsToUpdate)->get(); // otteniamo le righe aggiornate
            $status = 'ok';
        }

        // ritorniamo i risultati   
        return response()->json([
            'transactionNow' => $transactionNow,
            'table' => $tableName,
            'status' => $status,
            'data' => $results
        ]);
    }
}
