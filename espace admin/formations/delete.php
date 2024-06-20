<?php
//Connexion base de donnée
define('BASE_URL', 'http://educationdz.free.nf)/');

session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "admin";
$con = mysqli_connect($host, $username, $password, $dbname);
if (!$con) {
    die("La connexion a échoué: " . mysqli_connect_error());
}
//Fonction Supprimer une formation
if (isset($_POST['formation_delete_id'])) {
$id_formation = $_POST['formation_delete_id']; 
$query = "DELETE FROM formations WHERE id_formations=$id_formation";
$query_run = mysqli_query($con, $query);
if ($query_run) {
$_SESSION['images'] = "formation supprimée avec succès";
header("Location: ../formations/Formations.php");
} else {
$_SESSION['images'] = "Erreur lors de la suppression de la formation: " . mysqli_error($con);
header("Location: ../formations/Formations.php");
}
}