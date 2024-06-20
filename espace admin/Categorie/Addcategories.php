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
//Fonction Ajouter une categorie

if (isset($_POST['category_save'])) {
    if (!empty($_POST['nomcategorie']) && !empty($_POST['descriptioncategorie'])) {
        $name = $_POST['nomcategorie'];
        $description = $_POST['descriptioncategorie'];
        $status = isset($_POST['status']) ? '1' : '0';

        $category_query = "INSERT INTO catégories (nomcategorie, descriptioncategorie, status, jour_creation) VALUES ('$name', '$description', '$status', NOW())";
        $cate_query_run = mysqli_query($con, $category_query);

        if ($cate_query_run) {
            $_SESSION['status'] = "Insertion réussie";
            header("Location: ../Categorie/allcategories.php");
            exit();
        } else {
            $_SESSION['status'] = "L'insertion a échoué: " . mysqli_error($con);
            header("Location: ../Categorie/allcategories.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Tous les champs sont obligatoires.";
        header("Location: ./Categorie/allcategories.php");
        exit();
    }
}
//Fonction Modifier une categorie

if (isset($_POST['category_update'])) {
    if (isset($_POST['Id_categorie'], $_POST['nomcategorie'], $_POST['descriptioncategorie'])) {
        $Id_categorie = $_POST['Id_categorie'];
        $name = $_POST['nomcategorie'];
        $description = $_POST['descriptioncategorie'];
        $status = isset($_POST['status']) ? '1' : '0';  // Utilisez isset pour vérifier si la checkbox a été cochée

        $update_query = "UPDATE catégories SET nomcategorie=?, descriptioncategorie=?, status=? WHERE Id_categorie=?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("sssi", $name, $description, $status, $Id_categorie);
        $success = $stmt->execute();

        if ($success) {
            $_SESSION['status'] = "Catégorie modifiée avec succès";
            header('location:../Categorie/allcategories.php');
            exit;
        } else {
            $_SESSION['status'] = "Erreur de modification de la catégorie";
            header('location:../Categorie/allcategories.php');
            exit;
        }
    } else {
        $_SESSION['status'] = "Les données nécessaires sont manquantes.";
        header('location:../Categorie/allcategories.php');
        exit;
    }
}

//Fonction Supprimer une categorie
if (isset($_POST['cate_delete_id'])) {
    $Id_categorie = $_POST['cate_delete_id']; // Assurez-vous que le nom du champ dans le formulaire corresponde à celui-ci.
    $query = "DELETE FROM catégories WHERE Id_categorie=$Id_categorie";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['status'] = "Catégorie supprimée avec succès";
        header('Location: ../Categorie/allcategories.php');
    } else {
        $_SESSION['status'] = "Erreur lors de la suppression de la catégorie: " . mysqli_error($con);
        header('Location: ../Categorie/allcategories.php');
    }
}