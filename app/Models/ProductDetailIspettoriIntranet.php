<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailIspettoriIntranet extends Model
{
    use HasFactory;

    protected $connection = 'Intranet';
    public $timestamps = false;

    protected $table = 'product_details_ispettori';  // Nome della tabella
    protected $fillable = [
        'barcode',
        'prezzo',
        // 'foto',
        // 'note',
        'created_at'
    ]; 
}
