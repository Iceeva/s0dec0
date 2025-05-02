<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balle;
use App\Models\QRCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRCodeFacade; // Ensure this library is installed
use Illuminate\Support\Facades\Log;

class QRCodeController extends Controller
{
    public function index()
    {
        $balles = Balle::with('qrCode')->get();
        $qrCodeCount = QRCode::count();
        $balleCount = Balle::count();

        // Préparer les QR codes pour chaque balle
        $balles->each(function ($balle) {
            if (!$balle->qrCode) {
                $qrCodeData = $this->generateBalleQRData($balle);
                $balle->qrCodeImage = QRCodeFacade::size(100)->generate($qrCodeData);
            } else {
                $balle->qrCodeImage = $balle->qrCode->qr_data;
            }
        });

        return view('qrcode_manager', [
            'balles' => $balles,
            'qrCodeCount' => $qrCodeCount,
            'balleCount' => $balleCount,
            'ballesCount' => $balleCount
        ]);
    }

    private function generateBalleQRData($balle)
    {
        return "ID: {$balle->id}\n" .
            "Référence: {$balle->reference}\n" .
            "Date sortie: {$balle->date_sortie}\n" .
            "Poids brut: {$balle->poids_brut} kg\n" .
            "Poids net: {$balle->poids_net} kg\n" .
            "Variété: {$balle->variete}\n" .
            "Marquage: {$balle->marquage}\n" .
            "Longueur Soie: {$balle->longueur_soie}\n" .
            "Type Vente: {$balle->type_vente}\n" .
            "Date Classement: {$balle->date_classement}\n" .
            "Usine: {$balle->usine}";
    }

    public function generateQRCode($id)
    {
        $balle = Balle::findOrFail($id);
        $qrCodeData = $this->generateBalleQRData($balle);

        // Génère le QR code en PNG
        $qrImage = QRCodeFacade::format('png')
            ->size(400)
            ->errorCorrection('H')
            ->generate($qrCodeData);

        // Convertit en base64 avec le préfixe data URI
        $base64Image = 'data:image/png;base64,' . base64_encode($qrImage);

        // Sauvegarde dans la base de données
        $qrCode = QRCode::updateOrCreate(
            ['id_balles' => $balle->id],
            ['qr_data' => $base64Image]
        );

        return response()->json([
            'success' => true,
            'qr_data' => $base64Image,
            'balle' => $balle
        ]);
    }

    public function saveQRCode($id)
    {
        $balle = Balle::findOrFail($id);

        // Valider que le QR code existe
        if (!$balle->qrCodeImage) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun QR code à enregistrer'
            ], 400);
        }

        // Sauvegarder dans la base de données
        $qrCode = QRCode::updateOrCreate(
            ['id_balles' => $balle->id],
            ['qr_data' => $balle->qrCodeImage] // Utilisez directement qrCodeImage qui contient le base64
        );

        return response()->json([
            'success' => true,
            'message' => 'QR Code enregistré avec succès dans la base de données'
        ]);
    }

    public function printQRCode($id)
    {
        $qrCode = QRCode::where('id_balles', $id)->firstOrFail();
        $balle = Balle::findOrFail($id);

        return view('print_qrcode', [
            'qrCode' => $qrCode->qr_data,
            'reference' => $balle->reference
        ]);
    }

    public function bulkGenerate(Request $request)
    {
        $ids = $request->input('ids');

        foreach ($ids as $id) {
            $this->generateQRCode($id);
        }

        return response()->json(['success' => true]);
    }

    public function printMultiple(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        $perPage = $request->input('per_page', 1);

        $qrCodes = QrCode::whereIn('id_balles', $ids)
            ->with('balle')
            ->get()
            ->map(function ($qrCode) {
                return [
                    'qr_code' => base64_decode($qrCode->qr_data),
                    'reference' => $qrCode->balle->reference,
                    'date_sortie' => $qrCode->balle->date_sortie
                ];
            });

        return view('qr-codes.print', [
            'qrCodes' => $qrCodes,
            'perPage' => $perPage
        ]);
    }
}
