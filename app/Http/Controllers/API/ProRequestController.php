<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProRequest;
use App\Models\Profile;
use App\Models\Job;
use App\Http\Controllers\Controller;

class ProRequestController extends Controller
{
    /**
     * Afficher toutes les demandes pro.
     */
    public function index()
    {
        $requests = ProRequest::with('job')->get();
        return response()->json($requests);
    }

    /**
     * Enregistrer une nouvelle demande pro.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'cin' => 'required|string|max:20|unique:pro_requests,cin',
            'job_id' => 'required|exists:jobs,id',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $requestPro = ProRequest::create($validated);
        return response()->json($requestPro, 201);
    }

    /**
     * Voir une demande pro spécifique.
     */
    public function show($id)
    {
        $requestPro = ProRequest::with('job')->find($id);

        if (!$requestPro) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        return response()->json($requestPro);
    }

    /**
     * Accepter une demande et la convertir en profil professionnel.
     */
    public function accept($id)
    {
        $requestPro = ProRequest::find($id);

        if (!$requestPro) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        // Créer un profil avec les mêmes informations
        $profile = Profile::create([
            'first_name' => $requestPro->first_name,
            'last_name' => $requestPro->last_name,
            'cin' => $requestPro->cin,
            'job_id' => $requestPro->job_id,
            'phone_number' => $requestPro->phone_number,
            'email' => $requestPro->email,
            'latitude' => $requestPro->latitude,
            'longitude' => $requestPro->longitude,
            'status' => 'approved',
        ]);

        // Supprimer la demande après acceptation
        $requestPro->delete();

        return response()->json(['message' => 'Demande acceptée et ajoutée aux professionnels', 'profile' => $profile]);
    }

    /**
     * Rejeter une demande et la supprimer.
     */
    public function reject($id)
    {
        $requestPro = ProRequest::find($id);

        if (!$requestPro) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        $requestPro->delete();

        return response()->json(['message' => 'Demande rejetée et supprimée']);
    }
}
