<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'cin', 'job_id', 
        'phone_number', 'email', 'latitude', 'longitude'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
