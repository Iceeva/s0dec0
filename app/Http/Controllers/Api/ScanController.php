<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController
{
    public function recordScan(Request $request)
    {
        $scan = Scan::create([
            'qr_code' => $request->qr_code,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'scan' => $scan
        ]);
    }
}