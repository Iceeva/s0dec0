<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SODECO</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Captur.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
    <!-- index -->
    <style>
        /* Animations et effets */
        .icon:hover {
            transform: scale(1.2);
            transition: transform 0.3s ease-in-out;
            color: #3b82f6;
        }

        .presentation {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Diaporama */
        .slider {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .slide.active {
            opacity: 1;
        }

        /* Boutons navigation diaporama */
        .slider-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            z-index: 10;
        }

        .slider-nav-item {
            width: 12px;
            height: 12px;
            margin: 0 5px;
            border-radius: 50%;
            background-color: rgba(224, 222, 222, 0.5);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .slider-nav-item.active {
            background-color: white;
        }

        /* Effet de carte au survol */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        /* Style personnalisé pour les résultats */
        #results {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .hidden {
            display: none;
        }

        /* Bouton scanner */
        .scan-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }

        .scan-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        /* Ajoutez ceci dans la section style */
        .search-container {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .search-input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .search-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }

        .search-alternative {
            text-align: center;
            margin-top: 1rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .search-alternative a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .search-alternative a:hover {
            text-decoration: underline;
        }

    </style>
    <!-- admin -->
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar-collapsed {
            width: 70px;
        }

        .sidebar-expanded {
            width: 250px;
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }

        .page-content {
            display: none;
        }

        .page-content.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

    </style>
    <!-- gener_qr_code -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar-brand img {
            height: 40px;
            transition: all 0.3s ease;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-outline-secondary {
            color: var(--dark-color);
            border-color: var(--dark-color);
        }

        .btn-outline-secondary:hover {
            background-color: var(--dark-color);
            color: white;
        }

        .qr-preview {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            margin: 10px;
            transition: all 0.3s ease;
        }

        .qr-preview:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .print-area {
            background-color: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
        }

        .badge {
            padding: 5px 10px;
            font-weight: 500;
        }

        .sidebar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 20px;
            height: 100%;
        }

        .sidebar-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            display: block;
            padding: 8px 15px;
            color: var(--dark-color);
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--secondary-color);
        }

        .sidebar-menu i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        }

        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stats-card .count {
            font-size: 2rem;
            font-weight: 700;
        }

        .stats-card .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-area {
                border: none;
                background-color: white;
                padding: 0;
            }

            .qr-preview {
                page-break-inside: avoid;
                box-shadow: none;
                border: 1px solid #eee;
            }
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
        }

        .select-all-checkbox {
            margin-right: 10px;
        }

        .action-buttons {
            margin-bottom: 20px;
        }

        .page-content {
            display: none;
        }

        .page-content.active {
            display: block;
        }

    </style>
    <!-- gener_qr_code_info -->
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
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <a href="/">
                        <img class="h-8 w-auto" src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO" style="height: 80px; width: auto; max-width: 500px;">
                    </a>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600' }} font-medium px-3 py-2 rounded-md hover:bg-blue-50 text-sm font-medium">Accueil</a>
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-blue-600' : 'text-gray-600' }} px-3 py-2 rounded-md hover:bg-blue-50 text-sm font-medium">Se connecter</a>
                    <a href="{{ route('qrcode_manager') }}" class="{{ request()->routeIs('qrcode_manager') ? 'text-blue-600' : 'text-gray-600' }} font-medium px-3 py-2 rounded-md hover:bg-blue-50 text-sm font-medium">Générer QR Code</a>
                    <a href="{{ route('expedition.index') }}" class="{{ request()->routeIs('expedition.index') ? 'text-blue-600' : 'text-gray-600' }} px-3 py-2 rounded-md hover:bg-blue-50 text-sm font-medium">Balles expédiées</a>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-600' }} px-3 py-2 rounded-md hover:bg-blue-50 text-sm font-medium">Admin</a>
                </div>
                <button class="md:hidden text-gray-600">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">SODECO</h3>
                    <p class="text-gray-400">La traçabilité du coton, de la graine au produit fini.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Accueil</a></li>
                        <li><a href="login" class="text-gray-400 hover:text-white">Connexion</a></li>
                        <li><a href="gener_qr_code" class="text-gray-400 hover:text-white">Générer QR Code</a></li>
                        {{-- <li><a href="admin" class="text-gray-400 hover:text-white">Espace Admin</a></li> --}}
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li><i class="fas fa-envelope mr-2"></i> sodeco@sodeco.bj</li>
                        <li><i class="fas fa-phone mr-2"></i> (229) 01 21 30 95 39</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Immeuble FAGACE, Bld de la CENSAD, 01 BP 8059,
                            Cotonou – BENIN</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Réseaux sociaux</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>© 2025 SODECO. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <!-- index -->
    <script src="https://unpkg.com/@zxing/library@0.20.0"></script>
    <script src="{{ asset('js/index.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Scanner avec ZXing
            const startScannerBtn = document.getElementById('startScannerBtn');
            const videoContainer = document.getElementById('scanner-video-container');
            const videoElement = document.getElementById('scanner-video');
            const instructions = document.getElementById('instructions');
            const scannerError = document.getElementById('scanner-error');
            const mainContent = document.getElementById('main-content');
            const qrInfoContainer = document.getElementById('qr-info-container');

            let codeReader = null;
            let isScanning = false;
            let stream = null;

            startScannerBtn.addEventListener('click', async () => {
                if (isScanning) {
                    stopScanner();
                    return;
                }

                try {
                    scannerError.classList.add('hidden');

                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        throw new Error("Votre navigateur ne supporte pas l'accès à la caméra");
                    }

                    codeReader = new ZXing.BrowserMultiFormatReader();
                    console.log("ZXing initialisé, démarrage du scanner...");

                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'environment'
                            , width: {
                                ideal: 1280
                            }
                            , height: {
                                ideal: 720
                            }
                        }
                        , audio: false
                    });

                    videoElement.srcObject = stream;
                    videoContainer.classList.remove('hidden');
                    instructions.classList.add('hidden');
                    startScannerBtn.innerHTML = '<i class="fas fa-stop mr-2"></i> Arrêter le scanner';
                    isScanning = true;

                    codeReader.decodeFromVideoElement(videoElement, (result, err) => {
                        if (result) {
                            console.log('QR Code détecté:', result.text);
                            handleScanResult(result.text);
                        }
                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            console.error('Erreur de scan:', err);
                        }
                    });

                } catch (error) {
                    console.error('Erreur du scanner:', error);
                    let errorMessage = "Erreur lors du démarrage du scanner";
                    if (error.name === 'NotAllowedError') {
                        errorMessage = "Vous devez autoriser l'accès à la caméra pour utiliser le scanner";
                    } else if (error.name === 'NotFoundError' || error.name === 'OverconstrainedError') {
                        errorMessage = "Aucune caméra compatible n'a été trouvée";
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    showError(errorMessage);
                    stopScanner();
                }
            });

            function stopScanner() {
                if (codeReader) {
                    codeReader.reset();
                    codeReader = null;
                }
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
                if (videoElement.srcObject) {
                    videoElement.srcObject = null;
                }

                videoContainer.classList.add('hidden');
                instructions.classList.remove('hidden');
                startScannerBtn.innerHTML = '<i class="fas fa-qrcode mr-2"></i> Démarrer le scanner';
                isScanning = false;
            }

            function showError(message) {
                scannerError.textContent = message;
                scannerError.classList.remove('hidden');
            }

            window.addEventListener('beforeunload', stopScanner);

            // Vérifier si des données QR sont passées via l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const qrData = urlParams.get('data');
            if (qrData) {
                displayQRInfo(decodeURIComponent(qrData));
            }
        });

        function goBack() {
            const qrInfoContainer = document.getElementById('qr-info-container');
            qrInfoContainer.classList.add('hidden'); // Masquer la section des informations

            // Réafficher les autres éléments de la page
            document.getElementById('main-content').style.display = 'block';
            document.getElementById('scanner-container').style.display = 'block';

            // Réinitialiser le champ de recherche
            document.getElementById('reference-search').value = '';

            // Réinitialiser l'URL (sans le paramètre QR code)
            window.history.pushState({}, '', '/');
        }

        function displayQRInfo(data) {
            const qrInfoContent = document.getElementById('qr-info-content');

            qrInfoContent.innerHTML = `
           <div class="info-item">
            <h4>Référence</h4>
            <p>${data.reference || 'N/A'}</p>
            </div>
           <div class="info-item">
            <h4>Date de sortie</h4>
            <p>${data.date_sortie || 'N/A'}</p>
           </div>
           <div class="info-item">
            <h4>Poids brut</h4>
            <p>${data.poids_brut || 'N/A'}</p>
            </div>
           <div class="info-item">
            <h4>Poids net</h4>
            <p>${data.poids_net || 'N/A'}</p>
           </div>
           <div class="info-item">
            <h4>Variété</h4>
            <p>${data.variete || 'N/A'}</p>
            </div>
            <div class="info-item">
            <h4>Usine</h4>
            <p>${data.usine || 'N/A'}</p>
            </div>
           ${data.marquage ? `<div class="info-item"><h4>Marquage</h4><p>${data.marquage}</p></div>` : ''}
            ${data.longueur_soie ? `<div class="info-item"><h4>Longueur soie</h4><p>${data.longueur_soie}</p></div>` : ''}
           `;
        }

        function handleScanResult(decodedText) {
            stopScanner(); // Arrête le scanner
            displayQRInfo(decodedText); // Affiche les informations du QR Code

            // Masquer les autres éléments de la page
            document.getElementById('main-content').style.display = 'none';
            document.getElementById('scanner-container').style.display = 'none';

            // Afficher la section avec les informations du QR Code
            const qrInfoContainer = document.getElementById('qr-info-container');
            qrInfoContainer.classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.slide');
            const navItems = document.querySelectorAll('.slider-nav-item');
            let currentSlide = 0;
            const slideInterval = 5000; // Temps en millisecondes avant de passer à la slide suivante

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                    navItems[i].classList.toggle('active', i === index);
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length; // Boucle vers la première slide après la dernière
                showSlide(currentSlide);
            }

            // Définir l'intervalle pour changer de slide automatiquement
            setInterval(nextSlide, slideInterval);

            // Ajouter un événement de clic sur les éléments de navigation
            navItems.forEach((navItem, index) => {
                navItem.addEventListener('click', () => {
                    currentSlide = index;
                    showSlide(currentSlide);
                });
            });

            // Afficher la première slide au chargement
            showSlide(currentSlide);
        });

        // Recherche par référence
        document.getElementById('search-reference-btn').addEventListener('click', async function() {
            const referenceInput = document.getElementById('reference-search');
            const reference = referenceInput.value.trim();
            const errorElement = document.getElementById('scanner-error');

            errorElement.classList.add('hidden');

            if (!reference) {
                errorElement.textContent = 'Veuillez entrer une référence';
                errorElement.classList.remove('hidden');
                return;
            }

            try {
                // Afficher un indicateur de chargement
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Recherche...';
                this.disabled = true;

                // Appel à votre fichier api_balle.php
                const response = await fetch(`/api_balle.php?reference=${encodeURIComponent(reference)}`);

                if (!response.ok) {
                    throw new Error('Référence non trouvée');
                }

                const data = await response.json();

                // Afficher directement les données reçues
                displayQRInfo(data);

                // Masquer le contenu principal et afficher les résultats
                document.getElementById('main-content').style.display = 'none';
                document.getElementById('scanner-container').style.display = 'none';
                document.getElementById('qr-info-container').classList.remove('hidden');

            } catch (error) {
                console.error('Erreur de recherche:', error);
                errorElement.textContent = error.message.includes('Référence non trouvée') ?
                    'Aucune balle trouvée. Vérifiez que la référence est exacte.' :
                    `Erreur: ${error.message}`;
                errorElement.classList.remove('hidden');
            } finally {
                // Réinitialiser le bouton
                this.innerHTML = '<i class="fas fa-search mr-2"></i> Rechercher';
                this.disabled = false;
            }
        });

        // Permettre aussi la recherche avec la touche Entrée
        document.getElementById('reference-search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('search-reference-btn').click();
            }
        });

    </script>
    <!-- gener_qr_code -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>
</html>
