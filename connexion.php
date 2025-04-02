<?php
require_once 'init.php';

// Désactivation de la session auto pour pouvoir forcer le cookie
ini_set('session.auto_start', '0');

// Force l'ID de session avant de démarrer la session
session_id('6ccbe552eb1dbabae49ba23ab35226e4');
session_start();

// Force le cookie manuellement (identique à l'ID de session)
setcookie(
    "PHPSESSID",
    '6ccbe552eb1dbabae49ba23ab35226e4',
    [
        'expires' => time() + 3600,
        'path' => '/',
        'domain' => '.web4all-api.alwaysdata.net',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None'
    ]
);
$_COOKIE['PHPSESSID'] = '6ccbe552eb1dbabae49ba23ab35226e4';

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
            'method' => 'POST',
            'content' => json_encode($data),
            'ignore_errors' => true
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);

    if ($result === false) {
        $_SESSION['login_error'] = "Erreur de connexion au serveur";
        header("Location: connexion.php");
        exit();
    }

    $response_headers = $http_response_header ?? [];

    // On conserve la vérification du cookie de l'API mais on le force quand même
    foreach ($response_headers as $header) {
        if (preg_match('/^Set-Cookie:\s*PHPSESSID=([^;]+)/', $header, $matches)) {
            // On réapplique notre cookie forcé même si l'API en envoie un différent
            setcookie(
                "PHPSESSID",
                'c9d94a35dec5a54eada0c8566c47476e',
                [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'domain' => '.web4all-api.alwaysdata.net',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'None'
                ]
            );
            $_COOKIE['PHPSESSID'] = 'c9d94a35dec5a54eada0c8566c47476e';
            break;
        }
    }

    $response = json_decode($result, true);

    if ($response && isset($response['user'])) {
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

        $_SESSION['user'] = [
            'id' => $response['user']['id'],
            'email' => $response['user']['email'],
            'prenom' => $response['user']['prenom'],
            'nom' => $response['user']['nom'],
            'role' => $role,
            'permission' => $response['user']['permission'],
            'homePage' => $homePage,
        ];

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