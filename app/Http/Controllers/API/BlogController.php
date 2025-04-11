<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Blog::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create($validated);

        return response()->json($blog, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return response()->json($blog);
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            $validated = $request->validate([
                'title'   => 'nullable|string|max:255',
                'content' => 'nullable|string',
                'image'   => 'nullable|image|max:2048',
            ]);
    
            if ($request->hasFile('image')) {
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image);
                }
                $validated['image'] = $request->file('image')->store('blogs', 'public');
            }
    
            $blog->update($validated);
            
            return response()->json([
                'status' => 'succès',
                'message' => 'Blog mis à jour avec succès',
                'data' => $blog->fresh()
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'erreur',
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erreur',
                'message' => 'Une erreur est survenue lors de la mise à jour du blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // Supprimer un blog
    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
