<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Balle;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    public function dashboard(Request $request)
    {
        $users = User::all();
        $balles = Balle::all();
        $qrcodes = QrCode::all();
        $adminCount = User::where('role', 'admin')->count();
        $agentCount = User::where('role', 'agent')->count();
        $buyerCount = User::where('role', 'buyer')->count();
        $ballesCount = $balles->count();
        $currentPage = $request->query('page', 'dashboard');

        return view('admin', compact(
            'users',
            'balles',
            'qrcodes',
            'adminCount',
            'agentCount',
            'buyerCount',
            'ballesCount',
            'currentPage'
        ));
    }

    public function generateQrCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $reference = $request->input('reference');
        $content = $request->input('content', $reference);

        try {
            // Generate QR code as a base64 image
            $qrCode = QrCodeGenerator::format('png')
                ->size(200)
                ->generate($content);
            $qrData = 'data:image/png;base64,' . base64_encode($qrCode);

            return response()->json([
                'success' => true,
                'qr_data' => $qrData,
                'reference' => $reference,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du QR code: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saveQrCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => 'required|string|max:255',
            'qrData' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            QrCode::updateOrCreate(
                ['reference' => $request->input('reference')],
                ['qr_data' => $request->input('qrData')]
            );

            return response()->json([
                'success' => true,
                'message' => 'QR Code enregistré avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,agent,buyer',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => Hash::make($request->input('password')),
            ]);

            return redirect()->route('admin.dashboard', ['page' => 'users'])
                ->with('success', 'Utilisateur ajouté avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'ajout de l\'utilisateur: ' . $e->getMessage());
        }
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->input('id'),
            'role' => 'required|string|in:admin,agent,buyer',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::findOrFail($request->input('id'));
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            return redirect()->route('admin.dashboard', ['page' => 'users'])
                ->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour de l\'utilisateur: ' . $e->getMessage());
        }
    }

    public function addBalle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => 'required|string|max:255|unique:balles',
            'poids_net' => 'required|numeric|min:0',
            'variete' => 'required|string|max:255',
            'qualite' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Balle::create([
                'reference' => $request->input('reference'),
                'poids_net' => $request->input('poids_net'),
                'variete' => $request->input('variete'),
                'qualite' => $request->input('qualite'),
            ]);

            return redirect()->route('admin.dashboard', ['page' => 'balles'])
                ->with('success', 'Balle ajoutée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'ajout de la balle: ' . $e->getMessage());
        }
    }
}