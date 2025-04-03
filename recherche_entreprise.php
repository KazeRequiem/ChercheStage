<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(0); // Nécessite permission admin (2)

// Récupérer le paramètre de recherche
$search = $_GET['search'] ?? '';

// Filtrer les entreprises si une recherche est effectuée


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

// Récupérer les paramètres de recherche
$searchName = $_GET['searchName'] ?? '';
$searchLocation = $_GET['searchLocation'] ?? '';

// Filtrer les entreprises si une recherche est effectuée
if (!empty($searchName) || !empty($searchLocation)) {
    $entreprises = array_filter($entreprises, function ($entreprise) use ($searchName, $searchLocation) {
        $matchesName = empty($searchName) || (isset($entreprise['nom']) && stripos($entreprise['nom'], $searchName) !== false);
        $matchesLocation = empty($searchLocation) || (isset($entreprise['localisation']) && stripos($entreprise['localisation'], $searchLocation) !== false);
        return $matchesName && $matchesLocation;
    });
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

if (!empty($search)) {
    $entreprises = array_filter($entreprises, function ($entreprise) use ($search) {
        return stripos($entreprise['name'], $search) !== false ||
            stripos($entreprise['location'], $search) !== false ||
            stripos($entreprise['email'], $search) !== false;
    });
}

// Vérifier si aucune entreprise n'est trouvée
$noResultsMessage = '';
if (empty($entreprises)) {
    $noResultsMessage = 'Aucune entreprise trouvée.';
}

// Rendre le template avec Twig
echo $twig->render('recherche_entreprise.html.twig', [
    'entreprises' => $entreprises,
    'user' => getUserInfo(),
    'search' => $search,
    'noResultsMessage' => $noResultsMessage,
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);