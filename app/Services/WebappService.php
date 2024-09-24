<?php

namespace App\Services;

use App\Models\ProductMediaIntranet;
use App\Models\UserIntranet;
use App\Models\ProductDetailIntranet;
use App\Models\ProductMedia;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;

/**
 * Class webappService.
 */
class WebappService
{
    public function Webapp()
    {

        //Ottieni i dati dal database MySQL
        $webappMedia = ProductMedia::all();
        $webappDetail = ProductDetail::all();
        $webappUser = User::all();
        Log::info($webappMedia);
        Log::info($webappDetail);
        Log::info($webappUser);

        // return $webappMedia;
       
        // Esegui l'insert dei dati nel database SQL Server (Intranet)
        foreach ($webappDetail as $detail) {
            ProductDetailIntranet::create([
                'id' => $detail->id,
                'name' => $detail->name,
                'description' => $detail->description,
            ]);
        }

        foreach ($webappMedia as $media) {
            ProductMediaIntranet::create([
                'id' => $media->id,
                'product_id' => $media->product_id,
                'url' => $media->url,
            ]);
        }

        foreach ($webappUser as $user) {
            UserIntranet::create([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        return "Dati inseriti con successo nel database Intranet";
    }
}