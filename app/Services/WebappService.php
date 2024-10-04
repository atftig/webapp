<?php

namespace App\Services;
// ------------------------------buyer------------
use App\Models\ProductMediaIntranet;
use App\Models\UserIntranet;
use App\Models\ProductDetailIntranet;
use App\Models\ProductMedia;
use App\Models\ProductDetail;
use App\Models\User;
// ------------------------------ispettori------------
use App\Models\ProductDetailIspettori;
use App\Models\ProductDetailIspettoriIntranet;
use App\Models\ProductIspettori;
use App\Models\ProductIspettoriIntranet;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;

/**
 * Class webappService.
 */
class WebappService
{
    public function webapp()
    {
        try {
            // Ottiene i dati dal database MySQL
            $webappMedia = ProductMedia::all();
            $webappDetail = ProductDetail::all();
            $webappUser = User::all();
            $webappDetailIspettori = ProductDetailIspettori::all();
            $webappIspettori = ProductIspettori::all();
            

            Log::info("ciao");

            // Esegui l'insert dei dati nel database SQL Server (Intranet)
            foreach ($webappDetail as $detail) {
                Log::info($detail->toArray());
            
                if (empty($detail->barcode) || empty($detail->note)) {
                    Log::warning('Record non valido:', $detail->toArray());
                    continue;  // Salta record non valido
                }
            
                // Controlla se il barcode esiste già
                $existingDetail = ProductDetailIntranet::where('barcode', $detail->barcode)->first();
                if ($existingDetail) {
                    Log::info("Il barcode già esiste: {$detail->barcode}. Salta l'inserimento.");
                    continue; // Salta l'inserimento
                }
            
                // Inserisci il record
                try {
                    ProductDetailIntranet::create([
                        'barcode' => $detail->barcode,
                        'note' => $detail->note,
                        'created_at' => $detail->created_at ?? now(),
                    ]);
                } catch (\Exception $e) {
                    Log::error("Errore durante l'inserimento: {$e->getMessage()}");
                }
            }
            

            foreach ($webappMedia as $media) {

                ProductMediaIntranet::create([
                    'id' => $media->id,
                    'barcode' => $media->barcode,
                    'photo' => $media->photo,
                    'estensione' => $media->estensione,
                ]);
            }

            foreach ($webappUser as $user) {
                UserIntranet::create([
                    'name' => $user->name,
                    'password' => $user->password, 
                ]);
            }

            foreach ($webappDetailIspettori as $detailI) {
                ProductDetailIspettoriIntranet::create([
                    'barcode' => $detailI->barcode,
                    'prezzo' => $detailI->prezzo, 
                    'foto' => $detailI->foto, 
                    'note' => $detailI->note, 
                    'created_at' => $detailI->created_at ?? now(),
                ]);
            }

            foreach ($webappIspettori as $ispettori) {
                ProductDetailIspettoriIntranet::create([
                    'insegna' => $ispettori->barcode,
                    'pv' => $ispettori->prezzo, 
                    'created_at' => $ispettori->created_at ?? now(),
                ]);
            }

            Log::info('Dati inseriti con successo nel database Intranet');
            return "Dati inseriti con successo nel database Intranet";
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}