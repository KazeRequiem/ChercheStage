<?php
require_once 'init.php';

// Données dynamiques à passer au template
$user = [
    'firstName' => 'Lukas',
];

$stats = [
    'responseRate' => 26,
    'offersCount' => 4,
    'studentsPlaced' => 36,
    'responseChange' => '+4',
    'offersChange' => '0%',
    'studentsChange' => '-23',
];

// Rendre le template avec Twig
echo $twig->render('accueil_admin.html.twig', [
    'user' => $user,
    'stats' => $stats,
]);