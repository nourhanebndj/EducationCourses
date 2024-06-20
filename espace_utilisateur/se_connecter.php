<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=education;charset=utf8', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $checkUser = $bdd->prepare('SELECT * FROM membre WHERE email = ?');
    $checkUser->execute([$email]);
    $user = $checkUser->fetch();

    if ($user && password_verify($mdp, $user['mdp'])) {
        $_SESSION['user_id'] = $user['Id_membre'];
        $_SESSION['user_name'] = $user['NomComplet'];
        header("Location: home.php");
        exit();
    } else {
        echo "Identifiants de connexion invalides.";
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