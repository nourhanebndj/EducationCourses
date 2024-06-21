<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/espace admin/php/Connexion_bdd.php'; 
session_start();

// Récupération des catégories
$categories = [];
$queryCategories = "SELECT * FROM catégories";
$resultCategories = mysqli_query($con, $queryCategories);
if ($resultCategories) {
    while ($row = mysqli_fetch_assoc($resultCategories)) {
        $categories[] = $row;
    }
} else {
    error_log('Erreur lors de la récupération des catégories: ' . mysqli_error($con));
}

$Id_categorie = isset($_GET['Id_categorie']) ? intval($_GET['Id_categorie']) : 0;
$queryFormations = "SELECT f.Id_formations, f.images, f.nom_formation, c.nomcategorie, f.description, f.Prix, f.Prix_Promotion 
                     FROM formations f 
                     JOIN catégories c ON f.Id_categorie = c.Id_categorie 
                     WHERE f.Id_categorie = ?";
$stmt = $con->prepare($queryFormations);
$stmt->bind_param('i', $Id_categorie);  
$stmt->execute();
$resultFormations = $stmt->get_result();

$formations = [];
if ($resultFormations) {
    while ($row = mysqli_fetch_assoc($resultFormations)) {
        $formations[] = $row;
    }
} else {
    error_log('Erreur lors de la récupération des formations: ' . mysqli_error($con));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== Liens ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!--===============  Chemins CSS ===============-->
    <link rel="stylesheet" href="../css/style.css">

    <title>Coursera</title>
</head>

<body>
    <!--=============== HEADER ===============-->
    <header class="header">
        <nav class="nav container">
            <div class="nav__data">
                <a href="#" class="nav__logo">
                    <i class="ri-book-line"></i> Education
                </a>
                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line nav__burger"></i>
                    <i class="ri-close-line nav__close"></i>
                </div>
            </div>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li><a href="../pages/home.php" class="nav__link"><i class="ri-home-line"></i> Accueil</a></li>
                    <li><a href="../pages/A_propos.php" class="nav__link"><i class="ri-information-line"></i> À
                            propos</a></li>
                    <li class="dropdown__item">
                        <a href="../formations/formations.php" class="nav__link">
                            Formations <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </a>
                        <ul class="dropdown__menu">
                            <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="../formations/formations_categories.php?Id_categorie=<?php echo htmlspecialchars($category['Id_categorie']); ?>"
                                    class="dropdown__link"><?php echo htmlspecialchars($category['nomcategorie']); ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li><a href="../pages/contact.php" class="nav__link"><i class="ri-contacts-line"></i>
                            Contactez-nous</a></li>
                    <li><a href="../authentification/se_connecter.php" class="nav__link"><i class="ri-user-2-line"></i>
                            Se
                            connecter</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="formations">
        <?php foreach ($formations as $formation): ?>
        <div class="card-formation">
            <img src="../espace admin/uploads/<?php echo htmlspecialchars($formation['images']); ?>"
                alt="<?php echo htmlspecialchars($formation['nom_formation']); ?>">
            <h5><?php echo htmlspecialchars($formation['nom_formation']); ?></h5>
            <p><?php echo htmlspecialchars($formation['nomcategorie']); ?></p>
            <?php if (!empty($formation['Prix_Promotion'])): ?>
            <h6><?php echo htmlspecialchars($formation['Prix']); ?> Da</h6>
            <p><?php echo htmlspecialchars($formation['Prix_Promotion']); ?> Da</p>
            <?php else: ?>
            <p><?php echo htmlspecialchars($formation['Prix']); ?> Da</p>
            <?php endif; ?>
            <a href="formation_detail.php?id=<?php echo htmlspecialchars($formation['Id_formations']); ?>"
                class="buy-button">S'inscrire à la formation</a>
        </div>
        <?php endforeach; ?>
    </section>

</body>
<!--=============== Footer ===============-->

<footer>
    <div class="footer-content">
        <div class="footer-logo">
            <a href="#" class="logo">
                <i class="ri-book-line"></i>Education
            </a>

        </div>
        <div class="social-links">
            <a href="https://twitter.com" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="https://facebook.com" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com" class="social-icon"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</footer>

</html>