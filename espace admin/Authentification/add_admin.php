<?php
// Connexion à la base de données
session_start();
define('BASE_URL', 'http://educationdz.free.nf)/');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "admin";
$con = mysqli_connect($host, $username, $password, $dbname);

if (!$con) {
    die("La connexion a échoué: " . mysqli_connect_error());
}

// Fonction pour ajouter un admin
if (isset($_POST['admin_save'])) {
    if (!empty($_POST['Admin_Name']) && !empty($_POST['Admin_password'])) {
        $name_admin = mysqli_real_escape_string($con, $_POST['Admin_Name']);
        $admin_password = $_POST['Admin_password'];

        $query = "INSERT INTO admin_login (Admin_Name, Admin_password) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $name_admin, $admin_password);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $_SESSION['Admin_Message'] = "Insertion réussie";
                header("Location: ../Authentification/Admins.php");
                exit();
            } else {
                $_SESSION['Admin_Message'] = "L'insertion a échoué: " . mysqli_error($con);
                header("Location: ../Authentification/Admins.php");
                exit();
            }
        } else {
            $_SESSION['Admin_Message'] = "Erreur de préparation: " . mysqli_error($con);
            header("Location: ../Authentification/Admins.php");
            exit();
        }
    } else {
        $_SESSION['Admin_Message'] = "Tous les champs sont obligatoires.";
        header("Location: ../Authentification/Admins.php");
        exit();
    }
}
?>