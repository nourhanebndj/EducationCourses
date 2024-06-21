<?php
// Assurez-vous que le chemin est correct pour les fichiers de connexion
require_once $_SERVER['DOCUMENT_ROOT'] . '/espace admin/php/Connexion_bdd.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/espace_utilisateur/php/Connexion_user.php'; 

session_start();

$con_admin = new mysqli("localhost", "root", "", "admin");
if ($con_admin->connect_error) {
    die("Erreur de connexion à la base de données 'admin': " . $con_admin->connect_error);
}
$con_education = new mysqli("localhost", "root", "", "education");
if ($con_education->connect_error) {
    die("Erreur de connexion à la base de données 'education': " . $con_education->connect_error);
}
// Vérifiez si l'ID de la commande est défini et est un nombre
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
echo "ID de commande invalide.";
exit;
}

$id = intval($_GET['id']);
echo "ID de commande reçu : " . htmlspecialchars($id) . "<br>";

// Récupérez les informations de la commande
$query = "SELECT id, prenom, nom, telephone, email, Id_formations, price, date_commande, Id_membre
FROM commande
WHERE id = ?";
$stmt = $con_admin->prepare($query);
if ($stmt === false) {
die('Prepare failed: ' . htmlspecialchars($con_admin->error));
}
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$commande = $result->fetch_assoc();

if (!$commande) {
echo "Commande non trouvée.";
exit;
}

// Récupérez les informations du membre
$id_membre = $commande['Id_membre'];
$query_membre = "SELECT NomComplet FROM membre WHERE Idmembre = ?";
$stmt_membre = $con_education->prepare($query_membre);
if ($stmt_membre === false) {
die('Prepare failed: ' . htmlspecialchars($con_education->error));
}
$stmt_membre->bind_param('i', $id_membre);
$stmt_membre->execute();
$result_membre = $stmt_membre->get_result();
$membre = $result_membre->fetch_assoc();

if (!$membre) {
echo "Membre non trouvé.";
exit;
}

// Récupérez les informations de la formation
$formation_id = $commande['Id_formations'];
$query_formation = "SELECT nom_formation, Prix, Prix_Promotion FROM formations WHERE Id_formations = ?";
$stmt_formation = $con_admin->prepare($query_formation);
if ($stmt_formation === false) {
die('Prepare failed: ' . htmlspecialchars($con_admin->error));
}
$stmt_formation->bind_param('i', $formation_id);
$stmt_formation->execute();
$result_formation = $stmt_formation->get_result();
$formation = $result_formation->fetch_assoc();

if (!$formation) {
echo "Formation non trouvée.";
exit;
}

// Récupérez les catégories
$categories = [];
$query_categories = "SELECT * FROM catégories";
$result_categories = $con_admin->query($query_categories);
if ($result_categories) {
while ($row = $result_categories->fetch_assoc()) {
$categories[] = $row;
}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coursera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js" defer></script>
    <style>
    .category {
        font-size: 14px;
        color: #555;
    }

    .payment-instructions {
        background-color: #FFFFFF;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 200px;
        margin: 20px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .payment-instructions h2 {
        font-size: 24px;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 15px;
        text-align: center;
    }

    .payment-instructions p {
        font-size: 16px;
        line-height: 1.6;
        color: #555;
        margin-bottom: 10px;
    }

    .payment-instructions strong {
        font-weight: bold;
        color: #AD0909;
    }

    .payment-instructions p:last-child {
        margin-bottom: 0;
    }

    .download-button {
        display: inline-block;
        background-color: #007bff;
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

    .download-button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .download-button i {
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
    <section class="payment-instructions">
        <h2>Merci pour votre confiance</h2>
        <p>Pour recevoir votre formation, veuillez effectuer un paiement de
            <strong><?php echo htmlspecialchars($formation['Prix_Promotion'] ?: $formation['Prix']); ?> DA</strong> au
            compte CCP suivant :
        </p>
        <p><strong>Numéro CCP :</strong> 1234567890</p>
        <p>Ensuite, envoyez le reçu de paiement avec l'ID de votre commande à l'adresse email suivante :</p>
        <p><strong>Email :</strong> nourhanebndj@gmail.com</p>
        <p>Vous trouvez ci-dessous un pdf contenant les informations de votre commande. Merci de les télécharger.</p>
        <a href="generate_pdf.php?id=<?php echo htmlspecialchars($id); ?>" target="_blank" class="download-button"> <i
                class="ri-download-2-line"></i>Télécharger le PDF</a>
    </section>
</body>

</html>