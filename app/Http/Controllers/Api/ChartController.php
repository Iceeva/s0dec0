<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\Scan;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getChartData()
    {
        // Données pour le graphique de génération de QR Codes
        $qrGeneration = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            'data' => QrCode::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count')
                ->toArray()
        ];

        // Données pour le graphique d'activité des scans
        $scanActivity = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            'data' => Scan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count')
                ->toArray()
        ];

        return response()->json([
            'qr_generation' => $qrGeneration,
            'scan_activity' => $scanActivity
        ]);
    }
}