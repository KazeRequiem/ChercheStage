<?php
require_once 'check_session.php';
checkPermission(0); // Seulement pour étudiants (permission 0)
require_once 'init.php';

// Si le formulaire n'a pas été soumis, on affiche le template
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo $twig->render('profil_etudiant.html.twig', [
        'student' => [
            'lastName' => $_SESSION['user']['nom'] ?? 'Nom non défini',
            'firstName' => $_SESSION['user']['prenom'] ?? 'Prénom non défini',
            'email' => $_SESSION['user']['email'] ?? 'Email non défini',
            'promotion' => $_SESSION['user']['promotion'] ?? 'Promotion non définie',
        ],
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
    exit();
}

// Traitement du formulaire POST
try {
    // Récupération et validation des données
    $requiredFields = ['objet', 'corp'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Le champ $field est obligatoire");
        }
    }

    // Préparation des données pour l'API
    $data = [
        'objet' => $_POST['objet'],
        'corp' => $_POST['corp'],
        'id_user' => $_SESSION['user']['id_user'] ?? null, // ID de l'utilisateur connecté
    ];

    // Vérification de la présence du PHPSESSID dans les cookies
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception("Erreur : PHPSESSID non défini dans les cookies.");
    }

    // Appel à l'API
    $ch = curl_init('https://web4all-api.alwaysdata.net/api/controller/ticket.php');
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
    if ($httpCode === 200 || $httpCode === 201) {
        // On peut vérifier si la réponse contient un ID de ticket pour confirmer la création
        $responseData = json_decode($response, true);
        
        if (isset($responseData['id_ticket'])) {
            $success = 'Votre ticket a été envoyé avec succès.';
        } else {
            $success = 'Votre ticket a été envoyé, mais aucune confirmation n\'a été reçue.';
        }
    } else {
        $errorData = json_decode($response, true);
        throw new Exception($errorData['message'] ?? "Erreur API (Code $httpCode): " . $response);
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche le formulaire avec le message d'erreur
    $error = $e->getMessage();
}

// Rendre le template avec Twig
echo $twig->render('profil_etudiant.html.twig', [
    'student' => [
        'lastName' => $_SESSION['user']['nom'] ?? 'Nom non défini',
        'firstName' => $_SESSION['user']['prenom'] ?? 'Prénom non défini',
        'email' => $_SESSION['user']['email'] ?? 'Email non défini',
        'promotion' => $_SESSION['user']['promotion'] ?? 'Promotion non définie',
    ],
    'user' => getUserInfo(),
    'error' => $error ?? null,
    'success' => $success ?? null,
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
]);