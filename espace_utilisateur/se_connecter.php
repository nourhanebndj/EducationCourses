<?php
// Variables de configuration de la base de données
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "education";

// Connexion à la base de données
$bdd = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);

// Vérifier la connexion à la base de données
if (!$bdd) {
    die("La connexion à la base de données a échoué.");
}

$message = ""; 

// Traitement de la connexion
if (isset($_POST['envoi'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Recherche de l'utilisateur dans la base de données
    $checkUser = $bdd->prepare('SELECT * FROM membre WHERE email = ?');
    $checkUser->execute(array($email));
    $user = $checkUser->fetch();

    if ($user) {
        $hashedPassword = $user['mdp'];

        // Vérification du mot de passe
        if (password_verify($mdp, $hashedPassword)) {
            // Connexion réussie, rediriger vers la page d'accueil ou autre page souhaitée
            session_start();
            $_SESSION['connexion_reussie'] = true;
            header("Location: home.php");
            exit();
        } else {
            $message = "Identifiants de connexion invalides. Veuillez réessayer.";
        }
    } else {
        $message = "Identifiants de connexion invalides. Veuillez réessayer.";
    }
}

// Utilisation de la variable $message après son assignation
echo $message;
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
    <div class="connecter">
        <div class="form-box">
            <h1>Connexion</h1>
            <form action="se_connecter.php" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="mdp" placeholder="Mot de passe" required>
                    </div>
                    <p>Mot de passe oublié? <a href="#">cliquez ici</a></p>
                </div>
                <div class="btn-field">
                    <button type="submit" name="envoi">Connexion</button>
                    <a href="inscription.php" class="button-link">Inscription</a>
                </div>
            </form>

        </div>
    </div>
</body>

</html>