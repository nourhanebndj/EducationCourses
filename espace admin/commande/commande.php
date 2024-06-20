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
    <!-- Custom JS -->
    <script src="../js/scripts.js"></script>
    <style>
    /* Style pour le formulaire de mise à jour de l'état des commandes */
    .update-form {
        display: flex;
        align-items: center;
    }

    .update-form select {
        padding: 5px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
        transition: border-color 0.3s;
    }

    .update-form select:focus {
        border-color: #007bff;
    }

    .update-form button {
        padding: 5px 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    .update-form button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    </style>
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
                    <a href="../commande/commande.php" target="_blank">
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

        <!-- Afficher les Commandes -->
        <main class="main-container">
            <div class="content-wrapper">
                <section class="content mt-4">
                    <div class="card-category">
                        <div class="card-header">
                            <h4>Commandes</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Id commande</th>
                                        <th>Id Membre</th>

                                        <th>Nom de formation</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Téléphone</th>
                                        <th>Email</th>
                                        <th>Etat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT commande.id, commande.nom, commande.prenom, commande.telephone, commande.email, commande.etat, commande.date_commande, commande.Id_membre, formations.nom_formation 
                                              FROM commande 
                                              JOIN formations ON commande.Id_formations = formations.Id_formations";
                                    $query_run = mysqli_query($con, $query);
                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $commande) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($commande['date_commande']); ?></td>
                                        <td><?php echo htmlspecialchars($commande['id']); ?></td>
                                        <td><?php echo htmlspecialchars($commande['Id_membre']); ?></td>

                                        <td><?php echo htmlspecialchars($commande['nom_formation']); ?></td>
                                        <td><?php echo htmlspecialchars($commande['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($commande['prenom']); ?></td>
                                        <td><?php echo htmlspecialchars($commande['telephone']); ?></td>
                                        <td><?php echo htmlspecialchars($commande['email']); ?></td>
                                        <td>
                                            <?php if ($commande['etat'] == 'terminée') : ?>
                                            <i class="fa fa-check" style="color: green;"></i>
                                            <?php elseif ($commande['etat'] == 'rejetée') : ?>
                                            <i class="fa fa-times" style="color: red;"></i>
                                            <?php else : ?>
                                            <i class="fa-solid fa-hourglass-end" style="color: gray;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form method="POST" action="update_etat.php" class="update-form">
                                                <input type="hidden" name="commande_id"
                                                    value="<?php echo htmlspecialchars($commande['id']); ?>">
                                                <select name="etat">
                                                    <option value="en_attente"
                                                        <?php echo ($commande['etat'] == 'en_attente') ? 'selected' : ''; ?>>
                                                        En attente</option>
                                                    <option value="terminée"
                                                        <?php echo ($commande['etat'] == 'terminée') ? 'selected' : ''; ?>>
                                                        Terminée</option>
                                                    <option value="rejetée"
                                                        <?php echo ($commande['etat'] == 'rejetée') ? 'selected' : ''; ?>>
                                                        Rejetée</option>
                                                </select>
                                                <button type="submit">Valider</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>Pas de commande trouvée</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
    </div>
    </section>
    </div>
    </main>
    </div>

</body>

</html>