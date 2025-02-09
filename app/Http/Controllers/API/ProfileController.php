<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Job;

class ProfileController extends BaseController
{
    /**
     * Afficher la liste des profils.
     */
    public function index()
    {
        $profiles = Profile::with('job')->get();
        return response()->json($profiles);
    }

    /**
     * Créer un nouveau profil.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'cin' => 'required|string|max:20|unique:profiles,cin',
            'job_id' => 'required|exists:jobs,id',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'in:pending,approved,rejected'
        ]);

        $profile = Profile::create($validated);
        return response()->json($profile, 201);
    }

    /**
     * Afficher un profil spécifique.
     */
    public function show($id)
    {
        $profile = Profile::with('job')->find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profil non trouvé'], 404);
        }

        return response()->json($profile);
    }

    /**
     * Mettre à jour un profil existant.
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profil non trouvé'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'cin' => 'sometimes|string|max:20|unique:profiles,cin,' . $id,
            'job_id' => 'sometimes|exists:jobs,id',
            'phone_number' => 'sometimes|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'in:pending,approved,rejected'
        ]);

        $profile->update($validated);
        return response()->json($profile);
    }

    /**
     * Supprimer un profil.
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profil non trouvé'], 404);
        }

        $profile->delete();
        return response()->json(['message' => 'Profil supprimé avec succès']);
    }
}
