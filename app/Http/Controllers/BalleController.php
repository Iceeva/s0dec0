<?php

namespace App\Http\Controllers;

use App\Models\Balle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

class BalleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:balles|max:50',
            'date_sortie' => 'required|date',
            'poids_brut' => 'required|numeric|min:0',
            'poids_net' => 'required|numeric|min:0',
            'variete' => 'required|string|max:100',
            'usine' => 'required|string|max:100',
            'marquage' => 'nullable|string|max:100',
            'longueur_soie' => 'nullable|string|max:50',
            'type_vente' => 'nullable|string|max:50',
            'est_classe' => 'nullable|boolean',
            'date_classement' => 'nullable|date'
        ]);

        try {
            $balle = Balle::create($validated);

            return redirect()->route('qrcodes.index')
                ->with('success', 'Balle ajoutée avec succès!')
                ->with('showPage', 'nouvelles-balles');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', "Erreur lors de l'ajout de la balle: " . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $balle = Balle::findOrFail($id);

        $validated = $request->validate([
            'reference' => 'required|string|max:50|unique:balles,reference,' . $balle->id,
            'date_sortie' => 'required|date',
            'poids_brut' => 'required|numeric|min:0',
            'poids_net' => 'required|numeric|min:0',
            'variete' => 'required|string|max:100',
            'usine' => 'required|string|max:100',
            'marquage' => 'nullable|string|max:100',
            'longueur_soie' => 'nullable|string|max:50',
            'type_vente' => 'nullable|string|max:50',
            'est_classe' => 'nullable|boolean',
            'date_classement' => 'nullable|date'
        ]);

        $balle->update($validated);

        return redirect()->back()->with('success', 'Balle mise à jour avec succès');

        Balle::create($validated);
        return redirect()->route('qrcodes.index', ['page' => 'nouvelles-balles'])->with('success', 'Balle ajoutée avec succès !');
    }

    public function destroy($id)
    {
        $balle = Balle::findOrFail($id);
        $balle->delete();

        return response()->json(['success' => true]);
    }

    public function getBalle($reference)
    {
        // Décodage de la référence
        $decodedReference = str_replace('---', '/', urldecode($reference));
        
        // Recherche dans la base de données
        $balle = DB::table('balles')
                  ->where('reference', $decodedReference)
                  ->orWhere(DB::raw('REPLACE(reference, "/", "---")'), $reference)
                  ->first();

        if (!$balle) {
            return response()->json(['error' => 'Référence non trouvée'], 404);
        }

        return response()->json([
            'id' => $balle->id,
            'reference' => $balle->reference,
            'date_sortie' => $balle->date_sortie,
            'poids_brut' => $balle->poids_brut,
            'poids_net' => $balle->poids_net,
            'variete' => $balle->variete,
            'usine' => $balle->usine,
            'marquage' => $balle->marquage,
            'longueur_soie' => $balle->longueur_soie,
            'type_vente' => $balle->type_vente,
            'est_classe' => (bool)$balle->est_classe,
            'date_classement' => $balle->date_classement
        ]);
    }
}
