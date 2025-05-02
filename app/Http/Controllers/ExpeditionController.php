<?php

namespace App\Http\Controllers;

use App\Models\Expedition;
use App\Models\Balle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpeditionController extends Controller
{
    public function index()
    {
        $expeditions = Expedition::with('balles')->latest()->get();
        return view('expedition', compact('expeditions'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'immatriculation' => 'required|string|max:20',
            'chauffeur' => 'required|string|max:100',
            'balle_ids' => 'required|array',
            'balle_ids.*' => 'exists:balles,id'
        ]);

        DB::beginTransaction();

        try {
            // Calcul des totaux
            $balles = Balle::whereIn('id', $validated['balle_ids'])->get();
            
            $totalBrut = $balles->sum('poids_brut');
            $totalNet = $balles->sum('poids_net');
            
            // Création de l'expédition
            $expedition = Expedition::create([
                'immatriculation' => $validated['immatriculation'],
                'chauffeur' => $validated['chauffeur'],
                'poids_total_brut' => $totalBrut,
                'poids_total_net' => $totalNet,
                'statut' => 'en_attente'
            ]);
            
            // Associer les balles
            $expedition->balles()->attach($validated['balle_ids']);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Expédition créée avec succès');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'expédition: '.$e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,en_cours,livree,annulee'
        ]);
        
        $expedition = Expedition::findOrFail($id);
        $expedition->update(['statut' => $validated['statut']]);
        
        return redirect()->back()->with('success', 'Statut mis à jour');
    }

    public function show($id)
    {
        $expedition = Expedition::with('balles')->findOrFail($id);
        return response()->json($expedition);
    }

    public function destroy($id)
    {
        $expedition = Expedition::findOrFail($id);
        $expedition->delete();
        
        return response()->json(['success' => true]);
    }
}