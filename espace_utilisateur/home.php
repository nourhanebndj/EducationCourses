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


                </ul>


            </div>
        </nav>
    </header>
    <!--=============== Home Section ===============-->

    <section class="home">
        <div class="home-image">
            <img src="./image/home-image.jpg" alt="Image de l'école" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <div class="home-text">
            <h4>On est une école qui travaille sur</h4>
            <h1>L'évolution de la formation en Algérie</h1>
            <p>Une école de formation innovante pour un apprentissage facile et efficace des compétences les plus
                recherchées par les entreprises.</p>
            <a href="./formations.php" class="btn">Voir nos formations</a>
        </div>
    </section>
    <!--=============== Home Section 2 ===============-->
    <section class="home-1">
        <div class="home-section-1">
            <h2>Pourquoi choisir nos formations ?</h2>
            <p>Chaque cours est soigneusement élaboré par des professionnels reconnus dans leur domaine et des créateurs
                de contenu de renom. En vous inscrivant chez nous, vous avez la garantie d’apprendre auprès des
                meilleurs, de bénéficier de leur expertise et de leurs années d’expérience. Ne laissez pas passer
                l’opportunité d’enrichir vos connaissances avec des experts qui sont non seulement passionnés, mais
                aussi dédiés à votre réussite.”</p>
        </div>
        <div class="cards-container">
            <div class="card">
                <div class="card-icon"><img src="./image/customer-satisfaction.gif" alt="Icon 1"></div>
                <h3>Adapté à tout niveau</h3>
                <p> Riche et flexible, nos programmes conviennent à tous le monde</p>
            </div>
            <div class="card elevated">
                <div class="card-icon"><img src="./image/setting.gif" alt="Icon 2"></div>
                <h3>Basé sur la pratique</h3>
                <p>Au bout de chaque formation vous aurez à réaliser un projet pratique</p>
            </div>
            <div class="card">
                <div class="card-icon"><img src="./image/support.gif" alt="Icon 4"></div>
                <h3>Une assistance continue</h3>
                <p>On sera toujours là pour vous aider même après la formation.</p>
            </div>
            <div class="card elevated">
                <div class="card-icon"><img src="./image/heart.gif" alt="Icon 3"></div>
                <h3>Des formateurs passionnés</h3>
                <p>Nos formateurs sont des professionnels passionnés par leurs domaines.</p>
            </div>

        </div>
    </section>
    <!--=============== Section 3 ===============-->

    <section class="home">
        <div class="home-text">
            <h1>Nos formations</h1>
            <p>Zducations Academy propose des formations exclusivement dédiées au monde du digital.
                Toutes les formations enseignées vous permettront de vous positionner comme un professionnel du domaine
                et vous propulseront dans le monde du travail professionnel.</p>
            <a href="./formations.php" class="btn">Voir nos formations</a>
        </div>
        <div class="home-image">
            <img src="./image/formations.png" alt="Formations" style="width:100%; height:100%; object-fit:cover;">
        </div>
    </section>
    <!--=============== Section 4 ===============-->

    <section class="questions">
        <div class="questions-frequente">
            <h2>Questions fréquentes</h2>
            <p>Voici les réponses aux questions les plus fréquentes, en cas de besoin vous pouvez toujours nous
                contacter.</p>
        </div>

        <div class="question">
            <div class="question-title">
                <h4>Comment puis-je acheter une formation ?</h4>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <p class="answer hidden">
                Pour acquérir une formation, le processus est simple. Rendez-vous dans la section “Formations“,
                choisissez celle qui vous intéresse, puis cliquez sur “Inscription à la formation“. Complétez vos
                informations et sélectionnez votre méthode de paiement.

                Si vous optez pour un paiement via CIB, Dahabia, Visa, Mastercard ou Paypal, l’accès à la formation vous
                sera automatiquement accordé.

                En revanche, si vous choisissez de payer via CCP ou Wise, il vous suffit de nous faire parvenir la
                preuve de paiement sur notre page Instagram @etudzacademy. Une fois cela fait, nous confirmerons votre
                accès à la formation.
            </p>
        </div>

        <div class="question">
            <div class="question-title">
                <h4>Comment puis-je contacter le formateur sur la plateforme ?</h4>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <p class="answer hidden">
                Pour contacter votre formateur ou lui poser des questions, vous pouvez publier un statut dans la page
                ”Communauté” ou lui envoyer directement un message privé.
            </p>
        </div>
        <div class="question">
            <div class="question-title">
                <h4>Qu'en est-il du diplôme ?</h4>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <p class="answer hidden">
                À la fin de toutes les formations vous serez certifié par une attestation de participation.

                Celle-ci reste bien-sur nominative et vérifiable via un QR Code ou un lien vers le certificat sur la
                plate-forme qui offre une crédibilité supplémentaire à votre certificat.
            </p>
        </div>
    </section>
    <!--=============== Section 5 ===============-->
    <section class="contact-us">
        <div class="contact">
            <h4>Qu'attendez vous ?</h4>
            <h2>Commencez votre fomation maintenant !</h2>
            <a href="#" class="btn">Voir nos formations</a>
            <p> Retrouvez nous sur les réseaux</p>
            <div class="social-icons">
                <a href="https://facebook.com" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://youtube.com" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </section>



    <!--=============== MAIN JS ===============-->
    <script src="script.js"></script>
</body>
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