<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts'; // Nom de la table

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
    ];

    public $timestamps = true;
}
