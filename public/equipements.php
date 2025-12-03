<?php
global $connection;
include("../connection/connect.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST["nom_equipement"];
    $type=$_POST["type"];
    $qte = $_POST["qte"];
    $etat=$_POST["etat"];

    $toPush = "INSERT INTO equipements (nom_equipement,type,qte,etat) values ('$name','$type','$qte','$etat') ";

    if(mysqli_query($connection, $toPush)){
        header('location:equipements.php');
        exit();
    }

}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Équipements - GymManager</title>
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
        <a href="cours.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-calendar-alt w-5"></i>
            <span>Cours</span>
        </a>
        <a href="equipements.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-600 text-white">
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
            <h2 class="text-3xl font-bold text-gray-800">Gestion des Équipements</h2>
            <p class="text-gray-500 mt-1">Gérez votre inventaire d'équipements</p>
        </div>
        <button onclick="openEquipModal('add')" class="flex items-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition">
            <i class="fas fa-plus"></i>
            <span>Nouvel Équipement</span>
        </button>
    </header>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <!-- Search -->
            <div class="flex-1 min-w-64">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchEquip" placeholder="Rechercher un équipement..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Type Filter -->
            <div>
                <select id="typeFilter" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Tous les types</option>
                    <option value="Tapis de course">Tapis de course</option>
                    <option value="Vélo">Vélo</option>
                    <option value="Haltères">Haltères</option>
                    <option value="Ballon">Ballon</option>
                    <option value="Tapis yoga">Tapis yoga</option>
                    <option value="Machine">Machine</option>
                </select>
            </div>

            <!-- State Filter -->
            <div>
                <select id="etatFilter" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Tous les états</option>
                    <option value="bon">Bon</option>
                    <option value="moyen">Moyen</option>
                    <option value="à remplacer">À remplacer</option>
                </select>
            </div>

            <!-- Export Button -->
            <a href="export.php?type=equipements" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-download text-gray-600"></i>
                <span>Exporter CSV</span>
            </a>
        </div>
    </div>

    <!-- Equipment Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="equipementGrid">
        <!-- PHP: foreach($equipements as $e): -->

        <!-- Card 1 - Bon état -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                <i class="fas fa-running text-white text-5xl opacity-80"></i>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-gray-800">Tapis de course Pro</h3>
                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Bon</span>
                </div>
                <p class="text-sm text-gray-500 mb-3">Type: Tapis de course</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400"></i>
                        <span class="text-sm text-gray-600">Qté: 8</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEquipModal('edit', 1)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteEquip(1)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 - Moyen état -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                <i class="fas fa-biking text-white text-5xl opacity-80"></i>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-gray-800">Vélo elliptique</h3>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Moyen</span>
                </div>
                <p class="text-sm text-gray-500 mb-3">Type: Vélo</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400"></i>
                        <span class="text-sm text-gray-600">Qté: 6</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEquipModal('edit', 2)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteEquip(2)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 - À remplacer -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                <i class="fas fa-dumbbell text-white text-5xl opacity-80"></i>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-gray-800">Haltères 10kg</h3>
                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">À remplacer</span>
                </div>
                <p class="text-sm text-gray-500 mb-3">Type: Haltères</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400"></i>
                        <span class="text-sm text-gray-600">Qté: 4</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEquipModal('edit', 3)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteEquip(3)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                <i class="fas fa-futbol text-white text-5xl opacity-80"></i>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-gray-800">Ballon fitness</h3>
                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Bon</span>
                </div>
                <p class="text-sm text-gray-500 mb-3">Type: Ballon</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400"></i>
                        <span class="text-sm text-gray-600">Qté: 10</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEquipModal('edit', 4)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteEquip(4)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                <i class="fas fa-spa text-white text-5xl opacity-80"></i>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-gray-800">Tapis de yoga</h3>
                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Bon</span>
                </div>
                <p class="text-sm text-gray-500 mb-3">Type: Tapis yoga</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400"></i>
                        <span class="text-sm text-gray-600">Qté: 15</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEquipModal('edit', 5)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteEquip(5)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                <i class="fas fa-weight text-white text-5xl opacity-80"></i>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-gray-800">Machine pectoraux</h3>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Moyen</span>
                </div>
                <p class="text-sm text-gray-500 mb-3">Type: Machine</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400"></i>
                        <span class="text-sm text-gray-600">Qté: 2</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEquipModal('edit', 6)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteEquip(6)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- PHP: endforeach; -->
    </div>
</main>

<!-- Modal for Add/Edit Equipment -->
<div id="equipModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <h3 id="equipModalTitle" class="text-xl font-semibold text-gray-800">Ajouter un équipement</h3>
            <button onclick="closeEquipModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="equipForm" class="p-6 space-y-4" method="post" action="equipements.php">
            <input type="hidden" id="equipId" name="id_equipement">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'équipement *</label>
                <input type="text" id="nomEquip" name="nom_equipement" required
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                       placeholder="Ex: Tapis de course Pro">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                <select id="typeEquip" name="type" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Sélectionner un type</option>
                    <option value="Tapis de course">Tapis de course</option>
                    <option value="Vélo">Vélo</option>
                    <option value="Haltères">Haltères</option>
                    <option value="Ballon">Ballon</option>
                    <option value="Tapis yoga">Tapis yoga</option>
                    <option value="Machine">Machine</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantité *</label>
                    <input type="number" id="qteEquip" name="qte" required min="0"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="10">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">État *</label>
                    <select id="etatEquip" name="etat" required
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Sélectionner un état</option>
                        <option value="bon">Bon</option>
                        <option value="moyen">Moyen</option>
                        <option value="à remplacer">À remplacer</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeEquipModal()"
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
<div id="deleteEquipModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md mx-4 p-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Confirmer la suppression</h3>
            <p class="text-gray-500 mb-6">Êtes-vous sûr de vouloir supprimer cet équipement ? Cette action est irréversible.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteEquipModal()"
                        class="px-6 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </button>
                <!-- PHP: href="delete_equipement.php?id=<?php echo $id; ?>" -->
                <a id="deleteEquipLink" href="#"
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

