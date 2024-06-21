<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/espace admin/php/Connexion_bdd.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../authentification/se_connecter.php");
    exit();
}

$user_id = $_SESSION['user_id'];

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
    <!-- Liens -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Chemins CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js" defer></script>
    <style>
    .category {
        font-size: 14px;
        color: #555;
    }

    .payment-button {
        display: inline-block;
        background-color: brown;
        color: #ffffff;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        border: none;
        outline: none;
    }

    .payment-button:hover {
        background-color: brown;
        transform: scale(1.05);
    }

    .payment-button i {
        margin-right: 8px;
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
    <div class="container-paiement">
        <div class="billing-details">
            <h4>DÉTAILS DE FACTURATION</h4>
            <form action="process_checkout.php" method="POST">
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>

                <input type="hidden" name="formation_id"
                    value="<?php echo htmlspecialchars($formation['Id_formations']); ?>">
                <input type="hidden" name="price"
                    value="<?php echo htmlspecialchars($formation['Prix_Promotion'] ?: $formation['Prix']); ?>">

                <button type="submit" class="payment-button"><i class="ri-shopping-cart-line"></i>Payer
                    maintenant</button>
            </form>
        </div>

        <!-- Order Summary Section -->
        <div class="order-summary">
            <h4>VOTRE COMMANDE</h4>
            <div class="product">
                <img src="../espace admin/uploads/<?php echo htmlspecialchars($formation['images']); ?>"
                    alt="<?php echo htmlspecialchars($formation['nom_formation']); ?>" class="product-image">
                <div class="product-info">
                    <span class="product-name"><?php echo htmlspecialchars($formation['nom_formation']); ?></span>
                    <span
                        class="product-price"><?php echo htmlspecialchars($formation['Prix_Promotion'] ?: $formation['Prix']); ?>
                        DA</span>
                </div>
            </div>

            <div class="totals">
                <div class="line-item">
                    <span>Sous-total</span>
                    <span><?php echo htmlspecialchars($formation['Prix_Promotion'] ?: $formation['Prix']); ?> DA</span>
                </div>
                <div class="line-item">
                    <span>Total</span>
                    <span><?php echo htmlspecialchars($formation['Prix_Promotion'] ?: $formation['Prix']); ?> DA</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>