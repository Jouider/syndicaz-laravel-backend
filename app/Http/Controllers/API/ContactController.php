<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends BaseController
{
    // Récupérer tous les contacts
    public function index()
    {
        return response()->json(Contact::all());
    }

    // Stocker un nouveau contact
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:150',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($request->all());

        return response()->json(['message' => 'Contact enregistré avec succès!', 'contact' => $contact]);
    }

    // Afficher un contact par ID
    public function show($id)
    {
        return response()->json(Contact::findOrFail($id));
    }

    // Mettre à jour un contact
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return response()->json(['message' => 'Contact mis à jour avec succès!', 'contact' => $contact]);
    }

    // Supprimer un contact
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return response()->json(['message' => 'Contact supprimé avec succès!']);
    }
}
