<?php
require_once 'init.php';

// URL de votre API
$apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/entreprise.php/entreprises';

// Initialisation de cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // À n'utiliser qu'en développement

// Exécution de la requête
$response = curl_exec($ch);

if (curl_errno($ch)) {
    die('Erreur cURL : ' . curl_error($ch));
}

curl_close($ch);

// Décodage de la réponse JSON
$entreprises = json_decode($response, true);

// Vérification des données reçues
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Erreur de décodage JSON : ' . json_last_error_msg());
}

// Formatage des données pour Twig
$offers = [];
foreach ($entreprises as $entreprise) {
    $offers[] = [
        'title' => $entreprise['nom'] ?? 'Nom non disponible',
        'company' => $entreprise['email'] ?? 'Entreprise inconnue',
        'contractType' => $entreprise['description'] ?? 'Type non spécifié',
        'salary' => $entreprise['tel'] ?? 'Salaire non communiqué',
        'location' => $entreprise['localisation'] ?? 'Localisation inconnue',
        'logo' => $entreprise['logo'] ?? 'default-logo.png',
    ];
}

// Rendre le template avec Twig
echo $twig->render('page_recherche.html.twig', [
    'offers' => $offers,
]);