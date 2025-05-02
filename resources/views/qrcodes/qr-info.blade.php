@extends('layouts.app')

@section('title', 'Informations Balle de Coton')

{{-- @section('styles')
<style>
    /* Style principal avec thème SODECO */
    .qr-info-container {
        background: linear-gradient(135deg, rgba(248, 249, 250, 0.9) 0%, rgba(233, 236, 239, 0.9) 100%), 
                    url('{{ asset('images/cotton-field.jpg') }}');
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        padding: 2rem 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: relative;
        overflow: hidden;
    }
    
    /* Vague décorative */
    .wave-decoration {
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(41, 128, 185, 0.2) 100%);
        border-bottom-left-radius: 50%;
        z-index: 0;
    }
    
    .qr-info-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
        border: none;
        position: relative;
        z-index: 1;
        backdrop-filter: blur(5px);
        background-color: rgba(255, 255, 255, 0.9);
    }
    
    .qr-info-header {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .qr-info-header::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .qr-info-header h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    
    .qr-info-header p {
        opacity: 0.9;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }
    
    .qr-info-body {
        padding: 2rem;
    }
    
    .info-section {
        margin-bottom: 2rem;
    }
    
    .info-section h3 {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        border-left: 4px solid #3498db;
    }
    
    .info-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .info-item h4 {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .info-item p {
        color: #495057;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .cotton-icon {
        color: #3498db;
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-valid {
        background: #d1fae5;
        color: #065f46;
    }
    
    .btn-sodeco {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-sodeco:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(41, 98, 255, 0.3);
        color: white;
    }
    
    .qr-code-display {
        text-align: center;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin-top: 2rem;
        border: 1px dashed #3498db;
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }
</style>
@endsection --}}

@section('content')
<div class="qr-info-container animate-fade-in">
    <div class="wave-decoration"></div>
    <div class="container">
        <div class="qr-info-card">
            <!-- En-tête avec logo SODECO -->
            <div class="qr-info-header">
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('images/SODECO-980x316.png') }}" alt="SODECO" style="height: 90px;">
                </div>
                <h2>FICHE TECHNIQUE DE LA BALLE DE COTON</h2><br>
                <p>Informations complètes sur la balle scannée</p>
            </div><br>
            
            <div class="qr-info-body">
                <!-- Section 1: Informations de base -->
                <div class="info-section">
                    <h3><i class="fas fa-info-circle cotton-icon"></i> Informations de base</h3><br>
                    <div class="info-grid">
                        <div class="info-item">
                            <h4>Référence : {{ $info['Référence'] ?? 'Non disponible' }}</h4>   
                        </div>
                        <div class="info-item">
                            <h4>ID : {{ $info['ID'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Date de production : {{ $info['Date sortie'] ?? 'Non disponible' }}</h4>
                        </div>
                    </div>
                </div><br>
                
                <!-- Section 2: Caractéristiques techniques -->
                <div class="info-section">
                    <h3><i class="fas fa-clipboard-list cotton-icon"></i> Caractéristiques techniques</h3><br>
                    <div class="info-grid">
                        <div class="info-item">
                            <h4>Variété : {{ $info['Variété'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Poids brut : {{ $info['Poids brut'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Poids net : {{ $info['Poids net'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Longueur de soie : {{ $info['Longueur Soie'] ?? 'Non disponible' }}</h4>
                        </div>
                    </div>
                </div><br>
                
                <!-- Section 3: Origine et traçabilité -->
                <div class="info-section">
                    <h3><i class="fas fa-map-marked-alt cotton-icon"></i> Origine et traçabilité</h3><br>
                    <div class="info-grid">
                        <div class="info-item">
                            <h4>Usine de production : {{ $info['Usine'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Type de vente : {{ $info['Type Vente'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Date campagne : {{ $info['date de la compagne'] ?? 'Non disponible' }}</h4>
                        </div>
                        <div class="info-item">
                            <h4>Marquage : {{ $info['Marquage'] ?? 'Non disponible' }}</h4>
                        </div>
                    </div>
                </div><br>
                
                <!-- QR Code original - Généré dynamiquement -->
                <div class="qr-code-display">
                    <h4><i class="fas fa-qrcode cotton-icon"></i> Code de traçabilité</h4>
                    @if(isset($qrData))
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrData) }}" 
                             alt="QR Code" 
                             class="img-fluid my-3">
                    @else
                        <div class="alert alert-warning">Aucun QR code disponible</div>
                    @endif
                    <p class="text-muted">Scannez ce code pour retrouver ces informations</p>
                </div>
                
                <!-- Bouton de retour -->
                <div class="text-center mt-4">
                    <a href="/" class="btn btn-sodeco">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- http://127.0.0.1:8000/qr-info?data=ID:%2012345%0ARéférence:%20K/36/29282%0ADate%20sortie:%2015/06/2023%0APoids%20brut:%20250%20kg%0APoids%20net:%20230%20kg%0AVariété:%20Cotton%20Premium%0AMarquage:%20SODECO2023%0ALongueur%20Soie:%2028mm%0AType%20Vente:%20KABA%0Adate%20de%20la%20compagne:%2010/01/2025%0AUsine:%20Usine%20Principale -->