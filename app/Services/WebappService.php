<?php

// TUTTO COMMENTATO PERCHE IN QUESTO FILE NON SERVE IL SERVICE -> LO USO IN INTRANET-WS-2.0

// namespace App\Services;
// ------------------------------buyer------------
// use App\Models\ProductMediaIntranet;
// use App\Models\UserIntranet;
// use App\Models\ProductDetailIntranet;
// use App\Models\ProductMedia;
// use App\Models\ProductDetail;
// use App\Models\User;
// ------------------------------ispettori------------
// use App\Models\ProductDetailIspettori;
// use App\Models\ProductDetailIspettoriIntranet;
// use App\Models\ProductIspettori;
// use App\Models\ProductIspettoriIntranet;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;

/**
 * Class webappService.
 */
// class WebappService
// {
//     public function webapp()
//     {
//         try {
//             // Ottiene i dati dal database MySQL
//             $webappMedia = ProductMedia::all();
//             $webappDetail = ProductDetail::all();
//             $webappUser = User::all();
//             $webappDetailIspettori = ProductDetailIspettori::all();
//             $webappIspettori = ProductIspettori::all();

//             Log::info("ciaone");

            // // Log dei dati ottenuti
            // Log::info('Dettagli media:', $webappMedia->toArray());
            // Log::info('Dettagli prodotti:', $webappDetail->toArray());
            // Log::info('Dettagli utenti:', $webappUser->toArray());
            // Log::info('Dettagli ispettori:', $webappDetailIspettori->toArray());
            // Log::info('Ispettori:', $webappIspettori->toArray());


            // // Esegui l'insert dei dati nel database SQL Server (Intranet)
            // foreach ($webappDetail as $detail) {
            //     if (empty($detail->barcode) || empty($detail->note)) {
            //         Log::warning('Record non valido:', $detail->toArray());
            //         continue;  // Salta record non valido
            //     }

            //     ProductDetailIntranet::updateOrCreate(
            //         ['barcode' => $detail->barcode],
            //         [
            //             'note' => $detail->note,
            //             'created_at' => $detail->created_at ?? now(),
            //         ]
            //     );
            // }

            // foreach ($webappMedia as $media) {
            //     ProductMediaIntranet::updateOrCreate(
            //         ['barcode' => $media->barcode,],
            //         [
            //             'photo' => $media->photo,
            //             'estensione' => $media->estensione,
            //         ]
            //     );
            // }

            // foreach ($webappUser as $user) {
            //     UserIntranet::updateOrCreate(
            //         ['name' => $user->name],
            //         [
            //             'password' => $user->password,
            //             'ruolo' => $user->ruolo,
            //         ]
            //     );
            // }

            // foreach ($webappDetailIspettori as $detailI) {
            //     $insertedRecord = ProductDetailIspettoriIntranet::updateOrCreate(
            //         ['barcode' => $detailI->barcode, 'id_product_ispettori' => $detailI->id_product_ispettori],
            //         [
            //             'prezzo' => $detailI->prezzo,
            //             'foto' => $detailI->foto,
            //             'note' => $detailI->note,
            //             'created_at' => $detailI->created_at ?? now(),
            //             'id_user' => $detailI->id_user,
            //         ]
            //     );
            // }


            // foreach ($webappIspettori as $ispettori) {
            //     Log::info('Processando ispettori:', $ispettori->toArray());

            //     // Controlla se il record esiste
            //     $existingRecord = ProductIspettoriIntranet::where('insegna', $ispettori->insegna)
            //         ->where('pv', $ispettori->pv)
            //         ->first();

                // Usa l'ID esistente se il record è già presente, altrimenti genera un nuovo UUID
                // $id = $existingRecord ? $existingRecord->id : Str::uuid();

                // ProductIspettoriIntranet::updateOrCreate(
                //     [
                //         'insegna' => $ispettori->insegna,
                //         'pv' => $ispettori->pv,
                //     ],
                //     [
                //         'id' => $id, // Usa l'ID esistente o genera un nuovo UUID
                //         'created_at' => $ispettori->created_at ?? now(),
                //         'prenotato' => $ispettori->prenotato, // Assicurati di passare il valore di prenotato
                //     ]
                                                                                                                            // $id = Str::uuid(); // Genera un UUID unico per id

                                                                                                                            // ProductIspettoriIntranet::updateOrCreate(
                                                                                                                            //     [
                                                                                                                            //         'insegna' => $ispettori->insegna,
                                                                                                                            //         'pv' => $ispettori->pv,
                                                                                                                            //     ],
                                                                                                                            //     [
                                                                                                                            //         'id' => $id, // Assegna l'UUID alla colonna id
                                                                                                                            //         'created_at' => $ispettori->created_at ?? now(),
                                                                                                                            //     ]
//                 );
//             }

//             Log::info('Dati inseriti con successo nel database Intranet');
//             return "Dati inseriti con successo nel database Intranet";
//         } catch (\Exception $e) {
//             Log::error($e->getMessage());
//             return null;
//         }
//     }
// }