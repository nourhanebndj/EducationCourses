<?php
require_once '../php/Connexion_bdd.php'; 
session_start();

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Redirect if not logged in
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: espace_admin/Authentification/Connexion_admin.php");
    exit();
}

// Check for form submission
if(isset($_POST['ajouter-formation_btn'])) {
    echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>';

    if ($_FILES['images']['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $_FILES['images']['error']);
    }

    $Id_categorie = $_POST['Id_categorie'];
    $nom_formation = $_POST['nom_formation'];
    $description = $_POST['description'];
    $Prix = $_POST['Prix'];
    $Prix_Promotion = $_POST['Prix_Promotion'];

    $images = $_FILES['images']['name'];
    $path = "../uploads/";
    $image_ext = pathinfo($images, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;
    $target_file = $path . $filename;

    if(move_uploaded_file($_FILES['images']['tmp_name'], $target_file)) {
        $formation_query = "INSERT INTO formations (Id_categorie, nom_formation, description, Prix, Prix_Promotion, images, date_creation) 
        VALUES ('$Id_categorie', '$nom_formation', '$description', '$Prix', '$Prix_Promotion', '$filename', NOW())";
        $formation_query_run = mysqli_query($con, $formation_query);

        if ($formation_query_run) {
            $_SESSION['message'] = "Insertion réussie";
            header("Location: ../formations/Formations.php");
            exit();
        } else {
            echo "SQL Error: " . mysqli_error($con);
        }
    } else {
        echo "Failed to move uploaded file.";
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
        <!-- Ajouter une formation -->
        <div class="container-2">
            <div class="card-1">
                <div class="card-header">
                    <h4>Ajouter une formation</h4>
                </div>
                <div class="card-body-1">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"
                        enctype="multipart/form-data">
                        <!-- Categories and  Nom de Formation  -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="category-input">Choisissez catégorie</label>
                                <select id="category-input" name="Id_categorie" class="form-control" required>
                                    <?php
                $query = "SELECT Id_categorie, nomcategorie FROM catégories";
                $result = $con->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['Id_categorie'] . "'>" . htmlspecialchars($row['nomcategorie'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                } else {
                    echo "<option value=''>No categories found</option>";
                }
                ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="formation-name">Nom de formation</label>
                                <input type="text" required id="formation-name" name="nom_formation"
                                    placeholder="Entrer Nom de formation" class="form-control">
                            </div>
                        </div>
                        <!-- Prix et prix de promotion -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Prix">Prix</label>
                                <input type="text" required id="Prix" name="Prix" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="Prix_Promotion">Promotion(optionnelle)</label>
                                <input type="text" id="Prix_Promotion" name="Prix_Promotion" class="form-control">
                            </div>
                        </div>

                        <!-- Description and Image Upload -->
                        <div class="col-md-6">
                            <label for="formation-description">Description</label>
                            <textarea type="text" required id="formation-description" name="description"
                                placeholder="Entrer une description" class="form-control"
                                oninput="autoGrowTextArea(this)" style="overflow:hidden;"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="formation-image">Upload Image</label>
                            <input type="file" required id="formation-image" name="images" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary" name="ajouter-formation_btn">Ajouter la
                            formation</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>