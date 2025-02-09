<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends BaseController
{
    /**
     * Affiche la liste des jobs.
     */
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    /**
     * Enregistre un nouveau job.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:25',
        ]);

        $job = Job::create($request->all());

        return response()->json(['message' => 'Job créé avec succès', 'job' => $job], 201);
    }

    /**
     * Affiche un job spécifique.
     */
    public function show($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job non trouvé'], 404);
        }

        return response()->json($job);
    }

    /**
     * Met à jour un job.
     */
    public function update(Request $request, $id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job non trouvé'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:25',
        ]);

        $job->update($request->all());

        return response()->json(['message' => 'Job mis à jour avec succès', 'job' => $job]);
    }

    /**
     * Supprime un job.
     */
    public function destroy($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job non trouvé'], 404);
        }

        $job->delete();

        return response()->json(['message' => 'Job supprimé avec succès']);
    }
}
