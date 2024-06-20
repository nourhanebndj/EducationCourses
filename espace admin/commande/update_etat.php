<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/espace admin/php/Connexion_bdd.php';
session_start();

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $commande_id = intval($_POST['commande_id']);
    $etat = mysqli_real_escape_string($con, trim($_POST['etat']));

    // Met à jour l'état de la commande dans la base de données
    $query = "UPDATE commande SET etat = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }
    
    // Lie les paramètres et exécute la requête
    $stmt->bind_param('si', $etat, $commande_id);
    
    if ($stmt->execute()) {
        // Redirige vers la page des commandes après la mise à jour réussie
        header("Location: commande.php");
        exit; // Assurez-vous de sortir après la redirection
    } else {
        // Affiche un message d'erreur si la mise à jour a échoué
        echo "Erreur lors de la mise à jour de l'état de la commande: " . htmlspecialchars($stmt->error);
    }
    
    $stmt->close();
    $con->close();
} else {
    // Affiche un message si l'accès direct n'est pas autorisé
    echo "Accès direct non autorisé.";
}
?>