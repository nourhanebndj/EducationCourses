<?php
require_once '../php/Connexion_bdd.php'; 
session_start();

if (!isset($_SESSION['AdminLoginId'])) {
    header("location: Connexion_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Liens -->
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
                    <a href="./Authentification/Profil.php" target="_blank">
                        <span class="material-icons-outlined">dashboard</span> Tableau de bord
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" onclick="toggleSubMenu('formations-sub-menu'); return false;">
                        <span class="material-icons-outlined">inventory_2</span> Formations
                    </a>
                    <ul id="formations-sub-menu" class="sub-menu" style="display: none;">
                        <li><a href="./Formations/Formations.php" target="_blank">Voir les formations</a></li>
                        <li><a href="./AddFormation.php" target="_blank">Ajouter les formations</a></li>
                    </ul>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" onclick="toggleSubMenu('categories-sub-menu'); return false;">
                        <span class="material-icons-outlined">category</span> Catégories
                    </a>
                    <ul id="categories-sub-menu" class="sub-menu" style="display: none;">
                        <li><a href="./Categorie/Addcategories.php" target="_blank">Voir les catégories</a>
                        </li>

                        <li><a href="./Categorie/Addcategories.php" target="_blank">Ajouter une catégorie</a></li>
                    </ul>
                </li>

                <li class="sidebar-list-item">
                    <a href="./Membres.php" target="_blank">
                        <span class="material-icons-outlined">groups</span> Membres
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">fact_check</span> Commandes
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Profil.php" target="_blank">
                        <span class="material-icons-outlined">person</span> Profile
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="logout.php">
                        <span class="material-icons-outlined">logout</span> Déconnexion
                    </a>
                </li>

            </ul>
        </aside>
        <!-- End Sidebar -->
        <!-- Afficher les  Administrateurs -->
        <main class="main-container">
            <div class="content-wrapper">
                <section class="content mt-4">
                    <div class="card-category">
                        <div class="card-header">
                            <h4>Administrateurs
                                <a href="#" data-bs-toggle="modal" data-bs-target="#categoryModal"
                                    class="btn btn-primary float-right">Ajouter</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom de l'admin</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM admin_login";
                                    $query_run = mysqli_query($con, $query);
                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $catitem) {
                                            ?>
                                    <tr>
                                        <td><?php echo $catitem['Id_admin']; ?></td>
                                        <td><?php echo $catitem['Admin_Name']; ?></td>

                                        <td>
                                            <form action="delete_admin.php" method="POST">
                                                <input type="hidden" name="admin_delete_id"
                                                    value="<?= $catitem['Id_admin']; ?>">
                                                <button type="submit" name="admin_delete_btn"
                                                    class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "Pas d'admin' trouvée";
                                    }
                                    ?>

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

    <!-- Admin Add Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="Add_admin.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Admin_Name">Nom de l'admin</label>
                            <input type="text" class="form-control" id="Admin_Name" name="Admin_Name" required>
                        </div>
                        <div class="form-group">
                            <label for="Admin_password">Mot de passe</label>
                            <input type="password" class="form-control" id="Admin_password" name="Admin_password"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="admin_save" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->

</body>
</div>
</body>

</html>