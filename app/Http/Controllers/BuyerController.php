<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\ProductMedia;
use Illuminate\Support\Facades\Log;

class BuyerController extends Controller
{
    public function index()
    {
        return view('app.homepage');
    }

    public function store(Request $request)
    {
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
}
