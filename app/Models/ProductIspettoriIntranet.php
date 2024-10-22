<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIspettoriIntranet extends Model
{
    use HasFactory;

    protected $connection = 'Intranet';
    public $timestamps = false;

    protected $table = 'product_ispettori';  // Nome della tabella
    protected $primaryKey = 'id';
    protected $fillable = [
        'insegna',
        'pv',
        'created_at',
        'id',
    ];
}
