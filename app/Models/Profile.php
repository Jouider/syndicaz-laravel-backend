<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles'; // Nom de la table

    protected $primaryKey = 'id'; // Clé primaire


    protected $fillable = [
        'first_name',
        'last_name',
        'cin',
        'job_id',
        'phone_number',
        'email',
        'latitude',
        'longitude',
        'status',
        'created_at'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
