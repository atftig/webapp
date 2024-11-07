<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\ProductMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductIspettori;
use App\Models\ProductDetailIspettori;


class BuyerController extends Controller
{
    public function index()
    {
        return view('app.homepage');
    }

    public function store(Request $request)
    {

        // if (!session()->has('id_user')) {
        //     return redirect()->route('login')->withErrors(['session' => 'La sessione è scaduta o non valida.']);
        // }

        // Validazione dei dati
        $validatedData = $request->validate([
            'barcode' => 'required|string|max:100',
            'photo' => 'required|array',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif', // Validazione dei file immagine
            'note' => 'required|string',
        ]);

        // Controllo se il barcode esiste già
        if (ProductDetail::where('barcode', $validatedData['barcode'])->exists()) {
            return redirect()->back()->withErrors(['barcode' => 'Il barcode è già presente nel sistema.']);
        }

        // Creazione del nuovo productDetail
        $productDetail = new ProductDetail();
        $productDetail->barcode = $validatedData['barcode'];
        $productDetail->note = $validatedData['note'];
        $productDetail->save();


        // Array per memorizzare i nomi dei file salvati
        $fileNames = [];

        // Caricamento delle foto e salvataggio nel filesystem
        foreach ($request->file('photo') as $file) {
            // Crea un nome univoco per ogni immagine
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // Sposta l'immagine nella cartella 'public/images'
            $file->move(public_path('images'), $imageName);

            // Crea un nuovo record per ogni immagine caricata
            $productMedia = new ProductMedia();
            $productMedia->barcode = $productDetail->barcode;
            $productMedia->photo = $imageName; // Salva solo il nome del file
            $productMedia->estensione = '.' . $file->getClientOriginalExtension();
            $productMedia->created_at = date('Y-m-d H:i:s');
            $productMedia->save();

            // Memorizza il nome del file salvato
            $fileNames[] = $imageName;
        }

        // Passa solo i nomi dei file, non gli oggetti UploadedFile
        return redirect()->route('aggiunta-page')->with([
            'barcode' => $productDetail->barcode,
            'photos' => $fileNames,  // Passa i nomi dei file salvati
            'note' => $productDetail->note,
        ]);
    }

    // ---------------------------------ISPETTORI-----------------------------------------------------------------------


    public function storePv(Request $request)
    {
        // Validazione dei dati del form
        $validatedData = $request->validate([
            'insegna' => 'required|string|max:50',
            'pv' => 'required|string|max:50',
            'insegna_altro' => 'nullable|string'
        ]);

        // $validatedData = $request->input();

        // Creazione di un nuovo record nella tabella 'product_ispettori'
        ProductIspettori::updateOrCreate(
            [
                'id' => trim($validatedData['insegna']) . "-" . trim($validatedData['pv'])
            ],
            [
                'insegna' => trim($validatedData['insegna']),
                'pv' => trim($validatedData['pv']),
                'created_at' => now(),  // Imposta la data di creazione
            ]
        );

        // ProductIspettori::upsert(
        //     values: [
        //         [
        //             'insegna-pv' => trim($validatedData['insegna']) . "-" . trim($validatedData['pv']),
        //             'pv' => trim($validatedData['pv']),
        //             'insegna' => trim($validatedData['insegna']),
        //         ]
        //     ],
        //     uniqueBy: ['insegna-pv'],
        //     update: ['pv', 'insegna']
        // );

        // Salva i dati nella sessione
        // session(['insegna' => $validatedData['insegna']]);
        // session(['pv' => $validatedData['pv']]);
        // session(['id_product_ispettori'=> trim($validatedData['insegna'])."-".trim($validatedData['pv'])]);

        // Reindirizzamento dopo il salvataggio con un messaggio di successo
        Log::info('Dati salvati per l\'insegna e punto vendita', [
            'insegna' => $validatedData['insegna'],
            'pv' => $validatedData['pv']
        ]);

        // return redirect()->to('/homepage-ispettori')->with('success', 'Dati salvati con successo!');
        return view('app.homepage-ispettori', [
            'insegna' => trim($validatedData['insegna']),
            'pv' => trim($validatedData['pv']),
            'id_product_ispettori' => trim($validatedData['insegna']) . "-" . trim($validatedData['pv']),
        ]);
    }
}
