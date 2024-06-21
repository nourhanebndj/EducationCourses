<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/espace admin/php/Connexion_bdd.php';
session_start();

// Fetch categories from the database
$categories = [];
$query = "SELECT * FROM catégories";
$query_run = mysqli_query($con, $query);
if ($query_run) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $categories[] = $row;
    }
}


$formation = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $formationId = intval($_GET['id']);
    $query = "SELECT f.Id_formations, f.images, f.nom_formation, c.nomcategorie, f.description, f.Prix, f.Prix_Promotion, f.date_creation 
              FROM formations f 
              JOIN catégories c ON f.Id_categorie = c.Id_categorie 
              WHERE f.Id_formations = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $formationId);
    $stmt->execute();
    $result = $stmt->get_result();
    $formation = $result->fetch_assoc();
} else {

    echo "Invalid formation ID.";
    exit;
}

if (!$formation) {
    echo "Formation not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coursera</title>

    <!--=============== Liens ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!--===============  Chemins CSS ===============-->
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js" defer></script>
    <style>
    .category {
        font-size: 14px;

        color: #555;
    }
    </style>
</head>

<body>
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
    <section class="row">
        <div class="img-holder">
            <img src="../<?php echo htmlspecialchars($formation['images']); ?>" class="img"
                alt="<?php echo htmlspecialchars($formation['nom_formation']); ?>" />
        </div>
        <div class="product-details-holder">

            <h1 class="product-name"><?php echo htmlspecialchars($formation['nom_formation']); ?></h1>
            <p><strong>Catégorie:</strong> <?php echo htmlspecialchars($formation['nomcategorie']); ?></p>
            <h6 class="product-price">
                <?php 
            if ($formation['Prix_Promotion']) {
                echo "<span class='original-price' style='font-size: 12px; color: black;'>" . htmlspecialchars($formation['Prix']) . " DA</span> <span class='promotional-price' style='font-size: 22px; color: red;'>" . htmlspecialchars($formation['Prix_Promotion']) . " DA</span>";
            } else {
                echo "<span style='font-size: 16px; color: black;'>" . htmlspecialchars($formation['Prix']) . " DA</span>";
            }
            ?>
            </h6>
            <p class="short-description"><?php echo nl2br(htmlspecialchars($formation['description'])); ?></p>
            <div class="action-buttons">
                <a href="../Checkout/checkout.php?id=<?php echo htmlspecialchars($formation['Id_formations']); ?>"
                    class="buy-now-btn"><i class="fa-solid fa-shop"></i> S'inscrire maintenant</a>
            </div>
        </div>

    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <a href="#" class="logo">
                    <i class="ri-book-line"></i> Education
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
</body>
<script>
document.querySelector('.addToCartBtn').addEventListener('click', function() {
    const productId = <?= json_encode($formation['Id_formations']); ?>;
    const price = <?= json_encode($formation['Prix_Promotion'] ?: $formation['Prix']); ?>;
    fetch('add_to_cart.php', {
            method: 'POST',
            body: JSON.stringify({
                productId,
                price
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Product added to cart!');
            // Update cart count here if needed
        })
        .catch(error => console.error('Error:', error));
});
</script>

</html>