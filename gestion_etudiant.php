<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)
require_once 'init.php';

// Données dynamiques pour les étudiants
$students = [
    [
        'lastName' => 'Castagnette',
        'firstName' => 'Baptiste',
        'promotion' => 'AR4JPO1',
        'location' => 'Arras',
        'editLink' => 'modifier_etudiant.php',
    ],
    [
        'lastName' => 'Dupont',
        'firstName' => 'Marie',
        'promotion' => 'AR4JPO2',
        'location' => 'Lille',
        'editLink' => 'modifier_etudiant.php',
    ],
    // Ajoutez d'autres étudiants ici
];

// Récupérer le paramètre de recherche
$search = $_GET['search'] ?? '';

// Filtrer les étudiants si une recherche est effectuée
if (!empty($search)) {
    $students = array_filter($students, function ($student) use ($search) {
        return stripos($student['firstName'], $search) !== false ||
               stripos($student['lastName'], $search) !== false ||
               stripos($student['promotion'], $search) !== false;
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
    'user' => getUserInfo(),
]);