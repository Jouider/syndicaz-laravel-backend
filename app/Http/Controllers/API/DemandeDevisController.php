<?php

namespace App\Http\Controllers\API;

use App\Models\DemandeDevis;
use Illuminate\Http\Request;

class DemandeDevisController extends BaseController
{
    // Liste toutes les demandes
    public function index()
    {
        return response()->json(DemandeDevis::all());
    }

    // Afficher une demande spécifique
    public function show($id)
    {
        return response()->json(DemandeDevis::findOrFail($id));
    }

    // Ajouter une nouvelle demande
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'board_position' => 'required|in:President,Vice President,Treasurer,Secretary,Director,Builder/Developer,Committee Member',
            'community_name' => 'required|string|max:255',
            'community_type' => 'required|in:Single Family,Condominium,Townhome,High Rise,Mixed-use,Commercial,Developer',
            'units' => 'required|integer|min:50',
            'on_site_management' => 'required|in:Yes,No',
            'annual_budget' => 'required|numeric|min:0',
            'assessment_frequency' => 'required|in:Monthly,Quarterly,Annually',
            'process_stage' => 'required|in:Initial Inquiry,In Discussion,Ready to Start',
            'amenities' => 'nullable|string',
        ]);

        $demande = DemandeDevis::create($validated);

        return response()->json($demande, 201);
    }

    // Mettre à jour une demande
    public function update(Request $request, $id)
    {
        $demande = DemandeDevis::findOrFail($id);
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|max:150',
            'phone' => 'sometimes|string|max:20',
            'city' => 'sometimes|string|max:100',
            'state' => 'sometimes|string|max:100',
            'zip_code' => 'sometimes|string|max:10',
            'board_position' => 'sometimes|in:President,Vice President,Treasurer,Secretary,Director,Builder/Developer,Committee Member',
            'community_name' => 'sometimes|string|max:255',
            'community_type' => 'sometimes|in:Single Family,Condominium,Townhome,High Rise,Mixed-use,Commercial,Developer',
            'units' => 'sometimes|integer|min:50',
            'on_site_management' => 'sometimes|in:Yes,No',
            'annual_budget' => 'sometimes|numeric|min:0',
            'assessment_frequency' => 'sometimes|in:Monthly,Quarterly,Annually',
            'process_stage' => 'sometimes|in:Initial Inquiry,In Discussion,Ready to Start',
            'amenities' => 'nullable|string',
        ]);

        $demande->update($validated);

        return response()->json($demande);
    }

    // Supprimer une demande
    public function destroy($id)
    {
        $demande = DemandeDevis::findOrFail($id);
        $demande->delete();

        return response()->json(['message' => 'Demande supprimée avec succès']);
    }

    public function updateStatus(Request $request, $id)
{
    $demande = DemandeDevis::findOrFail($id);

    $validated = $request->validate([
        'status' => 'required|in:en_attente,en_cours,devis_envoye,accepte,refuse,revision',
    ]);

    $demande->update(['status' => $validated['status']]);

    return response()->json([
        'message' => 'Statut mis à jour avec succès',
        'demande' => $demande
    ]);
}
}
