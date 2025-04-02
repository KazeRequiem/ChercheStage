<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé

// URL de l'API pour récupérer les étudiants
$apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/user.php/users';

try {
    // URL de l'API pour récupérer les étudiants
    $apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/user.php/users';

    // Récupérer les données de l'API
    $users = fetchApiData($apiUrl);

    // Filtrer pour ne garder que les étudiants (permission: 0)
    $students = array_filter($users, function ($user) {
        return isset($user['permission']) && $user['permission'] === 0;
    });

    // Récupérer le paramètre de recherche
    $search = $_GET['search'] ?? '';

    // Filtrer les étudiants si une recherche est effectuée
    if (!empty($search)) {
        $students = array_filter($students, function ($student) use ($search) {
            return stripos($student['prenom'], $search) !== false ||
                   stripos($student['nom'], $search) !== false;
        });
    }

    // Vérifier si aucun étudiant n'est trouvé
    $noResultsMessage = '';
    if (empty($students)) {
        $noResultsMessage = 'Aucun étudiant trouvé.';
    }

    // Rendre le template avec Twig
    echo $twig->render('gestion_etudiant.html.twig', [
        'students' => $students,
        'user' => getUserInfo(),
        'search' => $search,
        'noResultsMessage' => $noResultsMessage,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    die('Erreur : ' . $e->getMessage());
}