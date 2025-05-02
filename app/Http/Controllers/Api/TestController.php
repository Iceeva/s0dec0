<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request)
    {
        // Récupération des données JSON
        $data = $request->json()->all();

        return response()->json([
            'message' => 'Données reçues avec succès !',
            'données' => $data
        ]);
    }
}
