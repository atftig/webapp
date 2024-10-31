<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductMediaIntranet extends Model
{

    use HasFactory;
    protected $table = 'product_media';       //nome tabella
    protected $connection = 'Intranet';  // per connettere a sql server

    public $timestamps = false;
    protected $fillable = [
        'barcode',
        'photo',
        'estensione',       // Estensione del file (es. .jpeg, .jpg, .png)
        'prenotato',
        'inviato'
    ];
}