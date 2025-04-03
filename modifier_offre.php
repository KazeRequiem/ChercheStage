<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite au moins pilote (1)
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé

// Vérifier si l'ID de l'offre est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Erreur : ID offre manquant.');
}

$offreId = $_GET['id'];
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$offreId";

try {
    $offre = fetchApiData($apiUrl);
    echo $twig->render('modifier_offre.html.twig', ['offer' => $offre]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin'],
        'id_entreprise' => $_POST['id_entreprise'],
        'type_contrat' => $_POST['type_contrat'],
        'salaire' => $_POST['salaire']
    ];

    $apiUrlUpdate = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$offreId";
    
    try {
        updateApiData($apiUrlUpdate, $updatedData);
        header("Location: gestion_offres.php?success=1");
        exit;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

if (isset($_POST['delete'])) {
    $apiUrlDelete = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$offreId";
    
    try {
        deleteApiData($apiUrlDelete);
        header("Location: gestion_offres.php?deleted=1");
        exit;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}