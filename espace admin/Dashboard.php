<?php
define('BASE_URL', 'http://educationdz.free.nf)/');

require_once $_SERVER['DOCUMENT_ROOT'] . '../espace_utilisateur/php/Connexion_user.php'; 

// Connexion à la base de données 'admin' pour les catégories
$con_admin = mysqli_connect("localhost", "root", "", "admin");
if (mysqli_connect_error()) {
    echo "Erreur de connexion à la base de donnée 'admin'";
    exit();
}

// Connexion à la base de données 'education' pour les membres et les formations
$con_education = mysqli_connect("localhost", "root", "", "education");
if (mysqli_connect_error()) {
    echo "Erreur de connexion à la base de donnée 'education'";
    exit();
}


session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("location:./Authentification/Connexion_admin.php");
    exit();
}

// Nombre de catégories
$total_categories = 0;
$query_categories = "SELECT COUNT(*) as total_categories FROM catégories"; // Vérifiez le nom correct de la table
$result_categories = mysqli_query($con_admin, $query_categories);
if ($result_categories) {
    $row_categories = mysqli_fetch_assoc($result_categories);
    if ($row_categories) {
        $total_categories = $row_categories['total_categories'];
    }
} else {
    echo 'Erreur lors de l\'exécution de la requête pour les catégories : ' . mysqli_error($con_admin);
}
// Nombre de commande
$total_commande = 0;
$query_commande = "SELECT COUNT(*) as total_commande FROM commande"; 
$result_commande = mysqli_query($con_admin, $query_commande);
if ($result_commande) {
    $row_commande = mysqli_fetch_assoc($result_commande);
    if ($row_commande) {
        $total_commande = $row_commande['total_commande'];
    }
} else {
    echo 'Erreur lors de l\'exécution de la requête pour les commandes : ' . mysqli_error($con_admin);
}
// Nombre de formations
$total_formations = 0;
$query_formations = "SELECT COUNT(*) as total_formations FROM formations"; // Vérifiez le nom correct de la table
$result_formations = mysqli_query($con_admin, $query_formations);
if ($result_formations) {
    $row_formations = mysqli_fetch_assoc($result_formations);
    if ($row_formations) {
        $total_formations = $row_formations['total_formations'];
    }
} else {
    echo 'Erreur lors de l\'exécution de la requête pour les formations : ' . mysqli_error($con_admin);
}
// Nombre de membres
$total_members = 0;
$query_members = "SELECT COUNT(*) as total_members FROM membre";
$result_members = mysqli_query($con_education, $query_members);
if ($result_members) {
    $row_members = mysqli_fetch_assoc($result_members);
    if ($row_members) {
        $total_members = $row_members['total_members'];
    }
} else {
    echo 'Erreur lors de l\'exécution de la requête pour les membres : ' . mysqli_error($con_education);
}

// Fermer les connexions
mysqli_close($con_admin);
mysqli_close($con_education);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Liens -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/admin.css">
</head>

<body>
    <div class="grid-container">

        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>

            <div class="header-right">
                <span class="material-icons-outlined">account_circle</span>
                <h1>Welcome -<?php echo $_SESSION['AdminLoginId'] ?></h1>
            </div>

        </header>
        <!-- End Header -->

        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <a href="#" class="nav__logo">
                        <i class="ri-book-line"></i>Education</a>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="./Dashboard.php" target="_blank">
                        <span class="material-icons-outlined">dashboard</span> Tableau de bord
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" onclick="toggleSubMenu('formations-sub-menu'); return false;">
                        <span class="material-icons-outlined">inventory_2</span> Formations
                    </a>
                    <ul id="formations-sub-menu" class="sub-menu" style="display: none;">
                        <li><a href="./formations/Formations.php" target="_blank">Voir les formations</a></li>
                        <li><a href="./formations/ajouter_formation.php" target="_blank">Ajouter les formations</a></li>
                    </ul>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" onclick="toggleSubMenu('categories-sub-menu'); return false;">
                        <span class="material-icons-outlined">category</span> Catégories
                    </a>
                    <ul id="categories-sub-menu" class="sub-menu" style="display: none;">
                        <li><a href="./Categorie/allcategories.php" target="_blank">Voir les catégories</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-list-item">
                    <a href="./Membre/Membres.php" target="_blank">
                        <span class="material-icons-outlined">groups</span> Membres
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./commande/commande.php" target="_blank">
                        <span class="material-icons-outlined">fact_check</span> Commandes
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Authentification/Admins.php" target="_blank">
                        <span class="material-icons-outlined">person</span> Administrateurs
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Authentification/logout.php">
                        <span class="material-icons-outlined">logout</span> Déconnexion
                    </a>
                </li>

            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main -->
        <main class="main-container">
            <div class="main-title">
                <h2>DASHBOARD</h2>
            </div>

            <div class="main-cards">

                <div class="card">
                    <div class="card-inner">
                        <h3>Formations</h3>
                        <span class="material-icons-outlined">inventory_2</span>
                    </div>
                    <h1><?php echo $total_formations;?></h1>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <h3>CATEGORIES</h3>
                        <span class="material-icons-outlined">category</span>
                    </div>
                    <h1><?php echo $total_categories; ?></h1>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>MEMBRES</h3>
                        <span class="material-icons-outlined">groups</span>
                    </div>
                    <h1><?php echo $total_members; ?></h1>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>Commandes</h3>
                        <span class="material-icons-outlined">notification_important</span>
                    </div>
                    <h1><?php echo $total_commande; ?></h1>
                </div>

            </div>

        </main>
        <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
</body>

</html>