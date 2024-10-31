<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{

    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'product_details';       //nome tabella

    // protected $connection = 'Intranet';  // per connettere a sql server
    public $timestamps = false;
    protected $fillable = [
        'barcode',
        'note',
        'prezzo',
        'created_at',
        'id_product_ispettori',
        'id_user',
        'prenotato',
        'inviato'
    ];
}