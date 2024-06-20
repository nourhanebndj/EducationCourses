<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'admin';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['AdminLoginId'])) {
    header("Location: ./Authentification/Connexion_admin.php");
    exit();
}

$con = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <!-- Remixicon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Custom JS -->
    <script src="../js/scripts.js"></script>
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
                    <a href="../Dashboard.php" target="_blank">
                        <span class="material-icons-outlined">dashboard</span> Tableau de bord
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" onclick="toggleSubMenu('formations-sub-menu'); return false;">
                        <span class="material-icons-outlined">inventory_2</span> Formations
                    </a>
                    <ul id="formations-sub-menu" class="sub-menu" style="display: none;">
                        <li><a href="../formations/Formations.php" target="_blank">Voir les formations</a></li>
                        <li><a href="../formations/ajouter_formation.php" target="_blank">Ajouter les formations</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" onclick="toggleSubMenu('categories-sub-menu'); return false;">
                        <span class="material-icons-outlined">category</span> Catégories
                    </a>
                    <ul id="categories-sub-menu" class="sub-menu" style="display: none;">
                        <li><a href="../Categorie/allcategories.php" target="_blank">Voir les catégories</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-list-item">
                    <a href="../Membre/Membres.php" target="_blank">
                        <span class="material-icons-outlined">groups</span> Membres
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./commande/commande.php" target="_blank">
                        <span class="material-icons-outlined">fact_check</span> Commandes
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="../Authentification/Admins.php" target="_blank">
                        <span class="material-icons-outlined">person</span> Administrateurs
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="../Authentification/logout.php">
                        <span class="material-icons-outlined">logout</span> Déconnexion
                    </a>
                </li>

            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <main class="main-container">
            <div class="content-wrapper">
                <section class="content mt-4">
                    <div class="container-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-category">
                                    <div class="card-header">
                                        <h4>Catégories
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#categoryModal"
                                                class="btn btn-primary float-right">Ajouter</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nom de Catégorie</th>
                                                    <th>Description</th>
                                                    <th>Date de création</th>
                                                    <th>Modifier</th>
                                                    <th>Supprimer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                    $query = "SELECT * FROM catégories";
                                    $query_run = mysqli_query($con, $query);
                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $catitem) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $catitem['Id_categorie']; ?></td>
                                                    <td><?php echo $catitem['nomcategorie']; ?></td>
                                                    <td><?php echo $catitem['descriptioncategorie']; ?></td>
                                                    <td><?php echo $catitem['jour_creation']; ?></td>
                                                    <td>
                                                        <a href="../Categorie/edit_categories.php?Id_categorie=<?= $catitem['Id_categorie']; ?>"
                                                            class="btn btn-success">Modifier</a>

                                                    </td>
                                                    <td>
                                                        <form action="Addcategories.php" method="POST">
                                                            <input type="hidden" name="cate_delete_id"
                                                                value="<?= $catitem['Id_categorie']; ?>">
                                                            <button type="submit" name="cate_delete_btn"
                                                                class="btn btn-danger">Supprimer</button>
                                                        </form>
                                                    </td>


                                                </tr>
                                                <?php
                                        }
                                    } else {
                                        echo "Pas de catégorie trouvée";
                                    }
                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une catégorie</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="Addcategories.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nomcategorie">Nom de catégorie</label>
                            <input type="text" name="nomcategorie" class="form-control" id="nomcategorie" required>
                        </div>
                        <div class="form-group">
                            <label for="descriptioncategorie">Description</label>
                            <input type="text" name="descriptioncategorie" class="form-control"
                                id="descriptioncategorie" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="category_save" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->

</body>

</html>