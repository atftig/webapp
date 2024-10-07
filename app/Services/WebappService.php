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
            
                // Inserisci il recordd
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

            // foreach ($webappUser as $user) {
            //     dump('user');
            //     UserIntranet::updateOrCreate([
            //         'name' => $user->name,
            //         'password' => $user->password, 
            //         'ruolo' => $user->ruolo,
            //     ],[
            //         'name' => $user->name,
            //         'password' => $user->password, 
            //         'ruolo' => $user->ruolo,
            //     ]);
            // }

            foreach ($webappUser as $user) {
                // Controlla se l'utente esiste già nella tabella dbo.users
                $existingUser = UserIntranet::where('name', $user->name)->first();
            
                if ($existingUser) {
                    Log::info("L'utente {$user->name} esiste già. Salto l'inserimento.");
                    continue; // Salta l'inserimento se l'utente esiste già
                }
            
                try {
                    // Inserisci il nuovo utente solo se non esiste
                    UserIntranet::create([
                        'name' => $user->name,
                        'password' => $user->password,
                        'ruolo' => $user->ruolo,  // Assicurati che il campo ruolo sia presente
                    ]);
                    Log::info("Inserito nuovo utente {$user->name} con successo.");
                } catch (\Exception $e) {
                    Log::error("Errore durante l'inserimento dell'utente {$user->name}: {$e->getMessage()}");
                }
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
                ProductIspettoriIntranet::create([
                    'insegna' => $ispettori->insegna,
                    'pv' => $ispettori->pv, 
                    'created_at' => $ispettori->created_at ?? now(),
                ]);
            }

            Log::info('Dati inseriti con successo nel database Intranet');
            return "Dati inseriti con successo nel database Intranet";
        } catch (\Exception $e) {
            dump($e->getMessage());

            Log::error($e->getMessage());
        }
    }
}