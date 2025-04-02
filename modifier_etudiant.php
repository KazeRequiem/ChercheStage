<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé

// Vérifier si l'ID de l'étudiant est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Erreur : ID étudiant manquant.');
}

$etudiantId = $_GET['id'];
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/user/$etudiantId";

try {
    $etudiant = fetchApiData($apiUrl);
    echo $twig->render('modifier_etudiant.html.twig', ['etudiant' => $etudiant]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'prenom' => $_POST['prenom'],
        'nom' => $_POST['nom'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'datenaissance' => $_POST['datenaissance'],
        'promotion' => $_POST['promotion']
    ];

    $apiUrlUpdate = "https://web4all-api.alwaysdata.net/api/controller/user.php/user/$etudiantId";
    
    try {
        updateApiData($apiUrlUpdate, $updatedData);
        header("Location: gestion_etudiant.php?success=1");
        exit;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

if (isset($_POST['delete'])) {
    $apiUrlDelete = "https://web4all-api.alwaysdata.net/api/controller/user.php/user/$etudiantId";
    
    try {
        deleteApiData($apiUrlDelete);
        header("Location: gestion_etudiant.php?deleted=1");
        exit;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

