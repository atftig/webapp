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
        $array = [];

        if($tableName == 'product_ispettori'){
            ProductIspettori::whereNull('prenotato')->update(['prenotato' => $transactionNow]);
            $array = ProductIspettori::where('prenotato', $transactionNow)->get()->toArray();
            $status = 'ok';
        }

        return response()->json([
            'transactionNow' => $transactionNow,
            'table' => $tableName,
            'status' => $status,
            'data' => $array
        ]);
    }
}
