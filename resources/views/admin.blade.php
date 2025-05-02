@extends('layouts.app')

@section('title', 'Admin')

@section('styles')
<style>
    /* Existing styles */
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

    /* New styles for admin navigation */
    .admin-nav {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 1rem 0;
        margin-bottom: 2rem;
        border-radius: 0.5rem;
    }

    .admin-nav .nav-link {
        position: relative;
        transition: all 0.3s ease;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
    }

    .admin-nav .nav-link:hover {
        background-color: #e5e7eb;
        color: #1d4ed8;
    }

    .admin-nav .nav-link.active {
        background-color: #dbeafe;
        color: #1d4ed8;
        font-weight: 600;
    }

    .admin-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -0.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        height: 3px;
        background-color: #1d4ed8;
        border-radius: 2px;
    }

    /* Adjust mobile menu button */
    .mobile-menu-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
    }

    /* Mobile nav adjustments */
    @media (max-width: 767px) {
        .admin-nav {
            display: none;
        }

        .admin-nav.active {
            display: block;
            background-color: #fff;
            position: absolute;
            top: 4rem;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .admin-nav .nav-link {
            display: block;
            margin: 0.5rem 0;
            padding: 0.75rem 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Admin Navigation -->
    <nav class="admin-nav md:flex items-center space-x-6 hidden" id="adminNav">
        <a href="#" data-page="dashboard" class="nav-link page-link text-gray-600 hover:text-blue-600 {{ $currentPage === 'dashboard' ? 'active' : '' }}">Tableau de bord</a>
        <a href="#" data-page="qr-codes" class="nav-link page-link text-gray-600 hover:text-blue-600 {{ $currentPage === 'qr-codes' ? 'active' : '' }}">QR Codes</a>
        <a href="#" data-page="users" class="nav-link page-link text-gray-600 hover:text-blue-600 {{ $currentPage === 'users' ? 'active' : '' }}">Utilisateurs</a>
        <a href="#" data-page="balles" class="nav-link page-link text-gray-600 hover:text-blue-600 {{ $currentPage === 'balles' ? 'active' : '' }}">Balles</a>
        <a href="#" data-page="reports" class="nav-link page-link text-gray-600 hover:text-blue-600 {{ $currentPage === 'reports' ? 'active' : '' }}">Rapports</a>

        <!-- User Dropdown -->
        <div class="flex items-center ml-auto">
            <div class="relative">
                <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <span id="userName" class="text-sm font-medium text-gray-700">Aucun admin connecté</span>
                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                </button>
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <a href="#" data-page="profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 page-link">Profil</a>
                    <a href="#" data-page="password" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 page-link">Modifier mot de passe</a>
                    <div class="border-t border-gray-200"></div>
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Button -->
    <div class="md:hidden flex justify-between items-center mb-4">
        <button id="mobileMenuButton" class="mobile-menu-button">
            <i class="fas fa-bars text-2xl text-gray-600"></i>
        </button>
        <div class="flex items-center">
            <button id="mobileUserMenuButton" class="flex items-center space-x-2 focus:outline-none">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-user text-gray-600"></i>
                </div>
                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Page Content -->
        <div id="dashboard" class="page-content {{ $currentPage === 'dashboard' ? 'active' : '' }}">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tableau de bord</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Visiteurs</p>
                            <p id="visitorsCount" class="text-3xl font-bold">Aucun</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">QR Codes générés</p>
                            <p id="qrCodesCount" class="text-3xl font-bold">{{ count($qrcodes) }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-qrcode text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium">Utilisateurs</p>
                            <div class="flex space-x-4 mt-2">
                                <div>
                                    <p class="text-xl font-bold"><span id="adminCount">{{ $adminCount }}</span> <span class="text-xs font-normal text-gray-500">Admin</span></p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold"><span id="agentCount">{{ $agentCount }}</span> <span class="text-xs font-normal text-gray-500">Agent</span></p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold"><span id="buyerCount">{{ $buyerCount }}</span> <span class="text-xs font-normal text-gray-500">Acheteur</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-user-shield text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Activité récente</h2>
                <div id="recentActivity" class="space-y-4">
                    <p class="text-gray-500 text-center py-4">Aucune activité récente</p>
                </div>
            </div>
        </div>

        <!-- QR Codes Page -->
        <div id="qr-codes" class="page-content {{ $currentPage === 'qr-codes' ? 'active' : '' }}">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Gestion des QR Codes</h1>
                <button onclick="showModal('generateQrModal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouveau QR Code
                </button>
            </div>

            <!-- QR Codes Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Tous</option>
                            <option>Manuels</option>
                            <option>Automatiques</option>
                        </select>
                    </div>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 flex items-center">
                        <i class="fas fa-file-export mr-2"></i> Exporter
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date création</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="qrCodesTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse ($qrcodes as $qrcode)
                            <tr>
                                <td class="px-6 py-4">
                                    @if ($qrcode->qr_data)
                                        <img src="{{ $qrcode->qr_data }}" alt="QR Code" class="h-16 w-16">
                                    @else
                                        <span class="text-gray-500">Non généré</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $qrcode->reference }}</td>
                                <td class="px-6 py-4">{{ $qrcode->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">{{ $qrcode->type ?? 'Manuel' }}</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 mr-2" onclick="printSingleQR('{{ $qrcode->reference }}', '{{ $qrcode->qr_data }}')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800" onclick="confirmDelete('{{ $qrcode->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun QR Code généré</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t flex justify-between items-center">
                    <div class="text-sm text-gray-500">Affichage de <span id="qrStart">0</span> à <span id="qrEnd">0</span> sur <span id="qrTotal">{{ count($qrcodes) }}</span> résultats</div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-lg text-gray-700 bg-gray-100">Précédent</button>
                        <button class="px-3 py-1 border rounded-lg text-gray-700 bg-gray-100">Suivant</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Page -->
        <div id="users" class="page-content {{ $currentPage === 'users' ? 'active' : '' }}">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
                <button onclick="showModal('addUserModal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i> Ajouter un utilisateur
                </button>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Tous</option>
                            <option>Admin</option>
                            <option>Agent</option>
                            <option>Acheteur</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date création</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ ucfirst($user->role) }}</td>
                                <td class="px-6 py-4">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 mr-2" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800" onclick="confirmDelete('{{ $user->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun utilisateur trouvé</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t flex justify-between items-center">
                    <div class="text-sm text-gray-500">Affichage de <span id="usersStart">0</span> à <span id="usersEnd">0</span> sur <span id="usersTotal">{{ count($users) }}</span> résultats</div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-lg text-gray-700 bg-gray-100">Précédent</button>
                        <button class="px-3 py-1 border rounded-lg text-gray-700 bg-gray-100">Suivant</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balles Page -->
        <div id="balles" class="page-content {{ $currentPage === 'balles' ? 'active' : '' }}">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Balles de Coton</h1>
                <button onclick="showModal('addBalleModal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-box-open mr-2"></i> Ajouter une balle
                </button>
            </div>

            <!-- Balles Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Toutes</option>
                            <option>Avec QR Code</option>
                            <option>Sans QR Code</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poids (kg)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variété</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qualité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ballesTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse ($balles as $balle)
                            <tr>
                                <td class="px-6 py-4">{{ $balle->reference }}</td>
                                <td class="px-6 py-4">{{ $balle->poids_net ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $balle->variete ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $balle->qualite ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $qrCode = $qrcodes->firstWhere('reference', $balle->reference);
                                    @endphp
                                    @if ($qrCode && $qrCode->qr_data)
                                        <img src="{{ $qrCode->qr_data }}" alt="QR Code" class="h-16 w-16">
                                    @else
                                        <span class="text-gray-500">Non généré</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 mr-2" onclick="editBalle('{{ $balle->id }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800" onclick="confirmDelete('{{ $balle->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucune balle enregistrée</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t flex justify-between items-center">
                    <div class="text-sm text-gray-500">Affichage de <span id="ballesStart">0</span> à <span id="ballesEnd">0</span> sur <span id="ballesTotal">{{ $ballesCount }}</span> résultats</div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-lg text-gray-700 bg-gray-100">Précédent</button>
                        <button class="px-3 py-1 border rounded-lg text-gray-700 bg-gray-100">Suivant</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Page -->
        <div id="reports" class="page-content {{ $currentPage === 'reports' ? 'active' : '' }}">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Rapports et Statistiques</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Génération de QR Codes</h2>
                    <canvas id="qrGenerationChart" height="250"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Activité des scans</h2>
                    <canvas id="scanActivityChart" height="250"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Export de données</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 flex flex-col items-center">
                        <i class="fas fa-qrcode text-2xl mb-2"></i>
                        <span>QR Codes</span>
                    </button>
                    <button class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 flex flex-col items-center">
                        <i class="fas fa-boxes text-2xl mb-2"></i>
                        <span>Balles de coton</span>
                    </button>
                    <button class="bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 flex flex-col items-center">
                        <i class="fas fa-users text-2xl mb-2"></i>
                        <span>Utilisateurs</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Page -->
        <div id="profile" class="page-content {{ $currentPage === 'profile' ? 'active' : '' }}">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Mon Profil</h1>

            <div class="bg-white rounded-lg shadow p-6 max-w-3xl mx-auto">
                <div class="flex items-center space-x-6 mb-8">
                    <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center">
                        <i class="fas fa-user text-3xl text-gray-500"></i>
                    </div>
                    <div>
                        <h2 id="profileName" class="text-xl font-semibold">{{ auth()->user()->name ?? 'Nom Admin' }}</h2>
                        <p id="profileRole" class="text-gray-600">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</p>
                        <p id="profileEmail" class="text-gray-600">{{ auth()->user()->email ?? 'admin@sodeco.com' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" name="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->name ?? 'Nom Admin' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->email ?? 'admin@sodeco.com' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="tel" name="phone" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="+229 XX XX XX XX" value="{{ auth()->user()->phone ?? '' }}">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Page -->
        <div id="password" class="page-content {{ $currentPage === 'password' ? 'active' : '' }}">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le mot de passe</h1>

            <div class="bg-white rounded-lg shadow p-6 max-w-3xl mx-auto">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Generate QR Code Modal -->
    <div id="generateQrModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="p-4 border-b">
                <h3 class="text-xl font-semibold">Générer un QR Code</h3>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('admin.qrcode.generate') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                        <input type="text" name="reference" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
                        <textarea name="content" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('generateQrModal')" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Générer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="p-4 border-b">
                <h3 class="text-xl font-semibold">Ajouter un utilisateur</h3>
            </div>
            <div class="p-4">
                <form id="addUserForm" method="POST" action="{{ route('admin.addUser') }}">
                    @csrf
                    <div class="space-y-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                            <select name="role" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="admin">Admin</option>
                                <option value="agent">Agent</option>
                                <option value="buyer">Acheteur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('addUserModal')" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="p-4 border-b">
                <h3 class="text-xl font-semibold">Modifier l'utilisateur</h3>
            </div>
            <div class="p-4">
                <form id="editUserForm" method="POST" action="{{ route('admin.updateUser') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editUserId" name="id">
                    <div class="space-y-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" id="editUserName" name="name" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="editUserEmail" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                            <select id="editUserRole" name="role" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="admin">Admin</option>
                                <option value="agent">Agent</option>
                                <option value="buyer">Acheteur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('editUserModal')" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Balle Modal -->
    <div id="addBalleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="p-4 border-b">
                <h3 class="text-xl font-semibold">Ajouter une balle</h3>
            </div>
            <div class="p-4">
                <form id="addBalleForm" method="POST" action="{{ route('admin.addBalle') }}">
                    @csrf
                    <div class="space-y-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                            <input type="text" name="reference" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poids net (kg)</label>
                            <input type="number" step="0.01" name="poids_net" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Variété</label>
                            <input type="text" name="variete" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Qualité</label>
                            <input type="text" name="qualite" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideModal('addBalleModal')" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="p-4 border-b">
                <h3 id="confirmationTitle" class="text-xl font-semibold">Confirmation</h3>
            </div>
            <div class="p-4">
                <p id="confirmationMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="hideModal('confirmationModal')" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</button>
                    <button type="button" id="confirmActionButton" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Confirmer</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Initialize charts for reports page
    function initCharts() {
        const qrGenerationCtx = document.getElementById('qrGenerationChart')?.getContext('2d');
        if (qrGenerationCtx) {
            new Chart(qrGenerationCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'QR Codes générés',
                        data: [10, 20, 15, 25, 30, 35],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        }

        const scanActivityCtx = document.getElementById('scanActivityChart')?.getContext('2d');
        if (scanActivityCtx) {
            new Chart(scanActivityCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Scans effectués',
                        data: [50, 70, 60, 80, 90, 100],
                        backgroundColor: 'rgba(46, 204, 113, 0.7)',
                        borderColor: 'rgba(46, 204, 113, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    }

    // Show modal
    function showModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    // Hide modal
    function hideModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Edit user
    function editUser(id, name, email, role) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
        showModal('editUserModal');
    }

    // Confirm delete
    let deleteId = null;
    function confirmDelete(id) {
        deleteId = id;
        document.getElementById('confirmationMessage').textContent = 'Êtes-vous sûr de vouloir supprimer cet élément ?';
        showModal('confirmationModal');
    }

    // Handle navigation
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const page = link.getAttribute('data-page');
            switchPage(page);
        });
    });

    function switchPage(page) {
        document.querySelectorAll('.page-content').forEach(content => {
            content.classList.remove('active');
        });
        document.getElementById(page).classList.add('active');

        document.querySelectorAll('.page-link').forEach(link => {
            link.classList.remove('active');
        });
        document.querySelector(`.page-link[data-page="${page}"]`).classList.add('active');

        // Update URL without reloading
        history.pushState({}, '', `?page=${page}`);

        // Initialize charts for reports page
        if (page === 'reports') {
            initCharts();
        }
    }

    // Mobile menu toggle
    document.getElementById('mobileMenuButton').addEventListener('click', () => {
        const adminNav = document.getElementById('adminNav');
        adminNav.classList.toggle('active');
    });

    // User dropdown toggle
    document.getElementById('userMenuButton').addEventListener('click', () => {
        document.getElementById('userDropdown').classList.toggle('hidden');
    });

    // Mobile user dropdown toggle
    document.getElementById('mobileUserMenuButton')?.addEventListener('click', () => {
        document.getElementById('userDropdown').classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('userDropdown');
        const userButton = document.getElementById('userMenuButton');
        const mobileUserButton = document.getElementById('mobileUserMenuButton');
        if (!userButton.contains(e.target) && !mobileUserButton?.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Initialize page based on URL
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 'dashboard';
        switchPage(page);
    });

    // Existing QR code functions (unchanged)
    function generateBalleQR(id, reference) {
        const qrCell = document.getElementById(`qr-cell-${id}`);
        qrCell.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';

        fetch('{{ route("admin.qrcode.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ reference: reference })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                qrCell.innerHTML = `<img src="${data.qr_data}" alt="QR Code" style="height: 100px;">`;
                const actionCell = document.querySelector(`#row-${id} td:last-child div`);
                actionCell.innerHTML = `
                    <button class="btn btn-sm btn-success me-2" onclick="saveQRCodeToDB('${id}', '${reference}', '${data.qr_data}')" title="Enregistrer">
                        <i class="fas fa-save"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="printSingleQR('${reference}', '${data.qr_data}')" title="Imprimer">
                        <i class="fas fa-print"></i>
                    </button>
                `;
                alert("QR Code généré avec succès !");
            } else {
                throw new Error(data.message || "Erreur lors de la génération");
            }
        })
        .then(() => {
            saveQRCodeToDB(id, reference, qrCell.querySelector('img').src);
        })
        .catch(error => {
            qrCell.innerHTML = '<span class="badge bg-danger">Erreur</span>';
            alert("Erreur: " + error.message);
        });
    }

    function saveQRCodeToDB(id, reference, qrData) {
        const saveBtn = document.querySelector(`#row-${id} .btn-success`);
        if (!saveBtn) return;
        const originalHtml = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch('{{ route("admin.qrcode.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                reference: reference,
                qrData: qrData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("QR Code enregistré avec succès !");
            } else {
                throw new Error(data.message || "Erreur lors de l'enregistrement");
            }
        })
        .catch(error => {
            alert("Erreur: " + error.message);
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalHtml;
        });
    }

    function printSingleQR(reference, url) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head><title>Impression QR Code - ${reference}</title>
                <style>
                    body { text-align: center; margin: 20px; }
                    .qr-preview { margin: 20px auto; max-width: 400px; }
                    img { width: 300px; height: 300px; }
                </style>
                </head>
                <body>
                    <div class="qr-preview">
                        <img src="${url}" alt="QR Code">
                        <div class="reference-text fw-bold mt-2">${reference}</div>
                    </div>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>
@endsection