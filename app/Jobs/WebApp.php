<?php

namespace App\Jobs;
use App\Services\WebappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WebApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    
    //  $service è un oggetto di tipo WebappService
    // essere un oggetto di tipo x vuol dire semplicemente che facendo $oggetto-> posso chiamare tutte le funzioni presenti in x quindi ->Webapp(); è la funzione che trovo all'interno di WebappService
    // x è un file esterno, che nel nostro caso è un servizio chiamato WebappService
     public function handle(WebappService $service): void
    {
        $service->Webapp();
    }
}
