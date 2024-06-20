<?php
define('BASE_URL', 'http://educationdz.free.nf)/');

//Connexion base de donnée

session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "admin";
$con = mysqli_connect($host, $username, $password, $dbname);
if (!$con) {
    die("La connexion a échoué: " . mysqli_connect_error());
}
//Fonction Supprimer un admin
if (isset($_POST['admin_delete_id'])) {
    $Id_admin = $_POST['admin_delete_id']; 
    $query = "DELETE FROM admin_login WHERE Id_admin=$Id_admin";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['Admin_Name'] = "Admin supprimée avec succès";
        header('Location: ../Authentification/admins.php');
    } else {
        $_SESSION['Admin_Name'] = "Erreur lors de la suppression de l'admin': " . mysqli_error($con);
        header('Location: ../Authentification/Admins.php');
    }
}