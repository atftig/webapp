<?php

namespace App\Services;

use App\Models\ProductMediaIntranet;
use App\Models\UserIntranet;
use App\Models\ProductDetailIntranet;
use App\Models\ProductMedia;
use App\Models\ProductDetail;
use App\Models\User;
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

        // return $webappMedia;
       
        // Esegui l'insert dei dati nel database SQL Server (Intranet)
        foreach ($webappDetail as $detail) {
            ProductDetailIntranet::on('Intranet')->create([
                'id' => $detail->id,
                'name' => $detail->name,
                'description' => $detail->description,
            ]);
        }

        foreach ($webappMedia as $media) {
            ProductMediaIntranet::on('Intranet')->create([
                'id' => $media->id,
                'product_id' => $media->product_id,
                'url' => $media->url,
            ]);
        }

        foreach ($webappUser as $user) {
            UserIntranet::on('Intranet')->create([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        return "Dati inseriti con successo nel database Intranet";
    }
}