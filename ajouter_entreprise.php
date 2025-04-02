<?php
require_once 'init.php';
require_once 'check_session.php';

// Vérification des permissions d'utilisateur
checkPermission(1); // Nécessite une permission administrateur (1)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données envoyées par le formulaire
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $localisation = $_POST['localisation'] ?? '';
    $description = $_POST['description'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $code_postal = $_POST['code_postal'] ?? '';
    $pays = $_POST['pays'] ?? '';

    // Validation des données (vous pouvez ajouter plus de validations selon les besoins)
    if (empty($nom) || empty($email) || empty($telephone)) {
        die('Nom, email, et téléphone sont obligatoires.');
    }

    // Préparation des données à envoyer à l'API
    $data = [
        'nom' => $nom,
        'email' => $email,
        'telephone' => $telephone,
        'localisation' => $localisation,
        'description' => $description,
        'ville' => $ville,
        'code_postal' => $code_postal,
        'pays' => $pays,
    ];

    // Initialisation de la requête cURL pour envoyer les données à l'API
    $ch = curl_init('https://web4all-api.alwaysdata.net/api/controller/entreprise.php');
    
    // Configuration des options cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Access-Control-Allow-Origin: *', // CORS
        'Access-Control-Allow-Methods: GET, POST, PUT, DELETE', // CORS
        'Access-Control-Allow-Headers: Content-Type, Authorization' // CORS
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactive la vérification SSL, à activer pour la prod

    // Exécution de la requête
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Gestion des erreurs cURL
    if (curl_errno($ch)) {
        curl_close($ch);
        die('Erreur cURL : ' . curl_error($ch));
    }
    curl_close($ch);

    // Vérification de la réponse de l'API
    if ($httpCode === 201) {
        header('Location: gestion_entreprise.php');
        exit;
    } else {
        // Affichez plus de détails sur l'erreur
        echo "Code HTTP: " . $httpCode . "<br>";
        echo "Réponse API: " . $response . "<br>";
        die('Erreur lors de l\'ajout de l\'entreprise.');
    }
}

// Rendu du template Twig
echo $twig->render('ajouter_entreprise.html.twig', [
    'user' => getUserInfo(),
]);