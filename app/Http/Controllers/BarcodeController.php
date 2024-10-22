<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


// controller per la ricerca internet del barcode inserito nell'input in home buyer
class BarcodeController extends Controller
{
    public function search(Request $request)
    {
        $barcode = $request->input('barcode');
        $searchUrl = "https://www.google.com/search?q=" . urlencode($barcode);
        
        return redirect()->away($searchUrl);
    }
}
