<?php
require_once 'C:/Users/nourh/Downloads/Bureau/Websites/coursera php sql/espace_utilisateur/fpdf/fpdf.php'; 

// Connexion à la base de données 'admin' pour les commandes et les catégories
$con_admin = new mysqli("localhost", "root", "", "admin");
if ($con_admin->connect_error) {
    die("Erreur de connexion à la base de données 'admin': " . $con_admin->connect_error);
}

// Connexion à la base de données 'education' pour les membres
$con_education = new mysqli("localhost", "root", "", "education");
if ($con_education->connect_error) {
    die("Erreur de connexion à la base de données 'education': " . $con_education->connect_error);
}

session_start();

// Vérifiez si l'ID de la commande est défini et est un nombre
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de commande invalide.";
    exit;
}

$id = intval($_GET['id']);
echo "ID de commande reçu : " . htmlspecialchars($id) . "<br>";

// Récupérez les informations de la commande
$query = "SELECT id, prenom, nom, telephone, email, Id_formations, price, date_commande, Id_membre
          FROM commande
          WHERE id = ?";
$stmt = $con_admin->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($con_admin->error));
}
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$commande = $result->fetch_assoc();

if (!$commande) {
    echo "Commande non trouvée.";
    exit;
}

// Récupérez les informations du membre
$id_membre = $commande['Id_membre'];
$query_membre = "SELECT NomComplet FROM membre WHERE Idmembre = ?";
$stmt_membre = $con_education->prepare($query_membre);
if ($stmt_membre === false) {
    die('Prepare failed: ' . htmlspecialchars($con_education->error));
}
$stmt_membre->bind_param('i', $id_membre);
$stmt_membre->execute();
$result_membre = $stmt_membre->get_result();
$membre = $result_membre->fetch_assoc();

if (!$membre) {
    echo "Membre non trouvé.";
    exit;
}

// Récupérez les informations de la formation
$formation_id = $commande['Id_formations'];
$query_formation = "SELECT nom_formation, Prix, Prix_Promotion FROM formations WHERE Id_formations = ?";
$stmt_formation = $con_admin->prepare($query_formation);
if ($stmt_formation === false) {
    die('Prepare failed: ' . htmlspecialchars($con_admin->error));
}
$stmt_formation->bind_param('i', $formation_id);
$stmt_formation->execute();
$result_formation = $stmt_formation->get_result();
$formation = $result_formation->fetch_assoc();

if (!$formation) {
    echo "Formation non trouvée.";
    exit;
}

// Vérifiez si le dossier /pdf/ existe et est accessible en écriture
$pdf_dir = $_SERVER['DOCUMENT_ROOT'] . '/pdf/';
if (!is_dir($pdf_dir)) {
    echo "Le dossier PDF n'existe pas.<br>";
    if (!mkdir($pdf_dir, 0777, true)) {
        die('Échec de la création du dossier PDF.');
    }
}
if (!is_writable($pdf_dir)) {
    die('Le dossier PDF n\'est pas accessible en écriture.');
}

// Initialisez le PDF
$pdf = new FPDF();
$pdf->AddPage();

// Logo (Remplacez 'path/to/logo.png' par le chemin réel de votre logo)
//$pdf->Image('path/to/logo.png', 10, 10, 30); 

// Titre
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor(0, 150, 200);
$pdf->Cell(0, 20, 'Commande', 0, 1, 'R');

// Ligne horizontale
$pdf->SetDrawColor(0, 150, 200);
$pdf->SetLineWidth(1);
$pdf->Line(10, 30, 200, 30);

// Informations de l'entreprise
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(100, 10, 'Education DZ', 0, 0, 'L');
$pdf->Cell(0, 10, 'Destinataire', 0, 1, 'R');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 5, 'Annaba, Algerie', 0, 0, 'L');
$pdf->Cell(0, 5, $commande['prenom'] . ' ' . $commande['nom'], 0, 1, 'R');

$pdf->Cell(100, 5, '', 0, 0, 'L');
$pdf->Cell(0, 5, $commande['email'], 0, 1, 'R');

$pdf->Cell(0, 5, 'Telephone: ' . $commande['telephone'], 0, 1, 'R');

$pdf->Ln(10); // Saut de ligne

// Informations de la facture
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 5, 'Numero de la commande: ' . $commande['id'], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Date de la commande: ' . $commande['date_commande'], 0, 1, 'L');

$pdf->Cell(100, 5, 'Nom de la formation: ' . $formation['nom_formation'], 0, 1, 'L');
$pdf->Cell(100, 5, 'Prix: ' . number_format($commande['price'], 2) . ' DA', 0, 1, 'L');

$pdf->Ln(10); // Saut de ligne

// Informations additionnelles
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informations additionnelles', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, 'Merci d\'avoir choisi Education DZ pour nos services.', 0, 'L');

$pdf->Ln(10); // Saut de ligne

// Tableau des items
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(70, 10, 'Nom de formation', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Prix unitaire', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Total ', 1, 1, 'C', true);

// Ligne d'item avec le nom de la formation
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(70, 10, $formation['nom_formation'], 1);
$pdf->Cell(30, 10, number_format($commande['price'], 2) . ' DA', 1);
$pdf->Cell(30, 10, number_format($commande['price'], 2) . ' DA', 1);

$pdf->Ln(10); // Saut de ligne

// Totaux
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, '', 0);
$pdf->Cell(30, 10, 'Total ', 1, 0, 'R');
$pdf->Cell(30, 10, number_format($commande['price'], 2) . ' DA', 1, 1, 'R');

$pdf->Cell(100, 10, '', 0);
$pdf->Cell(30, 10, 'Total TVA', 1, 0, 'R');
$pdf->Cell(30, 10, '0.00 DA', 1, 1, 'R');

$pdf->Cell(100, 10, '', 0);
$pdf->Cell(30, 10, 'Total TTC', 1, 0, 'R');
$pdf->Cell(30, 10, number_format($commande['price'], 2) . ' DA', 1, 1, 'R');

$pdf->Ln(10); // Saut de ligne

// Note sous le tableau
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, 'Note', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, 'Pour recevoir votre formation, veuillez effectuer un paiement de ' . number_format($commande['price'], 2) . ' DA au compte CCP suivant :');
$pdf->SetFont('Arial', 'B', 12);
$pdf->MultiCell(0, 5, 'Numero CCP : 1234567890', 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, 'Ensuite, envoyez le recu de paiement avec l\'ID de votre commande a l\'adresse email suivante :');
$pdf->SetFont('Arial', 'B', 12);
$pdf->MultiCell(0, 5, 'Email : nourhanebndj@gmail.com', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Merci pour votre confiance', 0, 1, 'L');

$pdf->Ln(10); // Saut de ligne

// Chemin du fichier PDF
$pdf_path = $pdf_dir . 'commande_' . $id . '.pdf';
echo "Chemin du fichier PDF : " . htmlspecialchars($pdf_path) . "<br>";

// Sauvegardez le PDF
$pdf->Output('F', $pdf_path);
echo "PDF généré avec succès.<br>";

// Redirigez vers le téléchargement
header('Location: /pdf/commande_' . $id . '.pdf');
exit;
?>