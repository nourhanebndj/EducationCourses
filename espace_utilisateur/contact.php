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
    <link rel="stylesheet" href="style.css">

    <title>Coursera</title>
</head>

<body>
    <!--=============== HEADER ===============-->
    <header class="header">
        <nav class="nav container">
            <div class="nav__data">
                <a href="#" class="nav__logo">
                    <i class="ri-book-line"></i>Education
                </a>

                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line nav__burger"></i>
                    <i class="ri-close-line nav__close"></i>
                </div>
            </div>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li><a href="home.php" class="nav__link"><i class="ri-home-line"></i> Accueil</a></li>
                    <li><a href="A_propos.php" class="nav__link"><i class="ri-information-line"></i> A propos</a></li>
                    <li class="dropdown__item">
                        <a href="formations.php" class="nav__link">
                            Formations <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </a>

                        <ul class="dropdown__menu">
                            <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="formations_categories.php?Id_categorie=<?php echo $category['Id_categorie']; ?>"
                                    class="dropdown__link"><?php echo htmlspecialchars($category['nomcategorie']); ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li><a href="contact.php" class="nav__link"><i class="ri-contacts-line"></i> Contactez-nous</a>
                    </li>
                    <li><a href="se_connecter.php" class="nav__link"><i class="ri-user-2-line"></i> Se connecter</a>
                    </li>
                    <li><a href="cart.php" class="nav__link">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span id="cart-count" class="cart-count">0</span>
                        </a></li>

                </ul>


            </div>
        </nav>
    </header>
    <section class="contact-section">
        <div class="contact-bg">
            <h3>Prenez contact avec nous</h3>
            <h2>Contactez-nous</h2>
            <div class="line">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p class="text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda iste facilis quos
                impedit fuga nobis modi debitis laboriosam velit reiciendis quisquam alias corporis, maxime enim, optio
                ab dolorum sequi qui.</p>
        </div>


        <div class="contact-body">
            <div class="contact-info">
                <div>
                    <span><i class="fas fa-mobile-alt"></i></span>
                    <span>N° téléphone</span>
                    <span class="text">0658934340</span>
                </div>
                <div>
                    <span><i class="fas fa-envelope-open"></i></span>
                    <span>E-mail</span>
                    <span class="text">nourhanebndj@gmail.com</span>
                </div>
                <div>
                    <span><i class="fas fa-map-marker-alt"></i></span>
                    <span>Address</span>
                    <span class="text">Annaba,Algeria</span>
                </div>
                <div>
                    <span><i class="fas fa-clock"></i></span>
                    <span>Heures d'ouvertures</span>
                    <span class="text">Dimanches - Samedi (9:00 AM au 5:00 PM)</span>
                </div>
            </div>

            <div class="contact-form">
                <div>
                    <img src="./image/edcation-contact_us.jpg" alt="Contact">
                </div>
                <form>
                    <div>
                        <input type="text" class="form-control" placeholder="Nom">
                        <input type="text" class="form-control" placeholder="Prénom">
                    </div>
                    <div>
                        <input type="email" class="form-control" placeholder="E-mail">
                        <input type="text" class="form-control" placeholder="Numéro de téléphone">
                    </div>
                    <textarea rows="5" placeholder="Message" class="form-control"></textarea>
                    <input type="submit" class="send-btn" value="Envoyer message">
                </form>

            </div>
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