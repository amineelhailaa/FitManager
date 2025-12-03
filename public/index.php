<?php
include("connection/connect.php")
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GymManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-600 text-white">
            <i class="fas fa-chart-pie w-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="cours.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
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
            <h2 class="text-3xl font-bold text-gray-800">Tableau de bord</h2>
            <p class="text-gray-500 mt-1">Bienvenue dans votre espace de gestion</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-gray-600">Admin</span>
            <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold">
                A
            </div>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Cours -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Cours</p>
                    <!-- PHP: <?php echo $total_cours; ?> -->
                    <p class="text-3xl font-bold text-gray-800 mt-1">12</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-emerald-600 text-sm mt-3">
                <i class="fas fa-arrow-up"></i> +3 ce mois
            </p>
        </div>

        <!-- Total Équipements -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Équipements</p>
                    <!-- PHP: <?php echo $total_equipements; ?> -->
                    <p class="text-3xl font-bold text-gray-800 mt-1">45</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dumbbell text-emerald-600 text-xl"></i>
                </div>
            </div>
            <p class="text-emerald-600 text-sm mt-3">
                <i class="fas fa-arrow-up"></i> +5 ce mois
            </p>
        </div>

        <!-- Équipements en bon état -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">En bon état</p>
                    <!-- PHP: <?php echo $equipements_bon; ?> -->
                    <p class="text-3xl font-bold text-gray-800 mt-1">38</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-gray-500 text-sm mt-3">84% du total</p>
        </div>

        <!-- À remplacer -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">À remplacer</p>
                    <!-- PHP: <?php echo $equipements_remplacer; ?> -->
                    <p class="text-3xl font-bold text-gray-800 mt-1">3</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
            <p class="text-red-600 text-sm mt-3">
                <i class="fas fa-arrow-up"></i> Action requise
            </p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Répartition des Cours -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Répartition des Cours par Catégorie</h3>
            <div class="h-64">
                <canvas id="coursChart"></canvas>
            </div>
        </div>

        <!-- Répartition des Équipements -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Répartition des Équipements par Type</h3>
            <div class="h-64">
                <canvas id="equipementsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- État des Équipements Chart -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">État des Équipements</h3>
        <div class="h-64">
            <canvas id="etatChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Prochains Cours -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Prochains Cours</h3>
            <div class="space-y-4">
                <!-- PHP: foreach($prochains_cours as $cours): -->
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-running text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Yoga Matinal</p>
                        <p class="text-sm text-gray-500">Aujourd'hui, 08:00</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">Yoga</span>
                </div>

                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Cardio Intense</p>
                        <p class="text-sm text-gray-500">Aujourd'hui, 10:00</p>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Cardio</span>
                </div>

                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dumbbell text-orange-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Musculation</p>
                        <p class="text-sm text-gray-500">Demain, 14:00</p>
                    </div>
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Musculation</span>
                </div>
                <!-- PHP: endforeach; -->
            </div>
        </div>

        <!-- Équipements à surveiller -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Équipements à surveiller</h3>
            <div class="space-y-4">
                <!-- PHP: foreach($equipements_surveiller as $equip): -->
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tools text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Tapis de course #3</p>
                        <p class="text-sm text-gray-500">Quantité: 2</p>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">À remplacer</span>
                </div>

                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tools text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Vélo elliptique #2</p>
                        <p class="text-sm text-gray-500">Quantité: 1</p>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Moyen</span>
                </div>

                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tools text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Haltères 10kg</p>
                        <p class="text-sm text-gray-500">Quantité: 4</p>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Moyen</span>
                </div>
                <!-- PHP: endforeach; -->
            </div>
        </div>
    </div>
</main>

<script src="script.js"></script>
<script>
    // Charts initialization
    // Répartition des cours par catégorie
    const coursCtx = document.getElementById('coursChart').getContext('2d');
    new Chart(coursCtx, {
        type: 'doughnut',
        data: {
            labels: ['Yoga', 'Cardio', 'Musculation', 'Pilates', 'CrossFit'],
            // PHP: labels and data from database
            datasets: [{
                data: [4, 3, 3, 1, 1],
                backgroundColor: [
                    '#3B82F6',
                    '#EF4444',
                    '#F97316',
                    '#8B5CF6',
                    '#10B981'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Répartition des équipements par type
    const equipCtx = document.getElementById('equipementsChart').getContext('2d');
    new Chart(equipCtx, {
        type: 'bar',
        data: {
            labels: ['Tapis de course', 'Vélos', 'Haltères', 'Ballons', 'Tapis yoga'],
            // PHP: labels and data from database
            datasets: [{
                label: 'Quantité',
                data: [8, 6, 15, 10, 6],
                backgroundColor: '#10B981',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // État des équipements
    const etatCtx = document.getElementById('etatChart').getContext('2d');
    new Chart(etatCtx, {
        type: 'pie',
        data: {
            labels: ['Bon', 'Moyen', 'À remplacer'],
            // PHP: data from database
            datasets: [{
                data: [38, 4, 3],
                backgroundColor: [
                    '#10B981',
                    '#F59E0B',
                    '#EF4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
</body>
</html>
