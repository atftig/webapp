<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Log;

class BuyerController extends Controller
{
    public function index()
    {
        return view('app.homepage');
    }

    public function store(Request $request)
    {
        // validazione dati
        $validatedData = $request->validate([
            'barcode' => 'required|string|max:100',
            // 'photo' => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => 'required|string',
        ]);

        // dd($validatedData);

        //gestione caricamento della foto
        $productDetail = new ProductDetail();
        $productDetail->barcode = $validatedData['barcode'];
        $productDetail->photo = $validatedData['photo'];
        $productDetail->note = $validatedData['note'];
        $productDetail->save();

        //reindirizza l'utente a una pag di successo
        return redirect()->route('aggiunta-page');
    }
}