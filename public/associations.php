<?php
//global $connection;
global $connection;
include('../connection/connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cours = $_POST['id_cours'];
    $equipement = $_POST['id_equipement'];
    $qte = $_POST['qteUsed'];



    mysqli_begin_transaction($connection);

    $modify = "update equipements set qte= qte-$qte where id_equipement= $equipement";
    $insert = "insert into cours_equipement (id_cours,id_equipement,quantity) values ('$cours','$equipement','$qte')";

    if (mysqli_query($connection, $insert) && mysqli_query($connection,$modify)) {
        mysqli_commit($connection);
        header('location:associations.php');
        exit();
    } else {
        mysqli_rollback($connection);
        header('location:associations.php');
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associations Cours-Équipements - GymManager</title>
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
        <a href="index.php"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-chart-pie w-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="cours.php"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-calendar-alt w-5"></i>
            <span>Cours</span>
        </a>
        <a href="equipements.php"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fas fa-dumbbell w-5"></i>
            <span>Équipements</span>
        </a>
        <a href="associations.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-600 text-white">
            <i class="fas fa-link w-5"></i>
            <span>Associations</span>
        </a>
    </nav>

    <div class="absolute bottom-6 left-6 right-6">
        <a href="login.php"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
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
            <h2 class="text-3xl font-bold text-gray-800">Associations Cours-Équipements</h2>
            <p class="text-gray-500 mt-1">Liez les équipements aux cours</p>
        </div>
        <button onclick="openAssocModal()"
                class="flex items-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition">
            <i class="fas fa-plus"></i>
            <span>Nouvelle Association</span>
        </button>
    </header>

    <!-- Filters -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <!-- Filter by Course -->
            <div class="flex-1 min-w-48">
                <select id="filterCours"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Filtrer par cours</option>
                    <!-- PHP: foreach($cours as $c): -->
                    <option value="2">Yoga Matinal</option>
                    <option value="2">Cardio Intense</option>
                    <option value="3">Musculation Débutant</option>
                    <option value="4">Pilates Relaxation</option>
                    <option value="5">CrossFit Challenge</option>
                    <!-- PHP: endforeach; -->
                </select>
            </div>

            <!-- Filter by Equipment -->
            <div class="flex-1 min-w-48">
                <select id="filterEquip"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Filtrer par équipement</option>
                    <!-- PHP: foreach($equipements as $e): -->
                    <option value="1">Tapis de course Pro</option>
                    <option value="2">Vélo elliptique</option>
                    <option value="3">Haltères 10kg</option>
                    <option value="4">Ballon fitness</option>
                    <option value="5">Tapis de yoga</option>
                    <!-- PHP: endforeach; -->
                </select>
            </div>

            <!-- Export Button -->
            <a href="export.php?type=associations"
               class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-download text-gray-600"></i>
                <span>Exporter CSV</span>
            </a>
        </div>
    </div>

    <!-- Associations Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Cours</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Catégorie</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Équipement</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Type</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">État</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-gray-600">Action</th>
            </tr>
            </thead>
            <tbody id="assocTableBody">
            <?php
            $query_show = "select * from cours_equipement left join cours on cours_equipement.id_cours=cours.id_cours left join equipements on cours_equipement.id_equipement=equipements.id_equipement";
            $queryS = mysqli_query($connection, $query_show);
            while ($eachRow = mysqli_fetch_assoc($queryS)) {
                ?>
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-spa text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-800"><?php echo $eachRow['nom_cours'] ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm"><?php echo $eachRow['categorie'] ?></span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800"><?php echo $eachRow['nom_equipement'] ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo $eachRow['type'] ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm"><?php echo $eachRow['etat'] ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center">
                            <button onclick="confirmDeleteAssoc(<?php echo $eachRow['id_cours'] . "," . $eachRow['id_equipement'] ?>)"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Délier">
                                <i class="fas fa-unlink"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <!--            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex items-center gap-3">-->
            <!--                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">-->
            <!--                            <i class="fas fa-heartbeat text-red-600"></i>-->
            <!--                        </div>-->
            <!--                        <span class="font-medium text-gray-800">Cardio Intense</span>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Cardio</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4 font-medium text-gray-800">Tapis de course Pro</td>-->
            <!--                <td class="px-6 py-4 text-gray-600">Tapis de course</td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm">Bon</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex justify-center">-->
            <!--                        <button onclick="confirmDeleteAssoc(2, 1)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Délier">-->
            <!--                            <i class="fas fa-unlink"></i>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--            </tr>-->
            <!---->
            <!--            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex items-center gap-3">-->
            <!--                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">-->
            <!--                            <i class="fas fa-heartbeat text-red-600"></i>-->
            <!--                        </div>-->
            <!--                        <span class="font-medium text-gray-800">Cardio Intense</span>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Cardio</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4 font-medium text-gray-800">Vélo elliptique</td>-->
            <!--                <td class="px-6 py-4 text-gray-600">Vélo</td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Moyen</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex justify-center">-->
            <!--                        <button onclick="confirmDeleteAssoc(2, 2)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Délier">-->
            <!--                            <i class="fas fa-unlink"></i>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--            </tr>-->
            <!---->
            <!--            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex items-center gap-3">-->
            <!--                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">-->
            <!--                            <i class="fas fa-dumbbell text-orange-600"></i>-->
            <!--                        </div>-->
            <!--                        <span class="font-medium text-gray-800">Musculation Débutant</span>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Musculation</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4 font-medium text-gray-800">Haltères 10kg</td>-->
            <!--                <td class="px-6 py-4 text-gray-600">Haltères</td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">À remplacer</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex justify-center">-->
            <!--                        <button onclick="confirmDeleteAssoc(3, 3)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Délier">-->
            <!--                            <i class="fas fa-unlink"></i>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--            </tr>-->
            <!---->
            <!--            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex items-center gap-3">-->
            <!--                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">-->
            <!--                            <i class="fas fa-child text-purple-600"></i>-->
            <!--                        </div>-->
            <!--                        <span class="font-medium text-gray-800">Pilates Relaxation</span>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">Pilates</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4 font-medium text-gray-800">Ballon fitness</td>-->
            <!--                <td class="px-6 py-4 text-gray-600">Ballon</td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm">Bon</span>-->
            <!--                </td>-->
            <!--                <td class="px-6 py-4">-->
            <!--                    <div class="flex justify-center">-->
            <!--                        <button onclick="confirmDeleteAssoc(4, 4)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Délier">-->
            <!--                            <i class="fas fa-unlink"></i>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--            </tr>-->
            <!-- PHP: endforeach; -->
            </tbody>
        </table>
    </div>
</main>

<!-- Modal for Add Association -->
<div id="assocModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-semibold text-gray-800">Associer un équipement à un cours</h3>
            <button onclick="closeAssocModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="assocForm" class="p-6 space-y-4" method="post">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cours *</label>
                <select id="assocCours" name="id_cours" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Sélectionner un cours</option>
                    <?php
                    $query = "SELECT * FROM cours";
                    $result = mysqli_query($connection, $query);
                    while ($row1 = mysqli_fetch_assoc($result)) {
                        echo "<option value=" . $row1['id_cours'] . ">" . $row1['nom_cours'] . "</option>";
                    }
                    ?>
                    <!--                    <option value=13 >Yoga Matinal</option>-->
                    <!--                    <option value=14>Cardio Intense</option>-->
                    <!--                    <option value="3">Musculation Débutant</option>-->
                    <!--                    <option value="4">Pilates Relaxation</option>-->
                    <!--                    <option value="5">CrossFit Challenge</option>-->
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Équipement *</label>
                <select id="assocEquip" name="id_equipement" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Sélectionner un équipement</option>
                    <?php
                    $query2 = "select * from equipements";
                    $sec = mysqli_query($connection, $query2);
                    while ($row2 = mysqli_fetch_assoc($sec)) {
                        echo "<option value=" . $row2['id_equipement'] . ">" . $row2['nom_equipement'] . "</option>";
                    }
                    ?>
                    <!--                    <option value=13 >Tapis de course Pro</option>-->
                    <!--                    <option value=14>Vélo elliptique</option>-->
                    <!--                    <option value="3">Haltères 10kg</option>-->
                    <!--                    <option value="4">Ballon fitness</option>-->
                    <!--                    <option value="5">Tapis de yoga</option>-->
                    <!--                    <option value="6">Machine pectoraux</option>-->
                    <!-- PHP: endforeach; -->
                </select>
            </div>

            <div class="flex flex-col">
                <label for="qteused" class="block text-sm font-medium text-gray-700 mb-1">Quantite *</label>
                <input id="qteused" name="qteUsed" required type="number"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAssocModal()"
                        class="px-6 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    Associer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteAssocModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md mx-4 p-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-unlink text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Confirmer la suppression</h3>
            <p class="text-gray-500 mb-6">Êtes-vous sûr de vouloir supprimer cette association ?</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteAssocModal()"
                        class="px-6 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </button>
                <!-- PHP: href="delete_association.php?id_cours=X&id_equipement=Y" -->
                <a id="deleteAssocLink" href="#"
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

