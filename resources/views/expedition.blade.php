@extends('layouts.app')

@section('title', 'Expédition')

@section('content')

<div class="main-content">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="page-title"><i class="fas fa-shipping-fast me-2"></i> Gestion des Expéditions</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-clipboard-list me-2"></i> Nouvelle Expédition
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">N° O.C</label>
                                    <input type="text" class="form-control" id="oc-number" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">N° I.C</label>
                                    <input type="text" class="form-control" id="ic-number" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Date/Heure</label>
                                    <input type="text" class="form-control" id="expedition-date" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type-vente" class="form-label required-field">Type de vente</label>
                                    <select class="form-select" id="type-vente" required>
                                        <option value="">Sélectionner</option>
                                        <option value="KABA">KABA</option>
                                        <option value="BELA">BELA</option>
                                        <option value="ZANA">ZANA</option>
                                        <option value="ZANA/T">ZANA/T</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="longueur-soie" class="form-label required-field">Longueur de soie</label>
                                    <input type="text" class="form-control" id="longueur-soie" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="usine" class="form-label required-field">Usine de provenance</label>
                                    <input type="text" class="form-control" id="usine" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="immatriculation" class="form-label required-field">Immatriculation véhicule</label>
                                    <input type="text" class="form-control" id="immatriculation" placeholder="AA-123-BB" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="chauffeur" class="form-label required-field">Chauffeur</label>
                                    <input type="text" class="form-control" id="chauffeur" placeholder="Nom et Prénom" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <button id="start-scan" class="btn btn-success btn-lg py-3 px-4">
                                    <i class="fas fa-qrcode me-2"></i> Démarrer le Scan des Balles
                                </button>
                            </div>
                        </div>

                        <div id="video-container">
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i> Scannez le QR code sur la balle. Placez-le devant la caméra.
                            </div>
                            <video id="video" playsinline></video>
                            <div class="text-center mt-3">
                                <button id="stop-scan" class="btn btn-danger">
                                    <i class="fas fa-stop me-1"></i> Arrêter le scan
                                </button>
                            </div>
                            <div id="scan-result" class="scan-result">
                                <!-- Le résultat du scan apparaîtra ici -->
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3"><i class="fas fa-boxes me-2"></i> Balles scannées</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="scanned-bales-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Référence</th>
                                                <th>Date sortie</th>
                                                <th>Poids brut</th>
                                                <th>Poids net</th>
                                                <th>Variété</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="scanned-bales-body">
                                            <!-- Les balles scannées apparaîtront ici -->
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-active">
                                                <td colspan="3" class="fw-bold">TOTAL</td>
                                                <td class="fw-bold" id="total-brut">0.00 kg</td>
                                                <td class="fw-bold" id="total-net">0.00 kg</td>
                                                <td colspan="2" class="fw-bold" id="total-bales">0 balles</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <button id="cancel-expedition" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i> Annuler
                                </button>
                                <button id="valider-expedition" class="btn btn-primary">
                                    <i class="fas fa-check me-1"></i> Valider l'expédition
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i> Historique des Expéditions
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="expeditions-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>N° O.C</th>
                                        <th>N° I.C</th>
                                        <th>Date/Heure</th>
                                        <th>Type</th>
                                        <th>Nbr Balles</th>
                                        <th>Poids (brut/net)</th>
                                        <th>Véhicule</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="expeditions-body">
                                    <!-- Les expéditions apparaîtront ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailsModalLabel">Détails de l'Expédition</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body print-section" id="modal-details-content">
                <div class="print-header no-print">
                    <h4>Détails de l'Expédition</h4>
                </div>
                <!-- Contenu dynamique -->
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Fermer
                </button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let scannedBales = [];
        let expeditions = [];
        let currentOCNumber = 1;
        let videoStream = null;
        let scanInterval = null;

        // Éléments DOM
        const startScanBtn = document.getElementById('start-scan');
        const stopScanBtn = document.getElementById('stop-scan');
        const videoContainer = document.getElementById('video-container');
        const video = document.getElementById('video');
        const scanResult = document.getElementById('scan-result');
        const scannedBalesBody = document.getElementById('scanned-bales-body');
        const expeditionsBody = document.getElementById('expeditions-body');
        const validerExpeditionBtn = document.getElementById('valider-expedition');
        const cancelExpeditionBtn = document.getElementById('cancel-expedition');
        const detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
        const totalBrutElement = document.getElementById('total-brut');
        const totalNetElement = document.getElementById('total-net');
        const totalBalesElement = document.getElementById('total-bales');
        const ocNumberInput = document.getElementById('oc-number');
        const icNumberInput = document.getElementById('ic-number');
        const expeditionDateInput = document.getElementById('expedition-date');

        // Initialisation
        loadExpeditions();
        generateExpeditionNumbers();
        updateCurrentDateTime();

        // Mettre à jour la date/heure toutes les secondes
        setInterval(updateCurrentDateTime, 1000);

        // Événements
        startScanBtn.addEventListener('click', startScanning);
        stopScanBtn.addEventListener('click', stopScanning);
        validerExpeditionBtn.addEventListener('click', validerExpedition);
        cancelExpeditionBtn.addEventListener('click', resetExpeditionForm);

        // Fonctions
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
            expeditionDateInput.value = now.toLocaleString('fr-FR');
        }

        function startScanning() {
            // Vérifier que tous les champs obligatoires sont remplis
            const requiredFields = ['type-vente', 'longueur-soie', 'usine', 'immatriculation', 'chauffeur'];
            const missingFields = requiredFields.filter(field => !document.getElementById(field).value);

            if (missingFields.length > 0) {
                showAlert(`Veuillez remplir tous les champs obligatoires: ${missingFields.map(f => f.replace('-', ' ')).join(', ')}`, 'warning');
                return;
            }

            // Afficher le flux vidéo
            videoContainer.style.display = 'block';
            startScanBtn.style.display = 'none';

            // Accéder à la caméra
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                    , audio: false
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
                        stopScanning();
                    } catch (e) {
                        showScanResult("QR code invalide. Le format attendu est JSON.", false);
                    }
                }
            }
        }

        function processScannedBale(qrData) {
            // Vérifier que le QR code contient les données nécessaires
            const requiredFields = ['id', 'reference', 'date_sortie', 'poids_brut', 'poids_net', 'variete', 'marquage', 'longueur', 'soie', 'type_vente', 'date_classement', 'usine'];
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
                id: qrData.id
                , reference: qrData.reference
                , date_sortie: qrData.date_sortie
                , poids_brut: parseFloat(qrData.poids_brut)
                , poids_net: parseFloat(qrData.poids_net)
                , variete: qrData.variete
                , marquage: qrData.marquage
                , longueur: qrData.longueur
                , soie: qrData.soie
                , type_vente: qrData.type_vente
                , date_classement: qrData.date_classement
                , usine: qrData.usine
                , qrCode: qrData.qrCode || null
            };

            scannedBales.push(newBale);
            updateScannedBalesTable();
            showScanResult("Balle scannée avec succès!", true);
            updateTotals();
        }

        function showScanResult(message, isSuccess) {
            scanResult.textContent = message;
            scanResult.className = isSuccess ? 'scan-result scan-success' : 'scan-result scan-error';
            scanResult.style.display = 'block';

            if (isSuccess) {
                setTimeout(() => {
                    scanResult.style.display = 'none';
                }, 3000);
            }
        }

        function updateScannedBalesTable() {
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
                        <td>
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
            totalBalesElement.textContent = scannedBales.length + (scannedBales.length > 1 ? ' balles' : ' balle');
        }

        function validerExpedition() {
            if (scannedBales.length === 0) {
                showAlert('Aucune balle scannée pour cette expédition.', 'warning');
                return;
            }

            // Vérifier que tous les champs obligatoires sont remplis
            const requiredFields = ['type-vente', 'longueur-soie', 'usine', 'immatriculation', 'chauffeur'];
            const missingFields = requiredFields.filter(field => !document.getElementById(field).value);

            if (missingFields.length > 0) {
                showAlert(`Veuillez remplir tous les champs obligatoires: ${missingFields.map(f => f.replace('-', ' ')).join(', ')}`, 'warning');
                return;
            }

            // Calculer les totaux
            const totalPoidsBrut = scannedBales.reduce((sum, bale) => sum + bale.poids_brut, 0);
            const totalPoidsNet = scannedBales.reduce((sum, bale) => sum + bale.poids_net, 0);

            // Créer une nouvelle expédition
            const newExpedition = {
                ocNumber: ocNumberInput.value
                , icNumber: icNumberInput.value
                , dateHeure: expeditionDateInput.value
                , typeVente: document.getElementById('type-vente').value
                , longueurSoie: document.getElementById('longueur-soie').value
                , usine: document.getElementById('usine').value
                , nbBalles: scannedBales.length
                , poidsBrut: totalPoidsBrut
                , poidsNet: totalPoidsNet
                , immatriculation: document.getElementById('immatriculation').value
                , chauffeur: document.getElementById('chauffeur').value
                , etape: 'Synchronisé'
                , bales: [...scannedBales]
                , createdAt: new Date().toISOString()
            };

            expeditions.push(newExpedition);
            currentOCNumber++;
            saveExpeditions();
            updateExpeditionsTable();

            // Réinitialiser le formulaire
            resetExpeditionForm();
            generateExpeditionNumbers();

            showAlert('Expédition enregistrée avec succès!', 'success');
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

        function updateExpeditionsTable() {
            expeditionsBody.innerHTML = '';

            expeditions.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt)).forEach(exp => {
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td>${exp.ocNumber}</td>
                        <td>${exp.icNumber}</td>
                        <td>${exp.dateHeure}</td>
                        <td>${exp.typeVente}</td>
                        <td>${exp.nbBalles}</td>
                        <td>${exp.poidsBrut.toFixed(2)} / ${exp.poidsNet.toFixed(2)} kg</td>
                        <td>${exp.immatriculation}</td>
                        <td><span class="status-badge ${exp.etape === 'Synchronisé' ? 'status-synchronise' : 'status-receptionne'}">${exp.etape}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="showExpeditionDetails('${exp.ocNumber}')" title="Détails">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="changeExpeditionStatus('${exp.ocNumber}', 'Réceptionné')" title="Marquer comme réceptionné">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    `;
                expeditionsBody.appendChild(row);
            });
        }

        function showExpeditionDetails(ocNumber) {
            const expedition = expeditions.find(exp => exp.ocNumber === ocNumber);
            if (!expedition) return;

            let detailsHTML = `
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="fw-bold">Expédition N° ${expedition.ocNumber}</h4>
                                <p class="text-muted">${expedition.dateHeure}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="status-badge ${expedition.etape === 'Synchronisé' ? 'status-synchronise' : 'status-receptionne'}">${expedition.etape}</span>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
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
                            
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
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
                            
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted text-uppercase small">Poids Total</h6>
                                        <div class="mb-2">
                                            <span class="fw-bold">Brut:</span>
                                            <span class="float-end">${expedition.poidsBrut.toFixed(2)} kg</span>
                                        </div>
                                        <div>
                                            <span class="fw-bold">Net:</span>
                                            <span class="float-end">${expedition.poidsNet.toFixed(2)} kg</span>
                                        </div>
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
                                            <table class="bale-details-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Référence</th>
                                                        <th>Date sortie</th>
                                                        <th>Poids brut</th>
                                                        <th>Poids net</th>
                                                        <th>Variété</th>
                                                        <th>Marquage</th>
                                                        <th>Longueur</th>
                                                        <th>Soie</th>
                                                        <th>Type vente</th>
                                                        <th>Date classement</th>
                                                        <th>Usine</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                

            expedition.bales.forEach(bale => {
                detailsHTML += `
                        <tr>
                            <td>${bale.id}</td>
                            <td>${bale.reference}</td>
                            <td>${bale.date_sortie}</td>
                            <td>${bale.poids_brut.toFixed(2)} kg</td>
                            <td>${bale.poids_net.toFixed(2)} kg</td>
                            <td>${bale.variete}</td>
                            <td>${bale.marquage}</td>
                            <td>${bale.longueur}</td>
                            <td>${bale.soie}</td>
                            <td>${bale.type_vente}</td>
                            <td>${bale.date_classement}</td>
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
                expedition.etape = newStatus;
                saveExpeditions();
                updateExpeditionsTable();

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

            updateExpeditionsTable();
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;

            const container = document.querySelector('.container');
            container.prepend(alertDiv);

            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }

        // Exposer les fonctions au scope global pour les boutons dans le HTML
        window.removeBale = function(baleId) {
            scannedBales = scannedBales.filter(bale => bale.id !== baleId);
            updateScannedBalesTable();
            updateTotals();
        };

        window.showExpeditionDetails = showExpeditionDetails;
        window.changeExpeditionStatus = changeExpeditionStatus;
    });

</script>

@endsection
