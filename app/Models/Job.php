<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs'; // Nom de la table

    protected $primaryKey = 'id'; // Clé primaire

    public $timestamps = false; // Pas de created_at ni updated_at

    protected $fillable = [
        'name',
        'name_ar',
    ];

    public function profiles()
    {
        return $this->hasMany(Profile::class, 'job_id');
    }
}
