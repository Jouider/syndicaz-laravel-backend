<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDevis extends Model
{
    use HasFactory;

    protected $table = 'demande_devis';
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'city', 'state', 'zip_code',
        'board_position', 'community_name', 'community_type', 'units', 
        'on_site_management', 'annual_budget', 'assessment_frequency', 
        'process_stage', 'amenities'
    ];
}
