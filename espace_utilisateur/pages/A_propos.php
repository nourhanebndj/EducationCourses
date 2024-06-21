<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '../espace admin/php/Connexion_bdd.php'; 
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
    <section class="contact-section">
        <div class="contact-bg">
            <h3>Prenez Savoir avec nous</h3>
            <h2>à propos de nous</h2>
            <div class="line">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </section>
    <section class="about-us">

        <div class="image-full">
            <img src="../image/edcation-contact_us.jpg" alt="Descriptive alt text">
        </div>
        <div class="content-aboutus">
            <h2>A propos de nous</h2>

            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis aspernatur voluptas inventore ab
                voluptates nostrum minus illo laborum harum laudantium earum ut, temporibus fugiat sequi explicabo
                facilis unde quos corporis!</p>
            <br>
            <ul class="links">
                <li><a href="formations.html">Formations</a></li>
                <li><a href="A_propos.html">A propos</a></li>
                <li><a href="contact.html">Contactez-nous</a></li>
            </ul>


            <ul class="icons">
                <li><i class="fab fa-twitter"></i></li>
                <li><i class="fab fa-facebook"></i></li>
                <li><i class="fab fa-instagram"></i></li>
                <li><i class="fab fa-youtube"></i></li>
            </ul>
        </div>
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