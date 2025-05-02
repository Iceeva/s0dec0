<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ExpeditionController;
use App\Http\Controllers\BalleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

require __DIR__.'/auth.php';

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');


//apli
Route::post('/json-reception', [TestController::class, 'store']);

// Admin routes

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});

// Authentication routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::prefix('qr-codes')->group(function () {
    Route::get('/', [QrCodeController::class, 'index'])->name('qr-codes.index');
    Route::post('/generate', [QrCodeController::class, 'generate'])->name('qr-codes.generate');
    Route::post('/store', [QrCodeController::class, 'store'])->name('qr-codes.store');
});

// qrcodes
Route::get('/qrcodes', [QRCodeController::class, 'index'])->name('qrcode_manager');
Route::post('/generate/{id}', [QRCodeController::class, 'generateQRCode']);
Route::post('/bulk_generate', [QRCodeController::class, 'bulkGenerate'])->name('bulk_generate');
Route::post('/save/{id}', [QRCodeController::class, 'saveQRCode'])->name('save_qrcode');
Route::post('/save-qrcode/{id}', [QRCodeController::class, 'saveQRCode'])->name('qrcodes.save');

// Expéditions
Route::get('/expedition', [ExpeditionController::class, 'index'])->name('expedition.index');
Route::post('/expedition', [ExpeditionController::class, 'create'])->name('expedition.create');
Route::put('/expedition/{id}/status', [ExpeditionController::class, 'updateStatus'])->name('expedition.update-status');
Route::get('/expedition/{id}', [ExpeditionController::class, 'show'])->name('expedition.show');
Route::delete('/expedition/{id}', [ExpeditionController::class, 'destroy'])->name('expedition.delete');

// Balles
Route::post('/balles', [BalleController::class, 'store'])->name('balles.store');
Route::put('/balles/{id}', [BalleController::class, 'update'])->name('balles.update');
Route::delete('/balles/{id}', [BalleController::class, 'destroy'])->name('balles.delete');

//Route::get('/api/balle/{reference}', [BalleController::class, 'getBalle']);

Route::post('/balles', [BalleController::class, 'store'])->name('balles.store');
Route::get('/balle/{reference}', [BalleController::class, 'getBalle']);
Route::get('/balle/{reference}', [BalleController::class, 'getBalleByReference']);


Route::middleware(['auth', 'verified'])->group(function () {
    // Routes protégées nécessitant une vérification d'email
});

// // routes/web.php

// // Routes publiques
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/qr-info/{id}', [QRCodeController::class, 'showInfo'])->name('qr.info');

// // Authentification
// require __DIR__.'/auth.php';

// // Routes protégées
// Route::middleware(['auth'])->group(function () {
//     // Routes pour acheteurs
//     Route::middleware(['role:buyer'])->group(function () {
//         Route::get('/buyer/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
//     });

//     // Routes pour agents
//     Route::middleware(['role:agent'])->group(function () {
//         Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
//         Route::get('/generate-qr', [QRCodeController::class, 'create'])->name('generate.qr');
//     });

//     // Routes pour admins
//     Route::middleware(['role:admin'])->prefix('admin')->group(function () {
//         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//         // Autres routes admin...
//     });
// });





// // Routes pour acheteurs
// Route::middleware(['auth', 'verified', 'role:buyer'])->prefix('buyer')->group(function () {
//     Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
//     Route::get('/scan-history', [BuyerController::class, 'scanHistory'])->name('buyer.scan-history');
//     Route::post('/scan/{qrCode}', [BuyerController::class, 'storeScan'])->name('buyer.store-scan');
// });

// // Routes pour agents
// Route::middleware(['auth', 'verified', 'role:agent'])->prefix('agent')->group(function () {
//     Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
//     Route::get('/generate-qr', [AgentController::class, 'createQRCode'])->name('agent.generate-qr');
//     Route::post('/generate-qr', [AgentController::class, 'generateQRCode'])->name('agent.store-qr');
//     Route::get('/qr-codes', [AgentController::class, 'qrCodeList'])->name('agent.qr-code-list');
//     Route::get('/export-qr-codes', [AgentController::class, 'exportQRCodes'])->name('agent.export-qr-codes');
// });

// // Route publique pour les informations QR Code
// Route::get('/qr-info/{id}', [BuyerController::class, 'showQRInfo'])->name('qr.info');