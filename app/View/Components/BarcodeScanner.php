<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BarcodeScanner extends Component
{
    /**
     * Crea una nuova istanza del componente.
     *
     * @return void
     */
    public function __construct()
    {
        // Logica opzionale del componente
    }

    /**
     * Ottieni il contenuto del componente.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.barcode-scanner');
    }
}
