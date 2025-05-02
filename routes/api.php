<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalleController;
use Illuminate\Support\Facades\DB;



Route::get('/balle/{reference}', [BalleController::class, 'getBalle'])->where('reference', '.*');

Route::get('/balle/{reference}', function($reference) {
    $cleanReference = str_replace('---', '/', urldecode($reference));
    
    $balle = DB::table('balles')
              ->where('reference', $cleanReference)
              ->orWhere(DB::raw('REPLACE(reference, "/", "---")'), $reference)
              ->first();

    return $balle 
        ? response()->json($balle)
        : response()->json(['error' => 'Référence non trouvée'], 404);
});