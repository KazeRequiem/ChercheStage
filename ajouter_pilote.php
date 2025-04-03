<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin
require_once 'init.php';

// Si le formulaire n'a pas été soumis, on affiche le template
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo $twig->render('ajouter_pilote.html.twig', [
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
    exit();
}

// Traitement du formulaire POST
try {
    // Récupération et validation des données
    $requiredFields = ['prenom', 'nom', 'email', 'motdepasse', 'telephone', 'datenaissance', 'promotion'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Le champ $field est obligatoire");
        }
    }

    // Préparation des données pour l'API avec "sans promotion" en dur
    $data = [
        'prenom' => $_POST['prenom'],
        'nom' => $_POST['nom'],
        'email' => $_POST['email'],
        'mdp' => $_POST['motdepasse'],
        'tel' => $_POST['telephone'],
        'date_naissance' => $_POST['datenaissance'],
        'permission' => '1',
        'id_promotion' => $_POST['promotion'],
        'nom_promotion' => 'sans promotion' // Fixé comme demandé
    ];

    // Vérification de la présence du PHPSESSID dans les cookies
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception("Erreur : PHPSESSID non défini dans les cookies.");
    }

    // Appel à l'API
    $ch = curl_init('https://web4all-api.alwaysdata.net/api/controller/user.php');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL
        CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'] // Transmettre le cookie de session
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL: ' . curl_error($ch));
    }

    curl_close($ch);

    // Traitement de la réponse
    // Considère à la fois 200 (OK) et 201 (Created) comme des succès
    if ($httpCode === 200 || $httpCode === 201) {
        // On peut vérifier si la réponse contient bien un id_user pour confirmer la création
        $responseData = json_decode($response, true);
        if (isset($responseData['id_user'])) {
            header('Location: gestion_pilote.php');
            exit();
        }
    }

    $errorData = json_decode($response, true);
    throw new Exception($errorData['message'] ?? "Erreur API (Code $httpCode): " . $response);

} catch (Exception $e) {
    // En cas d'erreur, on réaffiche le formulaire avec le message d'erreur
    echo $twig->render('gestion_pilote.html.twig', [
        'user' => getUserInfo(),
        'formData' => $_POST,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
    exit();
}