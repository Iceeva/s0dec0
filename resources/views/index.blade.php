@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Contenu principal -->
<div id="main-content">
    <div class="slider mb-12">
        <!-- Images du diaporama -->
        <div class="slide" style="background-image: url('{{ asset('images/cotton.png') }}');"></div>
        <div class="slide active" style="background-image: url('{{ asset('images/ball.jpg') }}');"></div>
        <div class="slide" style="background-image: url('{{ asset('images/R.jpg') }}');"></div>

        <!-- Navigation du diaporama -->
        <div class="slider-nav">
            <div class="slider-nav-item active" data-slide="0"></div>
            <div class="slider-nav-item" data-slide="1"></div>
            <div class="slider-nav-item" data-slide="2"></div>
        </div>
    </div>

    <!-- Section Présentation -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10 card-hover">
        <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-1/3 bg-blue-50 flex items-center justify-center p-8">
                <div class="flex items-center">
                    <a href="/">
                        <img class="h-14 w-auto" src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO">
                    </a>
                </div>
            </div>
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 slide-in">Bienvenue sur SODECO</h1>
                <div class="presentation text-gray-600 space-y-4">
                    <p>SODECO vous permet de suivre chaque balle de coton du champ à l'usine. Notre plateforme offre une transparence totale sur l'origine, la qualité et l'historique de chaque produit.</p>
                    <p>Avec notre système de traçabilité innovant, vous pouvez accéder à des informations détaillées en scannant simplement le QR code présent sur chaque balle de coton.</p>
                    <p>Engagés dans une production durable, nous mettons tout en œuvre pour réduire notre impact environnemental tout en maintenant les plus hauts standards de qualité.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scanner Section -->
    <div id="scanner-container" class="bg-white rounded-xl shadow-md overflow-hidden p-8 mb-10 card-hover">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Scanner le QR Code du Produit</h2>

        <!-- Ajout du champ de recherche par référence -->
        <div class="mb-6">
            <label for="reference-search" class="block text-sm font-medium text-gray-700 mb-2">Ou rechercher par référence :</label>
            <div class="flex gap-2">
                <input type="text" id="reference-search" placeholder="Entrez la référence de la balle" class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button id="search-reference-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-search mr-1"></i> Rechercher
                </button>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/2">
                <button id="startScannerBtn" class="scan-btn bg-green-600 text-white px-6 py-3 rounded-lg font-medium text-lg mb-4">
                    <i class="fas fa-qrcode mr-2"></i> Démarrer le scanner
                </button>
                <div id="scanner-video-container" class="rounded-lg overflow-hidden hidden">
                    <video id="scanner-video" class="w-full" playsinline></video>
                </div>
                <div id="scanner-error" class="text-red-600 mt-2 hidden"></div>
            </div>

            <div class="md:w-1/2">
                <div id="instructions" class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-bold text-green-700 mb-2"><i class="fas fa-info-circle mr-2"></i>Comment scanner</h4>
                    <p class="text-sm text-gray-700">1. Cliquez sur "Démarrer le scanner"<br>
                        2. Autorisez l'accès à la caméra<br>
                        3. Pointez votre appareil vers le QR code<br>
                        4. Les informations du produit s'afficheront</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow-md card-hover">
            <div class="text-green-600 text-3xl mb-4">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Traçabilité</h3>
            <p class="text-gray-600">Suivez l'origine exacte de chaque balle de coton, du champ à l'usine.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md card-hover">
            <div class="text-green-600 text-3xl mb-4">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Qualité</h3>
            <p class="text-gray-600">Accédez aux données qualité détaillées pour chaque production.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md card-hover">
            <div class="text-green-600 text-3xl mb-4">
                <i class="fas fa-leaf"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Durabilité</h3>
            <p class="text-gray-600">Informations sur les pratiques durables employées pour chaque lot.</p>
        </div>
    </div>
</div>

<!-- Conteneur pour les informations du QR code -->
<div id="qr-info-container" class="qr-info-container hidden">
    <div class="qr-info-card">
        <div class="qr-info-header">
            <h2 class="text-2xl font-bold">Informations de la Balle de Coton</h2>
            <p class="text-sm opacity-80">Détails extraits du QR code</p>
        </div>
        <div class="qr-info-body">
            <div id="qr-info-content" class="space-y-4">
                <!-- Les informations seront insérées dynamiquement ici -->
            </div>
            <div class="text-center mt-6">
                <button class="back-btn" onclick="goBack()">Retour à l'accueil</button>
            </div>
        </div>
    </div>
</div>

<!-- index -->
<script src="https://unpkg.com/@zxing/library@0.20.0"></script>
<script src="{{ asset('js/index.min.js') }}"></script>


@endsection
