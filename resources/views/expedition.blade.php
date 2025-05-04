@extends('layouts.app')

@section('title', 'Gestion des Expéditions')

@section('content')

<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-title">
                        <i class="fas fa-truck-loading me-2"></i>Gestion des Expéditions
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expéditions</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#helpModal">
                        <i class="fas fa-question-circle me-1"></i> Aide
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle text-primary me-2"></i>Nouvelle Expédition
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form id="expedition-form">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="oc-number" readonly>
                                        <label for="oc-number">N° Ordre de Chargement</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ic-number" readonly>
                                        <label for="ic-number">N° Identification Colis</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="expedition-date" readonly>
                                        <label for="expedition-date">Date/Heure</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="type-vente" required>
                                            <option value="" selected disabled>Sélectionner...</option>
                                            <option value="KABA">KABA</option>
                                            <option value="BELA">BELA</option>
                                            <option value="ZANA">ZANA</option>
                                            <option value="ZANA/T">ZANA/T</option>
                                        </select>
                                        <label for="type-vente">Type de vente <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="longueur-soie" required>
                                        <label for="longueur-soie">Longueur de soie <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="usine" required>
                                        <label for="usine">Usine de provenance <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="immatriculation" placeholder="AA-123-BB" required>
                                        <label for="immatriculation">Immatriculation véhicule <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="chauffeur" placeholder="Nom et Prénom" required>
                                        <label for="chauffeur">Chauffeur <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="scan-section mb-4 p-4 bg-light rounded-3 border">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">
                                        <i class="fas fa-qrcode me-2"></i>Scan des Balles
                                    </h6>
                                    <button type="button" id="start-scan" class="btn btn-success btn-sm">
                                        <i class="fas fa-play me-1"></i> Démarrer
                                    </button>
                                </div>

                                <div id="video-container" class="text-center" style="display: none;">
                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-info-circle me-2"></i> Scannez le QR code sur la balle. Placez-le devant la caméra.
                                    </div>
                                    <div class="position-relative d-inline-block">
                                        <video id="video" playsinline class="rounded border" style="max-width: 100%;"></video>
                                        <div id="scan-indicator" class="scan-indicator"></div>
                                    </div>
                                    <div class="mt-3">
                                        <button id="stop-scan" class="btn btn-danger btn-sm">
                                            <i class="fas fa-stop me-1"></i> Arrêter
                                        </button>
                                    </div>
                                    <div id="scan-result" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="scanned-bales-section mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">
                                        <i class="fas fa-boxes me-2"></i>Balles scannées
                                        <span id="bales-count" class="badge bg-primary ms-2">0</span>
                                    </h6>
                                    <div class="d-flex">
                                        <span class="me-3">Total brut: <strong id="total-brut">0.00 kg</strong></span>
                                        <span>Total net: <strong id="total-net">0.00 kg</strong></span>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="10%">ID</th>
                                                <th width="15%">Référence</th>
                                                <th width="15%">Date sortie</th>
                                                <th width="10%">Poids brut</th>
                                                <th width="10%">Poids net</th>
                                                <th width="15%">Variété</th>
                                                <th width="10%">Usine</th>
                                                <th width="15%" class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="scanned-bales-body">
                                            <!-- Les balles scannées apparaîtront ici -->
                                            <tr id="no-bales-row">
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="fas fa-box-open fa-2x mb-2"></i>
                                                    <p class="mb-0">Aucune balle scannée</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-actions d-flex justify-content-between border-top pt-3">
                                <button type="button" id="cancel-expedition" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Annuler
                                </button>
                                <button type="submit" id="valider-expedition" class="btn btn-primary">
                                    <i class="fas fa-check me-1"></i> Valider l'expédition
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i>Historique récent
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="list-group list-group-flush" id="recent-expeditions">
                            <!-- Les expéditions récentes apparaîtront ici -->
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-shipping-fast fa-2x mb-2"></i>
                                <p class="mb-0">Aucune expédition récente</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar text-primary me-2"></i>Statistiques
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="stats-grid">
                            <div class="stat-item bg-primary-light">
                                <div class="stat-value" id="stats-today">0</div>
                                <div class="stat-label">Aujourd'hui</div>
                            </div>
                            <div class="stat-item bg-success-light">
                                <div class="stat-value" id="stats-week">0</div>
                                <div class="stat-label">Cette semaine</div>
                            </div>
                            <div class="stat-item bg-warning-light">
                                <div class="stat-value" id="stats-month">0</div>
                                <div class="stat-label">Ce mois</div>
                            </div>
                        </div>
                        <canvas id="expeditions-chart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailsModalLabel">
                    <i class="fas fa-file-invoice me-2"></i>Détails de l'Expédition
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-details-content">
                <!-- Contenu dynamique -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Fermer
                </button>
                <button type="button" class="btn btn-primary" onclick="printExpeditionDetails()">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aide -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="helpModalLabel">
                    <i class="fas fa-question-circle me-2"></i>Aide - Gestion des Expéditions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3">Comment créer une nouvelle expédition :</h6>
                <ol class="mb-4">
                    <li>Remplissez tous les champs obligatoires (marqués d'un *)</li>
                    <li>Cliquez sur "Démarrer le scan" pour activer la caméra</li>
                    <li>Scannez les QR codes sur chaque balle à expédier</li>
                    <li>Vérifiez la liste des balles scannées</li>
                    <li>Cliquez sur "Valider l'expédition" pour enregistrer</li>
                </ol>
                
                <h6 class="mb-3">Fonctionnalités :</h6>
                <ul>
                    <li>Génération automatique des numéros O.C et I.C</li>
                    <li>Scan des QR codes avec la caméra</li>
                    <li>Calcul automatique des totaux (poids, nombre de balles)</li>
                    <li>Historique des expéditions avec filtres</li>
                    <li>Statistiques et rapports</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i> Compris
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<style>
    .scan-section {
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
    }
    
    .scan-indicator {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 3px solid rgba(25, 135, 84, 0.5);
        border-radius: 0.25rem;
        pointer-events: none;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { border-color: rgba(25, 135, 84, 0.5); }
        50% { border-color: rgba(25, 135, 84, 0.9); }
        100% { border-color: rgba(25, 135, 84, 0.5); }
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-item {
        padding: 1rem;
        border-radius: 0.5rem;
        text-align: center;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .expedition-card {
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }
    
    .expedition-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }
    
    .expedition-card.synchronized {
        border-left-color: #0d6efd;
    }
    
    .expedition-card.received {
        border-left-color: #198754;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    
    .status-synchronized {
        background-color: #e7f1ff;
        color: #0d6efd;
    }
    
    .status-received {
        background-color: #e6f7ee;
        color: #198754;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let scannedBales = [];
        let expeditions = [];
        let currentOCNumber = 1;
        let videoStream = null;
        let scanInterval = null;
        let expeditionsChart = null;

        // Éléments DOM
        const expeditionForm = document.getElementById('expedition-form');
        const startScanBtn = document.getElementById('start-scan');
        const stopScanBtn = document.getElementById('stop-scan');
        const videoContainer = document.getElementById('video-container');
        const video = document.getElementById('video');
        const scanResult = document.getElementById('scan-result');
        const scannedBalesBody = document.getElementById('scanned-bales-body');
        const noBalesRow = document.getElementById('no-bales-row');
        const recentExpeditionsList = document.getElementById('recent-expeditions');
        const balesCount = document.getElementById('bales-count');
        const totalBrutElement = document.getElementById('total-brut');
        const totalNetElement = document.getElementById('total-net');
        const statsToday = document.getElementById('stats-today');
        const statsWeek = document.getElementById('stats-week');
        const statsMonth = document.getElementById('stats-month');
        const ocNumberInput = document.getElementById('oc-number');
        const icNumberInput = document.getElementById('ic-number');
        const expeditionDateInput = document.getElementById('expedition-date');
        const detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));

        // Initialisation
        initApp();

        // Fonctions d'initialisation
        function initApp() {
            loadExpeditions();
            generateExpeditionNumbers();
            updateCurrentDateTime();
            updateStats();
            initChart();
            
            // Mettre à jour la date/heure toutes les secondes
            setInterval(updateCurrentDateTime, 1000);
            
            // Écouteurs d'événements
            expeditionForm.addEventListener('submit', validerExpedition);
            startScanBtn.addEventListener('click', startScanning);
            stopScanBtn.addEventListener('click', stopScanning);
            document.getElementById('cancel-expedition').addEventListener('click', resetExpeditionForm);
        }

        function generateExpeditionNumbers() {
            // Générer N° O.C (format: OC-YYYYMMDD-XXX)
            const now = new Date();
            const dateStr = now.toISOString().split('T')[0].replace(/-/g, '');
            ocNumberInput.value = `OC-${dateStr}-${currentOCNumber.toString().padStart(3, '0')}`;

            // Générer N° I.C (format: IC-AAA-999)
            const letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
            let icNumber = 'IC-';

            for (let i = 0; i < 3; i++) {
                icNumber += letters.charAt(Math.floor(Math.random() * letters.length));
            }

            icNumber += '-';

            for (let i = 0; i < 3; i++) {
                icNumber += Math.floor(Math.random() * 10);
            }

            icNumberInput.value = icNumber;
        }

        function updateCurrentDateTime() {
            const now = new Date();
            expeditionDateInput.value = now.toLocaleString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        function startScanning() {
            // Vérifier que tous les champs obligatoires sont remplis
            if (!validateRequiredFields()) {
                return;
            }

            // Afficher le flux vidéo
            videoContainer.style.display = 'block';
            startScanBtn.style.display = 'none';

            // Accéder à la caméra
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment",
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: false
                })
                .then(function(stream) {
                    videoStream = stream;
                    video.srcObject = stream;
                    video.play();

                    // Démarrer la détection de QR code
                    scanInterval = setInterval(scanQRCode, 100);
                })
                .catch(function(err) {
                    console.error("Erreur d'accès à la caméra: ", err);
                    showAlert("Impossible d'accéder à la caméra: " + err.message, 'danger');
                    stopScanning();
                });
        }

        function stopScanning() {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }

            if (scanInterval) {
                clearInterval(scanInterval);
                scanInterval = null;
            }

            videoContainer.style.display = 'none';
            startScanBtn.style.display = 'block';
            scanResult.style.display = 'none';
        }

        function scanQRCode() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert"
                });

                if (code) {
                    try {
                        const qrData = JSON.parse(code.data);
                        processScannedBale(qrData);
                    } catch (e) {
                        showScanResult("QR code invalide. Le format attendu est JSON.", false);
                    }
                }
            }
        }

        function processScannedBale(qrData) {
            // Vérifier que le QR code contient les données nécessaires
            const requiredFields = ['id', 'reference', 'date_sortie', 'poids_brut', 'poids_net', 'variete'];
            const missingFields = requiredFields.filter(field => !qrData[field]);

            if (missingFields.length > 0) {
                showScanResult(`QR code incomplet. Champs manquants: ${missingFields.join(', ')}`, false);
                return;
            }

            // Vérifier si cette balle a déjà été scannée
            const existingBale = scannedBales.find(b => b.id === qrData.id);

            if (existingBale) {
                showScanResult("Cette balle a déjà été scannée.", false);
                return;
            }

            // Ajouter la balle scannée à la liste
            const newBale = {
                id: qrData.id,
                reference: qrData.reference,
                date_sortie: qrData.date_sortie,
                poids_brut: parseFloat(qrData.poids_brut),
                poids_net: parseFloat(qrData.poids_net),
                variete: qrData.variete,
                marquage: qrData.marquage || 'N/A',
                longueur: qrData.longueur || 'N/A',
                soie: qrData.soie || 'N/A',
                type_vente: qrData.type_vente || 'N/A',
                date_classement: qrData.date_classement || 'N/A',
                usine: qrData.usine || 'N/A'
            };

            scannedBales.push(newBale);
            updateScannedBalesTable();
            showScanResult(`Balle ${qrData.reference} scannée avec succès!`, true);
            updateTotals();
            
            // Jouer un son de succès
            playSuccessSound();
        }

        function showScanResult(message, isSuccess) {
            scanResult.textContent = message;
            scanResult.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
            scanResult.style.display = 'block';

            if (isSuccess) {
                setTimeout(() => {
                    scanResult.style.display = 'none';
                }, 3000);
            }
        }

        function updateScannedBalesTable() {
            if (scannedBales.length === 0) {
                noBalesRow.style.display = '';
                scannedBalesBody.innerHTML = '';
                return;
            }

            noBalesRow.style.display = 'none';
            scannedBalesBody.innerHTML = '';

            scannedBales.forEach(bale => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${bale.id}</td>
                    <td>${bale.reference}</td>
                    <td>${bale.date_sortie}</td>
                    <td>${bale.poids_brut.toFixed(2)} kg</td>
                    <td>${bale.poids_net.toFixed(2)} kg</td>
                    <td>${bale.variete}</td>
                    <td>${bale.usine}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeBale('${bale.id}')" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                scannedBalesBody.appendChild(row);
            });
        }

        function updateTotals() {
            const totalBrut = scannedBales.reduce((sum, bale) => sum + bale.poids_brut, 0);
            const totalNet = scannedBales.reduce((sum, bale) => sum + bale.poids_net, 0);

            totalBrutElement.textContent = totalBrut.toFixed(2) + ' kg';
            totalNetElement.textContent = totalNet.toFixed(2) + ' kg';
            balesCount.textContent = scannedBales.length;
        }

        function validerExpedition(e) {
            e.preventDefault();

            if (scannedBales.length === 0) {
                showAlert('Aucune balle scannée pour cette expédition.', 'warning');
                return;
            }

            // Vérifier que tous les champs obligatoires sont remplis
            if (!validateRequiredFields()) {
                return;
            }

            // Calculer les totaux
            const totalPoidsBrut = scannedBales.reduce((sum, bale) => sum + bale.poids_brut, 0);
            const totalPoidsNet = scannedBales.reduce((sum, bale) => sum + bale.poids_net, 0);

            // Créer une nouvelle expédition
            const newExpedition = {
                ocNumber: ocNumberInput.value,
                icNumber: icNumberInput.value,
                dateHeure: expeditionDateInput.value,
                typeVente: document.getElementById('type-vente').value,
                longueurSoie: document.getElementById('longueur-soie').value,
                usine: document.getElementById('usine').value,
                nbBalles: scannedBales.length,
                poidsBrut: totalPoidsBrut,
                poidsNet: totalPoidsNet,
                immatriculation: document.getElementById('immatriculation').value,
                chauffeur: document.getElementById('chauffeur').value,
                status: 'synchronized',
                bales: [...scannedBales],
                createdAt: new Date().toISOString()
            };

            expeditions.unshift(newExpedition); // Ajouter au début du tableau
            currentOCNumber++;
            saveExpeditions();
            updateRecentExpeditions();
            updateStats();
            updateChart();

            // Réinitialiser le formulaire
            resetExpeditionForm();
            generateExpeditionNumbers();

            showAlert('Expédition enregistrée avec succès!', 'success');
            playSuccessSound();
        }

        function validateRequiredFields() {
            const requiredFields = ['type-vente', 'longueur-soie', 'usine', 'immatriculation', 'chauffeur'];
            const missingFields = requiredFields.filter(field => {
                const value = document.getElementById(field).value;
                return !value || value.trim() === '';
            });

            if (missingFields.length > 0) {
                const fieldNames = missingFields.map(f => {
                    return {
                        'type-vente': 'Type de vente',
                        'longueur-soie': 'Longueur de soie',
                        'usine': 'Usine de provenance',
                        'immatriculation': 'Immatriculation véhicule',
                        'chauffeur': 'Chauffeur'
                    }[f];
                }).join(', ');
                
                showAlert(`Veuillez remplir tous les champs obligatoires: ${fieldNames}`, 'warning');
                return false;
            }

            return true;
        }

        function resetExpeditionForm() {
            scannedBales = [];
            updateScannedBalesTable();
            updateTotals();
            document.getElementById('type-vente').value = '';
            document.getElementById('longueur-soie').value = '';
            document.getElementById('usine').value = '';
            document.getElementById('immatriculation').value = '';
            document.getElementById('chauffeur').value = '';
            stopScanning();
        }

        function updateRecentExpeditions() {
            if (expeditions.length === 0) {
                recentExpeditionsList.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-shipping-fast fa-2x mb-2"></i>
                        <p class="mb-0">Aucune expédition récente</p>
                    </div>
                `;
                return;
            }

            recentExpeditionsList.innerHTML = '';
            
            // Afficher les 5 dernières expéditions
            expeditions.slice(0, 5).forEach(exp => {
                const expeditionItem = document.createElement('a');
                expeditionItem.className = `list-group-item list-group-item-action expedition-card ${exp.status}`;
                expeditionItem.href = 'javascript:void(0);';
                expeditionItem.onclick = () => showExpeditionDetails(exp.ocNumber);
                expeditionItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">${exp.ocNumber}</h6>
                            <small class="text-muted">${exp.dateHeure}</small>
                        </div>
                        <span class="badge ${exp.status === 'synchronized' ? 'bg-primary' : 'bg-success'}">
                            ${exp.status === 'synchronized' ? 'Synchronisé' : 'Réceptionné'}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small>${exp.nbBalles} balles</small>
                        <small>${exp.poidsNet.toFixed(2)} kg net</small>
                    </div>
                `;
                recentExpeditionsList.appendChild(expeditionItem);
            });
        }

        function showExpeditionDetails(ocNumber) {
            const expedition = expeditions.find(exp => exp.ocNumber === ocNumber);
            if (!expedition) return;

            let detailsHTML = `
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4 class="fw-bold">Expédition N° ${expedition.ocNumber}</h4>
                            <p class="text-muted mb-1">${expedition.dateHeure}</p>
                            <span class="badge ${expedition.status === 'synchronized' ? 'bg-primary' : 'bg-success'}">
                                ${expedition.status === 'synchronized' ? 'Synchronisé' : 'Réceptionné'}
                            </span>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="mb-1"><strong>N° I.C:</strong> ${expedition.icNumber}</p>
                            <p class="mb-1"><strong>Balles:</strong> ${expedition.nbBalles}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h6 class="card-title text-muted text-uppercase small">Informations Véhicule</h6>
                                    <div class="mb-2">
                                        <span class="fw-bold">Immatriculation:</span>
                                        <span class="float-end">${expedition.immatriculation}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Chauffeur:</span>
                                        <span class="float-end">${expedition.chauffeur}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h6 class="card-title text-muted text-uppercase small">Caractéristiques</h6>
                                    <div class="mb-2">
                                        <span class="fw-bold">Type de vente:</span>
                                        <span class="float-end">${expedition.typeVente}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Longueur de soie:</span>
                                        <span class="float-end">${expedition.longueurSoie}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 bg-primary-light shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-muted text-uppercase small">Poids Brut</h6>
                                    <h3 class="mb-0">${expedition.poidsBrut.toFixed(2)} kg</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-success-light shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-muted text-uppercase small">Poids Net</h6>
                                    <h3 class="mb-0">${expedition.poidsNet.toFixed(2)} kg</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-warning-light shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-muted text-uppercase small">Nombre de Balles</h6>
                                    <h3 class="mb-0">${expedition.nbBalles}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0">Liste des Balles</h5>
                                        <span class="badge bg-primary">${expedition.nbBalles} balles</span>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Référence</th>
                                                    <th>Poids brut</th>
                                                    <th>Poids net</th>
                                                    <th>Variété</th>
                                                    <th>Usine</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            
            expedition.bales.forEach(bale => {
                detailsHTML += `
                    <tr>
                        <td>${bale.id}</td>
                        <td>${bale.reference}</td>
                        <td>${bale.poids_brut.toFixed(2)} kg</td>
                        <td>${bale.poids_net.toFixed(2)} kg</td>
                        <td>${bale.variete}</td>
                        <td>${bale.usine}</td>
                    </tr>`;
            });

            detailsHTML += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            
            document.getElementById('modal-details-content').innerHTML = detailsHTML;
            detailsModal.show();
        }

        function changeExpeditionStatus(ocNumber, newStatus) {
            const expedition = expeditions.find(exp => exp.ocNumber === ocNumber);
            if (expedition) {
                expedition.status = newStatus === 'Réceptionné' ? 'received' : 'synchronized';
                expedition.etape = newStatus;
                saveExpeditions();
                updateRecentExpeditions();

                showAlert(`Statut de l'expédition ${ocNumber} mis à jour: ${newStatus}`, 'success');
            }
        }

        function saveExpeditions() {
            localStorage.setItem('expeditions', JSON.stringify(expeditions));
            localStorage.setItem('currentOCNumber', currentOCNumber);
        }

        function loadExpeditions() {
            const savedExpeditions = localStorage.getItem('expeditions');
            if (savedExpeditions) {
                expeditions = JSON.parse(savedExpeditions);
            }

            const savedOCNumber = localStorage.getItem('currentOCNumber');
            if (savedOCNumber) {
                currentOCNumber = parseInt(savedOCNumber);
            }

            updateRecentExpeditions();
        }

        function updateStats() {
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const startOfWeek = new Date(now.setDate(now.getDate() - now.getDay()));
            const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
            
            const todayExpeditions = expeditions.filter(exp => {
                return exp.createdAt.split('T')[0] === today;
            });
            
            const weekExpeditions = expeditions.filter(exp => {
                return new Date(exp.createdAt) >= startOfWeek;
            });
            
            const monthExpeditions = expeditions.filter(exp => {
                return new Date(exp.createdAt) >= startOfMonth;
            });
            
            statsToday.textContent = todayExpeditions.length;
            statsWeek.textContent = weekExpeditions.length;
            statsMonth.textContent = monthExpeditions.length;
        }

        function initChart() {
            const ctx = document.getElementById('expeditions-chart').getContext('2d');
            
            // Données factices pour la démo - à remplacer par vos données réelles
            const labels = Array.from({length: 7}, (_, i) => {
                const d = new Date();
                d.setDate(d.getDate() - 6 + i);
                return d.toLocaleDateString('fr-FR', {weekday: 'short'});
            });
            
            const data = labels.map(() => Math.floor(Math.random() * 10));
            
            expeditionsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Expéditions par jour',
                        data: data,
                        backgroundColor: 'rgba(13, 110, 253, 0.5)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        function updateChart() {
            // Mettre à jour le graphique avec les nouvelles données
            // Ici, nous recréons simplement le graphique pour la démo
            if (expeditionsChart) {
                expeditionsChart.destroy();
            }
            initChart();
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.style.zIndex = '1100';
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                    <div>${message}</div>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }

        function playSuccessSound() {
            const audio = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-achievement-bell-600.mp3');
            audio.volume = 0.3;
            audio.play().catch(e => console.log("Audio play failed:", e));
        }

        function printExpeditionDetails() {
            const printContent = document.getElementById('modal-details-content').innerHTML;
            const originalContent = document.body.innerHTML;
            
            document.body.innerHTML = `
                <div class="container mt-4">
                    <div class="text-center mb-4">
                        <h2>Détails de l'Expédition</h2>
                        <p class="text-muted">Imprimé le ${new Date().toLocaleString('fr-FR')}</p>
                    </div>
                    ${printContent}
                </div>
            `;
            
            window.print();
            document.body.innerHTML = originalContent;
            detailsModal.show();
        }

        // Exposer les fonctions au scope global pour les boutons dans le HTML
        window.removeBale = function(baleId) {
            scannedBales = scannedBales.filter(bale => bale.id !== baleId);
            updateScannedBalesTable();
            updateTotals();
        };

        window.showExpeditionDetails = showExpeditionDetails;
        window.changeExpeditionStatus = changeExpeditionStatus;
        window.printExpeditionDetails = printExpeditionDetails;
    });
</script>

@endsection