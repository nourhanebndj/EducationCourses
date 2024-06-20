<?php
//Connexion base de donnée
define('BASE_URL', 'http://educationdz.free.nf)/');

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '../espace_utilisateur/php/Connexion_user.php'; 

//Fonction Supprimer un membre
if (isset($_POST['membre_delete_id'])) {
    $idmembre = $_POST['membre_delete_id']; 
    $query = "DELETE FROM membre WHERE idmembre=$idmembre";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['NomComplet'] = "Membre supprimée avec succès";
        header('Location: ../Membre/Membres.php');
    } else {
        $_SESSION['NomComplet'] = "Erreur lors de la suppression du membre': " . mysqli_error($con);
        header('Location: ../Membre/Membres.php');
    }
}