<?php
require_once 'init.php';

session_start();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Adresse-Mail'])) {
    $email = $_POST['Adresse-Mail'];
    $password = $_POST['MDP'];

    // Appel à l'API
    $apiUrl = 'https://web4all-api.alwaysdata.net/api/auth/login.php';
    $data = [
        'email' => $email,
        'mdp' => $password
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
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

    $response = json_decode($result, true);

    // Vérification de la réponse
    if ($response && isset($response['user'])) {
        // Déterminer le rôle selon permission
        $role = match($response['user']['permission']) {
            1 => 'pilote',
            2 => 'admin',
            default => 'candidat'
        };

        // Création de la session
        $_SESSION['user'] = [
            'id' => $response['user']['id'],
            'email' => $response['user']['email'],
            'prenom' => $response['user']['prenom'],
            'nom' => $response['user']['nom'],
            'role' => $role,
            'permission' => $response['user']['permission']
        ];

        // Redirection selon le rôle
        header("Location: accueil_$role.php");
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