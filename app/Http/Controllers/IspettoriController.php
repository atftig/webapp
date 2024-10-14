<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductDetailIspettori;

class IspettoriController extends Controller
{
    public function index($insegna = null, $pv = null)
    {
        return view('app.homepage-ispettori', [
            'pv' => $pv,
            'insegna' => $insegna
        ]);
    }

    // ---------------------------------ISPETTORI-----------------------------------------------------------------------
    public function storeDetails(Request $request)
    {
        //dichiaro la variabile
        $ciao = $request->input('id_product_ispettori');

        // Validazione dei dati del form
        $validatedData = $request->validate([
            'barcode' => 'required|string|max:100',
            'prezzo' => 'required|numeric|min:0|max:99999999.99',
            'foto' => 'nullable|array', // Foto è facoltativa
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Regola per le singole foto
            'note' => 'nullable|string|max:100', // Note facoltative
        ]);

        // Salvataggio dei dettagli del prodotto
        $productDetail = ProductDetailIspettori::create(
            [
                'barcode' => $validatedData['barcode'],
                'prezzo' => $validatedData['prezzo'],
                'note' => $validatedData['note'] ?? null, // Assegna null se non ci sono note
                // 'id_product_ispettori' => $request->input('id_product_ispettori') ,
                // utilizzo la variabile
                'id_product_ispettori' => $ciao,
                // 'id_product_ispettori' => session('id_product_ispettori'),
                'id_user' => session('id_user'),

                'created_at' => now(),  // Imposta la data di creazione
            ]
        );


        // Salva i dettagli nella sessione
        // session(['barcode' => $productDetail->barcode]);
        // session(['prezzo' => $validatedData['prezzo']]);
        // session(['note' => $validatedData['note'] ?? null]);

        // Logica per il salvataggio delle foto
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                // Salva il file e associa al prodotto
                $path = $file->store('images', 'public'); // Salva nella cartella 'storage/app/public/images'

                // Se hai una relazione immagini, puoi salvare il percorso:
                $productDetail->images()->create(['path' => $path]);
            }
        }
        \Log::info('Dati salvati per barcode, prezzo e note', [
            'barcode' => $validatedData['barcode'],
            'prezzo' => $validatedData['prezzo'],
            'note' => $validatedData['note'] ?? null,
        ]);

        // return redirect()->route('aggiunta-page-ispettori');

        return view('app.aggiunta-page-ispettori', [
            'barcode' => $validatedData['barcode'],
            'prezzo' => $validatedData['prezzo'],
            // 'note' => $validatedData['note'] ,
        ]);
    }
}
