<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductDetailIntranet extends Model
{

    use HasFactory;
    
    protected $connection = 'Intranet';  // per connettere a sql server
    protected $table = 'product_details';       //nome tabella
    public $timestamps = false;
    protected $fillable = [
        'barcode',
        'note',
    ];
}