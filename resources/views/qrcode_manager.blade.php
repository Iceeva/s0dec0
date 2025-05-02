@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Vertical Sidebar -->
<div class="sidebar-vertical" id="sidebar">
    <a href="#qrcode-manager"><i class="fas fa-qrcode mr-2"></i> Gestion QR Codes</a>
    <a href="#nouvelles-balles"><i class="fas fa-plus-circle mr-2"></i> Nouvelles balles</a>
    <a href="#inventaire"><i class="fas fa-list mr-2"></i> Inventaire</a>
    <a href="#statistiques"><i class="fas fa-chart-bar mr-2"></i> Statistiques</a>
    <a href="#exportations"><i class="fas fa-file-export mr-2"></i> Exportations</a>
    <a href="#historique"><i class="fas fa-history mr-2"></i> Historique</a>
    <div class="sidebar-divider"></div>
    <a href="{{ route('home') }}"><i class="fas fa-home mr-2"></i> Accueil</a>
    <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt mr-2"></i> Connexion</a>
    {{-- <a href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield mr-2"></i> Espace Admin</a> --}}
    <div class="sidebar-divider"></div>
    <a href="#"><i class="fas fa-info-circle mr-2"></i> À propos</a>
    <a href="#"><i class="fas fa-envelope mr-2"></i> Contact</a>
    <a href="#"><i class="fas fa-cog mr-2"></i> Paramètres</a>
</div>

<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- QR Code Manager Page (main content) -->
    <div id="qrcode-manager" class="page-content active">

        <!-- Statistiques en haut -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-qrcode me-2"></i>QR Codes Générés</h5>
                                <p class="card-text display-4">{{ $qrCodeCount }}</p>
                            </div>
                            <i class="fas fa-qrcode fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-boxes me-2"></i>Total Balles</h5>
                                <p class="card-text display-4">{{ $balleCount }}</p>
                            </div>
                            <i class="fas fa-boxes fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte principale -->
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2 text-primary"></i>Gestion des QR Codes
                </h5>
                <div id="generateSelected" class="d-flex">
                    <div class="input-group me-3" style="width: 300px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par référence...">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form id="ballForm">
                    <div class="table-responsive">
                        <table id="ballesTable" class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>ID</th>
                                    <th>Référence</th>
                                    <th>Date Sortie</th>
                                    <th>Poids Brut</th>
                                    <th>Poids Net</th>
                                    <th>Variété</th>
                                    <th>Marquage</th>
                                    <th>Longueur Soie</th>
                                    <th>Type Vente</th>
                                    <th>Est Classé</th>
                                    <th>Date Classement</th>
                                    <th>Usine</th>
                                    <th>QR Code</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach($balles as $balle)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input selectRow" name="ids[]" value="{{ $balle->id }}">
                                    </td>
                                    <td>{{ $balle->id }}</td>
                                    <td><strong>{{ $balle->reference }}</strong></td>
                                    <td>{{ $balle->date_sortie }}</td>
                                    <td>{{ $balle->poids_brut }} kg</td>
                                    <td>{{ $balle->poids_net }} kg</td>
                                    <td>{{ $balle->variete }}</td>
                                    <td>{{ $balle->marquage }}</td>
                                    <td>{{ $balle->longueur_soie }}</td>
                                    <td>{{ $balle->type_vente }}</td>
                                    <td>
                                        @if($balle->est_classe)
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Oui</span>
                                        @else
                                        <span class="badge bg-secondary"><i class="fas fa-times me-1"></i>Non</span>
                                        @endif
                                    </td>
                                    <td>{{ $balle->date_classement ?? '-' }}</td>
                                    <td>{{ $balle->usine }}</td>
                                    <td id="qr-cell-{{ $balle->id }}">
                                        @if($balle->qrCodeImage)
                                        {!! $balle->qrCodeImage !!}
                                        @else
                                        <span class="badge bg-warning text-dark">Non généré</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-primary generateBtn" data-id="{{ $balle->id }}" title="Générer QR Code">
                                                <i class="fas fa-qrcode"></i>
                                            </button>
                                            @if($balle->qrCodeImage)
                                            <button class="btn btn-outline-success printBtn" data-id="{{ $balle->id }}" title="Imprimer">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button class="btn btn-outline-info saveBtn" data-id="{{ $balle->id }}" title="Enregistrer">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <button class="btn btn-outline-info downloadBtn" data-id="{{ $balle->id }}" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            @else
                                            <button class="btn btn-outline-secondary disabled" title="Imprimer (non disponible)">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary disabled" title="Enregistrer (non disponible)">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary disabled" title="Télécharger (non disponible)">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <!-- Nouvelles Balles Page -->
    <div id="nouvelles-balles" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Nouvelles Balles</h3>
            <button class="btn btn-primary" onclick="showModal('addBalleModal')">
                <i class="fas fa-plus me-2"></i>Ajouter une balle
            </button>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Formulaire d'ajout
            </div>
            <div class="card-body">
                <form id="balleForm" method="POST" action="{{ route('balles.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Référence*</label>
                            <input type="text" name="reference" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date de sortie*</label>
                            <input type="date" name="date_sortie" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Poids brut (kg)*</label>
                            <input type="number" step="0.01" name="poids_brut" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Poids net (kg)*</label>
                            <input type="number" step="0.01" name="poids_net" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Variété*</label>
                            <input type="text" name="variete" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Usine*</label>
                            <input type="text" name="usine" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Marquage</label>
                            <input type="text" name="marquage" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Longueur de soie</label>
                            <input type="text" name="longueur_soie" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Type de vente</label>
                            <select name="type_vente" class="form-select">
                                <option value="KABA">KABA</option>
                                <option value="">/..</option>
                                <option value="">/..</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Est classé</label>
                            <select name="est_classe" class="form-select">
                                <option value="0">Non</option>
                                <option value="1">Oui</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date de classement</label>
                            <input type="date" name="date_classement" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inventaire Page -->
    <div id="inventaire" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0"><i class="fas fa-list me-2"></i>Inventaire des Balles</h3>
            <div>
                <button class="btn btn-outline-primary me-2"><i class="fas fa-filter me-2"></i>Filtrer</button>
                <button class="btn btn-primary"><i class="fas fa-download me-2"></i>Exporter</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-boxes me-2"></i>Liste des Balles en stock</span>
                <span class="badge bg-primary"><?= count($balles) ?> Balles</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Référence</th>
                                <th>Date Sortie</th>
                                <th>Poids Brut</th>
                                <th>Poids Net</th>
                                <th>Variété</th>
                                <th>Usine</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($balles as $balle): ?>
                            <tr>
                                <td><?= $balle['id'] ?></td>
                                <td class="fw-bold"><?= $balle['reference'] ?></td>
                                <td><?= date('d/m/Y', strtotime($balle['date_sortie'])) ?></td>
                                <td><?= $balle['poids_brut'] ?> kg</td>
                                <td><?= $balle['poids_net'] ?> kg</td>
                                <td><?= $balle['variete'] ?></td>
                                <td><?= $balle['usine'] ?></td>
                                <td class="no-print">
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques Page -->
    <div id="statistiques" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistiques</h3>
            <select class="form-select" style="width: auto;">
                <option>Ce mois</option>
                <option>Ce trimestre</option>
                <option>Cette année</option>
            </select>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <div class="stats-card" style="background-color: #3498db;">
                    <i class="fas fa-box"></i>
                    <div class="count"><?= $balleCount ?></div>
                    <div class="label">Balles en stock</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card" style="background-color: #2ecc71;">
                    <i class="fas fa-truck"></i>
                    <div class="count">0</div>
                    <div class="label">Balles expédiées</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card" style="background-color: #e74c3c;">
                    <i class="fas fa-exchange-alt"></i>
                    <div class="count">0</div>
                    <div class="label">Mouvements</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line me-2"></i>Évolution des stocks
            </div>
            <div class="card-body">
                <canvas id="stockChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Exportations Page -->
    <div id="exportations" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0"><i class="fas fa-file-export me-2"></i>Exportations</h3>
            <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Nouvelle exportation</button>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>Historique des exportations</span>
                <span class="badge bg-primary">0 Exportations</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Nombre de balles</th>
                                <th>Poids total</th>
                                <th>Statut</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucune exportation enregistrée</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique Page -->
    <div id="historique" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0"><i class="fas fa-history me-2"></i>Historique des activités</h3>
            <select class="form-select" style="width: auto;">
                <option>Toutes les activités</option>
                <option>Créations</option>
                <option>Modifications</option>
                <option>Suppressions</option>
            </select>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Dernières activités
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-badge bg-primary"><i class="fas fa-plus"></i></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Nouvelle balle ajoutée</span>
                                <small class="text-muted">Aujourd'hui, 10:45</small>
                            </div>
                            <p>Référence: K/36/29282</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-badge bg-success"><i class="fas fa-qrcode"></i></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">QR Code généré</span>
                                <small class="text-muted">Hier, 16:30</small>
                            </div>
                            <p>Pour la balle G/45/12345</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-badge bg-info"><i class="fas fa-edit"></i></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Balle modifiée</span>
                                <small class="text-muted">12/04/2023, 09:15</small>
                            </div>
                            <p>Référence: K/36/29281 - Poids net mis à jour</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sélection/désélection globale
        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.selectRow');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Génération groupée
        document.getElementById('generateSelected').addEventListener('click', function() {
            const selected = document.querySelectorAll('.selectRow:checked');
            //if (selected.length === 0) {
                //alert('Veuillez sélectionner au moins une balle');
                //return;
           // }

            const form = document.getElementById('ballForm');
            const data = new FormData(form);

            fetch("{{ route('bulk_generate') }}", {
                    method: 'POST'
                    , body: data
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success'
                            , title: 'Succès'
                            , text: data.message || 'QR Codes générés avec succès!'
                            , timer: 2000
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error'
                            , title: 'Erreur'
                            , text: data.message || 'Une erreur est survenue'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error'
                        , title: 'Erreur'
                        , text: 'Une erreur est survenue lors de la génération'
                    });
                });
        });

        document.querySelectorAll('.generateBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const btn = this;
                const row = btn.closest('tr');

                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;

                fetch(`/generate/${id}`, {
                        method: 'POST'
                        , headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            , 'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mise à jour de la cellule QR Code
                            const qrCodeCell = document.getElementById(`qr-cell-${id}`);
                            qrCodeCell.innerHTML = `
                    <img src="${data.qr_data}" 
                         alt="QR Code ${data.balle.reference}"
                         style="width: 100px; height: 100px;"
                         class="img-thumbnail">
                `;

                            // Mise à jour des boutons d'action
                            const actionsCell = row.querySelector('td:last-child');
                            actionsCell.innerHTML = `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary generateBtn" data-id="${id}" title="Regénérer">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <a href="/print/${id}" class="btn btn-outline-success" title="Imprimer">
                            <i class="fas fa-print"></i>
                        </a>
                        <a href="${data.qr_data}" download="QR-${data.balle.reference}.png" 
                           class="btn btn-outline-info" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                `;
                        }
                    })
                    .finally(() => {
                        btn.innerHTML = '<i class="fas fa-qrcode"></i>';
                        btn.disabled = false;
                    });
            });
        });

        // Ajoutez cette partie pour gérer l'impression
        document.querySelectorAll('.printBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const row = this.closest('tr');
                const reference = row.querySelector('td:nth-child(3)').textContent; // Récupère la référence
                const qrCodeContent = document.getElementById(`qr-cell-${id}`).innerHTML;

                const printWindow = window.open('', '', 'width:auto,height:auto');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>QR Code - ${reference}</title>
                        <link rel="icon" type="image/png" href="{{ asset('images/Captur.png') }}">
                        <style>
                            body { 
                                font-family: Arial, sans-serif; 
                                text-align: center; 
                                padding: 10px;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                height: 100vh;
                                margin: 0;
                            }
                            .print-content {
                                max-width: 80%;
                                margin: auto;
                            }
                            .qr-container { 
                                margin: 20px auto; 
                                width: 300px;
                                height: 300px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            }
                            .qr-container svg {
                                width: 80%;
                                height: 80%;
                            }
                            .info { 
                                margin-top: 30px; 
                                font-size: 16px;
                                text-align: center;
                            }
                            h2 {
                                font-size: 24px;
                                margin-bottom: 20px;
                            }
                            @media print {
                                body {
                                    height: auto;
                                }
                                button { 
                                    display: none; 
                                }
                                .print-content {
                                    page-break-after: always;
                                }
                                .qr-container {
                                    width: 300px;
                                    height: 300px;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="logo-container">
                            <a href="/">
                                <img src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO" style="height: 80px; width: auto; max-width: 500px;">
                            </a>
                        </div>
                        <h2>QR Code - Référence: ${reference}</h2>
                        <div class="qr-container">${qrCodeContent}</div>
                        <div class="info">
                            <p>Date de génération: ${new Date().toLocaleDateString()}</p>
                        </div>
                        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Imprimer
                        </button>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            });
        });

        // Ajoutez cette partie pour gérer le téléchargement
        document.querySelectorAll('.downloadBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const svg = document.getElementById(`qr-cell-${id}`).querySelector('svg');
                if (svg) {
                    const svgData = new XMLSerializer().serializeToString(svg);
                    const canvas = document.createElement("canvas");
                    const ctx = canvas.getContext("2d");
                    const img = new Image();

                    img.onload = function() {
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        const pngFile = canvas.toDataURL("image/png");
                        const downloadLink = document.createElement("a");
                        downloadLink.download = `QRCode-${id}.png`;
                        downloadLink.href = pngFile;
                        downloadLink.click();
                    };

                    img.src = "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svgData)));
                }
            });
        });

        // Ajoutez cette partie pour gérer l'enregistrement
        document.querySelectorAll('.saveBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const qrCodeCell = document.getElementById(`qr-cell-${id}`);
                const qrCodeImage = qrCodeCell.querySelector('img');

                if (!qrCodeImage) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Erreur'
                        , text: "Aucun QR code à enregistrer"
                    });
                    return;
                }

                // Récupérer le src de l'image qui contient déjà le base64
                const qrData = qrCodeImage.src;

                // Envoyer la requête
                fetch(`/save-qrcode/${id}`, {
                        method: 'POST'
                        , headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            , 'Content-Type': 'application/json'
                            , 'Accept': 'application/json'
                        }
                        , body: JSON.stringify({
                            qr_data: qrData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success'
                                , title: 'Succès'
                                , text: data.message
                                , timer: 2000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error'
                                , title: 'Erreur'
                                , text: data.message || "Erreur lors de l'enregistrement"
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error'
                            , title: 'Erreur'
                            , text: "Une erreur est survenue lors de l'enregistrement"
                        });
                    });
            });
        });

    });

    document.addEventListener('DOMContentLoaded', function() {
        // Fonction de recherche
        const searchInput = document.getElementById('searchInput');
        const clearSearch = document.getElementById('clearSearch');
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.querySelectorAll('tr');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            rows.forEach(row => {
                const refCell = row.querySelector('td:nth-child(3)'); // Colonne Référence
                const refText = refCell.textContent.toLowerCase();

                if (refText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Effacer la recherche
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            rows.forEach(row => row.style.display = '');
        });
    });

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        sidebar.classList.toggle('open');
        body.classList.toggle('sidebar-open');

        // Change icon based on state
        const toggleBtn = document.querySelector('.sidebar-toggle i');
        if (sidebar.classList.contains('open')) {
            toggleBtn.classList.remove('fa-bars');
            toggleBtn.classList.add('fa-times');
        } else {
            toggleBtn.classList.remove('fa-times');
            toggleBtn.classList.add('fa-bars');
        }
    }

    // Fonction pour changer de page
    function showPage(pageId) {
        // Masquer toutes les pages
        document.querySelectorAll('.page-content').forEach(page => {
            page.classList.remove('active');
        });

        // Afficher la page sélectionnée
        document.getElementById(pageId).classList.add('active');

        // Fermer le sidebar sur mobile
        if (window.innerWidth < 768) {
            toggleSidebar();
        }
    }

    // Au chargement de la page, afficher la première page par défaut
    document.addEventListener('DOMContentLoaded', function() {
        // Par défaut, afficher la page des QR codes
        showPage('qrcode-manager');

        // Ajouter les écouteurs d'événements aux liens du sidebar
        document.querySelectorAll('.sidebar-vertical a').forEach(link => {
            if (link.getAttribute('href') && link.getAttribute('href').startsWith('#')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pageId = this.getAttribute('href').substring(1);
                    showPage(pageId);
                });
            }
        });
    });

    // Dans votre section script
    document.getElementById('balleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    , 'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
                Swal.fire({
                    icon: 'success'
                    , title: 'Succès'
                    , text: data.message || 'Balle enregistrée avec succès!'
                });
                form.reset();
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error'
                    , title: 'Erreur'
                    , text: error.message || "Une erreur est survenue lors de l'enregistrement"
                });
            });
    });

</script>
@endsection

@push('styles')
<style>
    /* Style pour le champ de recherche */
    #searchInput {
        transition: all 0.3s ease;
    }

    #searchInput:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Style pour le bouton effacer */
    #clearSearch {
        transition: all 0.3s ease;
    }

    #clearSearch:hover {
        background-color: #f8f9fa;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .qr-code-container {
        display: inline-block;
        text-align: center;
    }

    .qr-info {
        font-size: 0.8rem;
        color: #666;
    }

    img.img-fluid {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
    }

    .qr-code-container {
        display: inline-block;
        text-align: center;
    }

    .qr-info {
        font-size: 0.8rem;
        color: #666;
    }

    .img-thumbnail {
        max-width: 100px;
        height: auto;
        background: white;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    /* Sidebar styles */
    .sidebar-vertical {
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100vh;
        background-color: #2c3e50;
        color: white;
        transition: all 0.3s ease;
        z-index: 1000;
        padding-top: 80px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar-vertical.open {
        left: 0;
    }

    .sidebar-vertical a {
        color: white;
        padding: 12px 20px;
        text-decoration: none;
        display: block;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .sidebar-vertical a:hover {
        background-color: #3498db;
        padding-left: 25px;
    }

    .sidebar-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1100;
        background: #2c3e50;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .sidebar-toggle i {
        font-size: 1.2rem;
    }

    /* Adjust main content when sidebar is open */
    body.sidebar-open {
        padding-left: 250px;
    }

    .main-content {
        transition: margin-left 0.3s ease;
    }

    /* Style pour les pages */
    .page-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .page-content.active {
        display: block;
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

    /* Diviseur dans le sidebar */
    .sidebar-divider {
        height: 1px;
        background-color: rgba(255, 255, 255, 0.1);
        margin: 10px 0;
    }

    /* Adaptation pour les écrans mobiles */
    @media (max-width: 767.98px) {
        body.sidebar-open {
            overflow: hidden;
        }

        body.sidebar-open::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    }

</style>
@endpush
