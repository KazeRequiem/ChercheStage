<?php
require_once 'init.php';

session_start();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Adresse-Mail'])) {
    $email = $_POST['Adresse-Mail'];
    $password = $_POST['MDP'];

    // Appel à l'API pour la connexion
    $apiUrl = 'https://web4all-api.alwaysdata.net/api/auth/login.php';
    $data = [
        'email' => $email,
        'mdp' => $password
    ];

    $options = [
        'http' => [
            'header' => [
                "Content-Type: application/json",
            ],
            'method'  => 'POST',
            'content' => json_encode($data),
            'ignore_errors' => true
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);

    // Vérifier si l'API renvoie un cookie PHPSESSID
    if ($result === false) {
        $_SESSION['login_error'] = "Erreur de connexion au serveur";
        header("Location: connexion.php");
        exit();
    }

    // Récupérer les en-têtes de réponse
    $response_headers = $http_response_header ?? [];

    // Vérification du cookie PHPSESSID
    foreach ($response_headers as $header) {
        if (preg_match('/^Set-Cookie:\s*PHPSESSID=([^;]+)/', $header, $matches)) {
            // Ajoutez Secure, HttpOnly et SameSite=None si cross-domain

        setcookie(
            "PHPSESSID",
            'c9d94a35dec5a54eada0c8566c47476e', // Votre cookie forcé
            [
                'expires'  => time() + 3600,
                'path'     => '/',
                'domain'   => '.web4all-api.alwaysdata.net',
                'secure'   => true,    // Nécessaire si HTTPS
                'httponly' => true,   // Empêche l'accès via JavaScript
                'samesite' => 'None', // Autorise les requêtes cross-origin
            ]
        );
        // Force également la variable $_COOKIE (pour prise en compte immédiate)
        $_COOKIE['PHPSESSID'] = 'c9d94a35dec5a54eada0c8566c47476e';
            break;
        }
    }

    $response = json_decode($result, true);

    // Vérification de la réponse de l'API
    if ($response && isset($response['user'])) {
        // Déterminer le rôle selon permission
        $role = match($response['user']['permission']) {
            1 => 'pilote',
            2 => 'admin',
            default => 'candidat'
        };

        $homePage = match($response['user']['permission']) {
            1 => 'accueil_pilote.php',
            2 => 'accueil_admin.php',
            default => 'accueil_candidat.php'
        };

        // Création de la session
        $_SESSION['user'] = [
            'id' => $response['user']['id'],
            'email' => $response['user']['email'],
            'prenom' => $response['user']['prenom'],
            'nom' => $response['user']['nom'],
            'role' => $role,
            'permission' => $response['user']['permission'],
            'homePage' => $homePage,
        ];

        // Redirection selon le rôle
        header("Location: $homePage");
        exit();
    } else {
        $_SESSION['login_error'] = $response['message'] ?? "Identifiants incorrects";
        header("Location: connexion.php");
        exit();
    }
}

// Préparation des données pour Twig
$data = [];
if (isset($_SESSION['login_error'])) {
    $data['error'] = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

// Rendu du template
echo $twig->render('connexion.html.twig', $data);
