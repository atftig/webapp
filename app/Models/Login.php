<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'users';     //nome della tabella nel database
    public $timestamps = false;     //se la tabella non ha colonne per timestamp

    protected $fillable = ['name', 'password']; //colonne da proteggere

}
