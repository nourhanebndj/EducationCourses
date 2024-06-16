<?php
require_once '../php/Connexion_bdd.php'; 
session_start();
if(!isset($_SESSION['AdminLoginId'])){
    header("location:./Authentification/Connexion_admin.php");
}
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
                    <a href="#" target="_blank">
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
                                        <h4>Formations
                                            <a href="../formations/ajouter_formation.php"
                                                class="btn btn-primary float-right">Ajouter</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>

                                                    <th>Id</th>
                                                    <th>Image</th>
                                                    <th>Nom de Formation</th>
                                                    <th>Catégorie</th>
                                                    <th>Description</th>
                                                    <th>Prix</th>
                                                    <th>Prix de promotion</th>
                                                    <th>Date de création</th>
                                                    <th>Modifier</th>
                                                    <th>Supprimer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT f.Id_formations, f.images, f.nom_formation, c.nomcategorie, f.description, f.Prix, f.Prix_Promotion, f.date_creation 
                                                          FROM formations f 
                                                          JOIN catégories c ON f.Id_categorie = c.Id_categorie";
                                                $query_run = mysqli_query($con, $query);
                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $item) {
                                                        ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['Id_formations']); ?></td>
                                                    <td><img src="../uploads/<?php echo htmlspecialchars($item['images']); ?>"
                                                            width="50px" height="50px"></td>
                                                    <td><?php echo htmlspecialchars($item['nom_formation']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['nomcategorie']); ?></td>
                                                    <td><?php echo htmlspecialchars(substr($item['description'], 0, 50)); ?>...
                                                    </td>
                                                    <td><?php echo htmlspecialchars($item['Prix']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['Prix_Promotion']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['date_creation']); ?></td>
                                                    <td><a href="modifier_formation.php?id=<?php echo $item['Id_formations']; ?>"
                                                            class="btn btn-success">Modifier</a></td>
                                                    <td>
                                                        <form action="delete.php" method="POST">
                                                            <input type="hidden" name="formation_delete_id"
                                                                value="<?php echo $item['Id_formations']; ?>">
                                                            <button type="button" class="btn btn-danger delete-btn"
                                                                data-id="<?php echo $item['Id_formations']; ?>">Supprimer</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10'>Pas de formations trouvées</td></tr>";
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
    <!-- The Modal -->
    <div id="deleteConfirmationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirmer la suppression</h2>
            <p>Êtes-vous sûr de vouloir supprimer cette formation ?</p>
            <div class="modal-actions">
                <button id="confirmDelete">Confirmer</button>
                <button id="cancelDelete">Annuler</button>
            </div>
        </div>
    </div>

</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('deleteConfirmationModal');
    var btns = document.querySelectorAll('.delete-btn');
    var closeBtn = document.querySelector('.close');
    var cancelBtn = document.getElementById('cancelDelete');
    var confirmBtn = document.getElementById('confirmDelete');

    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            modal.style.display = 'block';
            confirmBtn.dataset.id = btn.getAttribute(
                'data-id'); // Pass the ID to confirm button
        });
    });

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    };

    cancelBtn.onclick = function() {
        modal.style.display = 'none';
    };

    confirmBtn.onclick = function() {
        var id = this.dataset.id;
        console.log("Deleting ID:", id);
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
});
</script>



</html>