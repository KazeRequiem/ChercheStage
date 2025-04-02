<?php
require_once 'check_session.php';
checkPermission(1); // Vérifie que c'est un admin
require_once 'init.php';

// Vérification de la présence du PHPSESSID dans les cookies
if (!isset($_COOKIE['PHPSESSID'])) {
    die("Erreur : PHPSESSID non défini dans les cookies.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données envoyées par le formulaire
    $data = [
        'nom' => $_POST['nom'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telephone' => $_POST['telephone'] ?? '',
        'localisation' => $_POST['localisation'] ?? '',
        'description' => $_POST['description'] ?? '',
        'ville' => $_POST['ville'] ?? '',
        'code_postal' => $_POST['code_postal'] ?? '',
        'pays' => $_POST['pays'] ?? '',
    ];

    // Validation des données
    if (empty($data['nom']) || empty($data['email']) || empty($data['telephone'])) {
        die('Nom, email, et téléphone sont obligatoires.');
    }

    $apiUrl = "https://web4all-api.alwaysdata.net/api/controller/entreprise.php";

    // Initialisation de cURL
    $ch = curl_init();

    // Configuration des options cURL
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "PHPSESSID: " . $_COOKIE['PHPSESSID']
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL si nécessaire

    // Exécution de la requête cURL
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Vérification des erreurs
    if (curl_errno($ch)) {
        echo 'Erreur cURL : ' . curl_error($ch);
    } else {
        if ($httpCode === 201) {
            // Redirection en cas de succès
            header('Location: gestion_entreprise.php');
            exit;
        } else {
            // Affichage des erreurs en cas d'échec
            echo "Code HTTP: " . $httpCode . "<br>";
            echo "Réponse API: " . $response . "<br>";
            die('Erreur lors de l\'ajout de l\'entreprise.');
        }
    }

    // Fermeture de la session cURL
    curl_close($ch);
}

// Rendu du template Twig
echo $twig->render('ajouter_entreprise.html.twig', []);
?>