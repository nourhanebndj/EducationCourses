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
                            <li><a href="#" class="dropdown__link"><i class="ri-pie-chart-line"></i>Graphic Design</a>
                            </li>
                            <li><a href="#" class="dropdown__link"><i class="ri-store-line"></i>Boutique en ligne</a>
                            </li>
                            <li><a href="#" class="dropdown__link"><i class="ri-facebook-circle-line"></i>Facebook
                                    Ads</a></li>
                            <li><a href="#" class="dropdown__link"><i class="ri-camera-line"></i>Photographie de
                                    produits</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="contact.php" class="nav__link"><i class="ri-contacts-line"></i> Contactez-nous</a>
                    </li>
                    <li><a href="se_connecter.php" class="nav__link"><i class="ri-user-2-line"></i> Se connecter</a>
                    </li>

                </ul>


            </div>
        </nav>
    </header>
    <section class="formations">
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
        </div>
        <div class="card-formation">
            <img src="./image/formation_web_design.jpg">
            <p>Boutique en ligne / Web Design</p>
            <h6>12.000 Da</h6>
            <button class="buy-button">
                S'inscrire à la formation
            </button>
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