<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=education;charset=utf8', 'root', '');

$message = "";

if (isset($_POST['envoi'])) {
    if (isset($_POST['NomComplet']) && !empty($_POST['mdp'])) {
        $NomComplet = htmlspecialchars($_POST['NomComplet']);
        $mdp = $_POST['mdp'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];

        $checkUser = $bdd->prepare('SELECT * FROM membre WHERE email = ? OR NomComplet = ?');
        $checkUser->execute(array($email, $NomComplet));
        $existingUser = $checkUser->fetch();

        if (!$existingUser) {
            $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
            $insertUser = $bdd->prepare('INSERT INTO membre(NomComplet, email, telephone, mdp) VALUES (?, ?, ?, ?)');
            $success = $insertUser->execute(array($NomComplet, $email, $telephone, $hashedPassword));

            if ($success) {
                $_SESSION['user_id'] = $bdd->lastInsertId(); 
                $_SESSION['user_name'] = $NomComplet; 
                header("Location: ../pages/home.php");
                exit(); 
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        } else {
            $message = "Un utilisateur avec le même email ou le même nom existe déjà.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Inscription</title>
</head>

<body>
    <div class="form-box">
        <h1>Inscription</h1>
        <form action="inscription.php" method="POST">
            <div class="input-group">
                <div class="input-field">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="NomComplet" placeholder="Nom complet" required>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telephone" placeholder="N° téléphone" required>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="mdp" placeholder="Mot de passe" required>
                </div>
            </div>
            <div class="btn-field">
                <button type="submit" name="envoi">Inscription</button>
                <a href="se_connecter.php" class="button-link">Connexion</a>
            </div>
        </form>


        <p><?php echo $message; ?></p>
    </div>
</body>

</html>