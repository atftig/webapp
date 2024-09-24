<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{

    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'product_media';       //nome tabella
    // protected $connection = 'Intranet';  // per connettere a sql server

    public $timestamps = false;
    protected $fillable = [
        // 'id',
        'barcode',
        'photo',
        'estensione'       // Estensione del file (es. .jpeg, .jpg, .png)

    ];
}