<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', '');

$message = "";

if (isset($_POST['submit'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp']) && !empty($_POST['email']) && !empty($_POST['telephone'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $mdp = $_POST['mdp'];

        $checkUser = $bdd->prepare('SELECT * FROM Etudiant WHERE email = ? OR pseudo = ?');
        $checkUser->execute(array($email, $pseudo));
        $existingUser = $checkUser->fetch();

        if (!$existingUser) {
            $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
            $insertUser = $bdd->prepare('INSERT INTO Etudiant(pseudo, email, telephone, mdp) VALUES (?, ?, ?, ?)');
            $success = $insertUser->execute(array($pseudo, $email, $telephone, $hashedPassword));

            if ($success) {
                $message = "Inscription réussie !";
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        } else {
            $message = "Un utilisateur avec le même email ou le même pseudo existe déjà.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

echo $message; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>

<body>
    <div class="form-box">
        <h1>Inscription</h1>
        <form action="inscription.php" method="POST">
            <div class="input-group">
                <div class="input-field">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="pseudo" placeholder="Nom complet" required>
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
                <button type="submit" name="submit">Inscription</button>
                <a href="se_connecter.html"><button type="button">Connexion</button></a>
            </div>
        </form>
        <p><?php echo $message; ?></p>
    </div>
</body>

</html>