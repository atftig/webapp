<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIspettori extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
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
