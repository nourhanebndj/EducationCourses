<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/espace admin/php/Connexion_bdd.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: se_connecter.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = mysqli_real_escape_string($con, trim($_POST['prenom']));
    $nom = mysqli_real_escape_string($con, trim($_POST['nom']));
    $telephone = mysqli_real_escape_string($con, trim($_POST['telephone']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $formation_id = intval($_POST['formation_id']);
    $price = floatval($_POST['price']); 
    $etat = 'en_attente'; 

    $date = date("Y-m-d H:i:s");

    $query = "INSERT INTO commande (prenom, nom, telephone, email, Id_formations, price, date_commande, etat, Id_membre) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }
    
    $stmt->bind_param('ssssisssi', $prenom, $nom, $telephone, $email, $formation_id, $price, $date, $etat, $user_id);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        echo "Commande insérée avec succès, ID : " . htmlspecialchars($order_id) . "<br>";

        header("Location: confirmation.php?id=" . $order_id);
        exit(); 
    } else {
        echo "Erreur lors de l'enregistrement de la commande: " . htmlspecialchars($stmt->error);
    }
    
    $stmt->close();
    $con->close();
} else {
    echo "Accès direct non autorisé.";
}
?>