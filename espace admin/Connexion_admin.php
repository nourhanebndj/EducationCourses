<?php
session_start();
if (isset($_POST['valider'])) {
    if (!empty($_POST['Username']) && !empty($_POST['mdp'])) {  
        $Username_par_defaut = "admin";
        $mdp_par_defaut = "admin1234";
        $username_saisi = htmlspecialchars($_POST['Username']);
        $mdp_saisi = htmlspecialchars($_POST['mdp']);
        if ($username_saisi == $Username_par_defaut && $mdp_saisi == $mdp_par_defaut) {  
            $_SESSION['loggedin'] = true;  
            header("Location: Dashboard.php");  
            exit();  
        } else {
            echo "Votre mot de passe ou bien username est incorrect";
        }
    } else {
        echo "Veuillez completer tous les champs";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion Admin</title>
    <meta charset="utf-8">
</head>

<body>
    <form method="POST" action="Connexion_admin.php">
        <input type="text" name="Username" autocomplete="off"><br>
        <input type="password" name="mdd"><br><br>
        <input type="submit" name="valider">
    </form>
</body>

</html>