<?php

global $connection;
include"../connection/connect.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    echo 'edrftghj';
    $nom=$_POST['nom_cours'];
    $categorie=$_POST['categorie'];
    $date=$_POST['date_cours'];
    $heure=$_POST['heure_cours'];
    $duree=$_POST['duree_cours'];
    $max=$_POST['max_cours'];
    $pushIt="INSERT INTO cours (nom_cours, categorie, date_cours, heure, duree, `max`)
           VALUES ('$nom', '$categorie', '$date', '$heure', '$duree', '$max')";

    if(mysqli_query($connection, $pushIt)){
    header('location:cours.php');
    exit();
    }

}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cours - GymManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 min-h-screen">
<!-- Sidebar -->
<aside class="fixed left-0 top-0 h-full w-64 bg-slate-900 text-white p-6 z-50">
    <div class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
            <i class="fas fa-dumbbell text-white"></i>
        </div>
        <h1 class="text-xl font-bold">GymManager</h1>
    </div>

    <nav class="space-y-2">
        <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-chart-pie w-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="cours.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-600 text-white">
            <i class="fas fa-calendar-alt w-5"></i>
            <span>Cours</span>
        </a>
        <a href="equipements.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-dumbbell w-5"></i>
            <span>Équipements</span>
        </a>
        <a href="associations.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-link w-5"></i>
            <span>Associations</span>
        </a>
    </nav>

    <div class="absolute bottom-6 left-6 right-6">
        <a href="login.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-sign-out-alt w-5"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="ml-64 p-8">
    <!-- Header -->
    <header class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Gestion des Cours</h2>
            <p class="text-gray-500 mt-1">Gérez vos cours et planning</p>
        </div>
        <button onclick="openModal('add')" class="flex items-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition">
            <i class="fas fa-plus"></i>
            <span>Nouveau Cours</span>
        </button>
    </header>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <!-- Search -->
            <div class="flex-1 min-w-64">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un cours..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <select id="categoryFilter" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Toutes les catégories</option>
                    <option value="Yoga">Yoga</option>
                    <option value="Cardio">Cardio</option>
                    <option value="Musculation">Musculation</option>
                    <option value="Pilates">Pilates</option>
                    <option value="CrossFit">CrossFit</option>
                </select>
            </div>

            <!-- Export Button -->
            <a href="export.php?type=cours" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-download text-gray-600"></i>
                <span>Exporter CSV</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Nom du cours</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Catégorie</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Date</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Heure</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Durée</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Max participants</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
            </tr>
            </thead>
            <tbody id="coursTableBody">
            <!-- PHP: foreach($cours as $c): -->
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-spa text-blue-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Yoga Matinal</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">Yoga</span>
                </td>
                <td class="px-6 py-4 text-gray-600">2025-06-15</td>
                <td class="px-6 py-4 text-gray-600">08:00</td>
                <td class="px-6 py-4 text-gray-600">60 min</td>
                <td class="px-6 py-4 text-gray-600">20</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button onclick="openModal('edit', 1)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(1)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heartbeat text-red-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Cardio Intense</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Cardio</span>
                </td>
                <td class="px-6 py-4 text-gray-600">2025-06-15</td>
                <td class="px-6 py-4 text-gray-600">10:00</td>
                <td class="px-6 py-4 text-gray-600">45 min</td>
                <td class="px-6 py-4 text-gray-600">15</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button onclick="openModal('edit', 2)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(2)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dumbbell text-orange-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Musculation Débutant</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Musculation</span>
                </td>
                <td class="px-6 py-4 text-gray-600">2025-06-16</td>
                <td class="px-6 py-4 text-gray-600">14:00</td>
                <td class="px-6 py-4 text-gray-600">90 min</td>
                <td class="px-6 py-4 text-gray-600">10</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button onclick="openModal('edit', 3)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(3)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-child text-purple-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Pilates Relaxation</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">Pilates</span>
                </td>
                <td class="px-6 py-4 text-gray-600">2025-06-17</td>
                <td class="px-6 py-4 text-gray-600">09:00</td>
                <td class="px-6 py-4 text-gray-600">60 min</td>
                <td class="px-6 py-4 text-gray-600">12</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button onclick="openModal('edit', 4)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(4)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-fire text-emerald-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">CrossFit Challenge</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm">CrossFit</span>
                </td>
                <td class="px-6 py-4 text-gray-600">2025-06-18</td>
                <td class="px-6 py-4 text-gray-600">17:00</td>
                <td class="px-6 py-4 text-gray-600">75 min</td>
                <td class="px-6 py-4 text-gray-600">8</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button onclick="openModal('edit', 5)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(5)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <!-- PHP: endforeach; -->
            </tbody>
        </table>
    </div>
</main>

<!-- Modal for Add/Edit Course -->
<div id="coursModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Ajouter un cours</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>form
        </div>

        <form id="coursForm" action="cours.php" method="POST" class="p-6 space-y-4">
            <input type="hidden" id="coursId" name="id_cours">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du cours *</label>
                <input type="text" id="nomCours" name="nom_cours" required
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                       placeholder="Ex: Yoga Matinal">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                <select id="categorie" name="categorie" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Sélectionner une catégorie</option>
                    <option value="Yoga">Yoga</option>
                    <option value="Cardio">Cardio</option>
                    <option value="Musculation">Musculation</option>
                    <option value="Pilates">Pilates</option>
                    <option value="CrossFit">CrossFit</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                    <input type="date" id="dateCours" name="date_cours" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Heure *</label>
                    <input type="time" id="heure" name="heure_cours" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes) *</label>
                    <input type="number" id="duree" name="duree_cours" required min="15" max="180"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="60">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max participants *</label>
                    <input type="number" id="maxParticipants" name="max_cours" required min="1" max="100"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="20">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal()"
                        class="px-6 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md mx-4 p-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Confirmer la suppression</h3>
            <p class="text-gray-500 mb-6">Êtes-vous sûr de vouloir supprimer ce cours ? Cette action est irréversible.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()"
                        class="px-6 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </button>
                <!-- PHP: href="delete_cours.php?id=<?php echo $id; ?>" -->
                <a id="deleteLink" href="#"
                   class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Supprimer
                </a>
            </div>
        </div>
    </div>
</div>

<script src="./script.js"></script>
</body>
</html>

