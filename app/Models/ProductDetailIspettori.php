<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailIspettori extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    public $timestamps = false;

    protected $table = 'product_details_ispettori';  // Nome della tabella
    protected $fillable = [
        'barcode',
        'prezzo',
        'id_product_ispettori',
        'id_user',
        // 'foto',
        // 'note',
        'created_at'
    ]; 
}
