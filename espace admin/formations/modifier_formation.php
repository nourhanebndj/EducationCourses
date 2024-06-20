<?php
require_once '../php/Connexion_bdd.php'; 
session_start();

// Redirect if not logged in
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: espace_admin/Authentification/Connexion_admin.php");
    exit();
}

// Fetch formation data to edit
$formationId = isset($_GET['id']) ? $_GET['id'] : '';  // Get ID from URL
$formationData = null;

if ($formationId) {
    $query = "SELECT * FROM formations WHERE Id_formations = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $formationId);
    $stmt->execute();
    $result = $stmt->get_result();
    $formationData = $result->fetch_assoc();
}

// Check for form submission
if (isset($_POST['update-formation_btn'])) {
    $Id_categorie = $_POST['Id_categorie'];
    $nom_formation = $_POST['nom_formation'];
    $description = $_POST['description'];
    $Prix = $_POST['Prix'];
    $Prix_Promotion = $_POST['Prix_Promotion'];
    
    // Assume image remains the same if none is uploaded
    $images = $formationData['images'];
    if ($_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $image_name = $_FILES['images']['name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
        $path = "../uploads/";
        $target_file = $path . $filename;

        if(move_uploaded_file($_FILES['images']['tmp_name'], $target_file)) {
            $images = $filename;  // Update file name if upload succeeds
        }
    }

    // Update the formation
    $update_query = "UPDATE formations SET Id_categorie=?, nom_formation=?, description=?, Prix=?, Prix_Promotion=?, images=? WHERE Id_formations=?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("issddsi", $Id_categorie, $nom_formation, $description, $Prix, $Prix_Promotion, $images, $formationId);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Formation updated successfully.";
        header("Location: ../formations/Formations.php");
        exit();
    } else {
        echo "SQL Error: " . $stmt->error;
    }
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
    <!-- Custom JS -->
    <script src="../js/scripts.js"></script>
    <style>
    /* Styles pour les labels */
    label {
        display: block;
        color: #000;
        /* Texte en noir */
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 1rem;
        /* Taille de police */
    }

    /* Styles pour les champs de formulaire */
    .form-control {
        background-color: #fff;
        /* Fond blanc */
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        font-size: 1rem;
    }

    /* Espacement entre les lignes du formulaire */
    .row {
        margin-bottom: 15px;
    }

    textarea.form-control {
        height: 150px;
        resize: none;
        padding: 10px;
        border: 1px solid #ccc;
        width: 100%;
        box-sizing: border-box;
        font-size: 1rem;
        line-height: 1.5;
        overflow-y: auto;
        background-color: #fff;
        color: #000;
        text-align: left;
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
        <main class="main-container">
            <div class="content-wrapper">
                <div class="card-1">
                    <div class="card-header">
                        <h4>Modifier la formation</h4>
                    </div>
                    <div class="card-body-1">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $formationId; ?>"
                            method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="category-input">Choisissez catégorie</label>
                                    <select id="category-input" name="Id_categorie" class="form-control" required>
                                        <?php
                                        $cat_query = "SELECT Id_categorie, nomcategorie FROM catégories";
                                        $cat_result = $con->query($cat_query);
                                        while ($row = $cat_result->fetch_assoc()) {
                                            $selected = ($row['Id_categorie'] == $formationData['Id_categorie']) ? 'selected' : '';
                                            echo "<option value='" . $row['Id_categorie'] . "' $selected>" . htmlspecialchars($row['nomcategorie']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="formation-name">Nom de formation</label>
                                    <input type="text" id="formation-name" name="nom_formation"
                                        value="<?php echo htmlspecialchars($formationData['nom_formation'] ?? ''); ?>"
                                        required class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="Prix">Prix</label>
                                    <input type="text" id="Prix" name="Prix"
                                        value="<?php echo htmlspecialchars($formationData['Prix'] ?? ''); ?>" required
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="Prix_Promotion">Promotion (optionnelle)</label>
                                    <input type="text" id="Prix_Promotion" name="Prix_Promotion"
                                        value="<?php echo htmlspecialchars($formationData['Prix_Promotion'] ?? ''); ?>"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="formation-description">Description</label>
                                <textarea id="formation-description" name="description" required class="form-control"
                                    oninput="autoGrowTextArea(this)"
                                    style="overflow:hidden;"><?php echo htmlspecialchars($formationData['description'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="formation-image">Upload Image</label>
                                <input type="file" id="formation-image" name="images" class="form-control">
                            </div>
                            <button type="submit" name="update-formation_btn"
                                class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>