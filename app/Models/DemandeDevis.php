<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDevis extends Model
{
    use HasFactory;

    protected $table = 'demande_devis';
    protected $fillable = [
        'status','first_name', 'last_name', 'email', 'phone', 'city', 'state', 'zip_code',
        'board_position', 'community_name', 'community_type', 'units', 
        'on_site_management', 'annual_budget', 'assessment_frequency', 
        'process_stage', 'amenities'
    ];

    public static function getAvailableStatuses()
    {
        return [
            'en_attente',   // 🟡 Nouveau devis
            'en_cours',     // 🟠 L’admin examine le devis
            'devis_envoye', // 🔵 Offre envoyée au client
            'accepte',      // 🟢 Client a validé l’offre
            'refuse',       // 🔴 Client a refusé
            'revision',     // 🔄 Client demande des modifications
        ];
    }
}
