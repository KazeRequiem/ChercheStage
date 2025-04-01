<?php
require_once 'init.php';

// Données dynamiques à passer au template
$user = [
    'firstName' => 'Admin',
];

$pilotes = [
    [
        'id' => 1,
        'title' => 'Castagnette bob',
        'location' => 'Arras',
        'promotion' => 'AR4JPO1',
        'firstName' => 'Baptiste',
        'editLink' => 'modifier_pilote.php',
    ],
    [
        'id' => 2,
        'title' => 'Castagnette bob',
        'location' => 'Arras',
        'promotion' => 'AR4JPO1',
        'firstName' => 'Baptiste',
        'editLink' => 'modifier_pilote.php',
    ],
    // Ajoutez d'autres pilotes ici
];

// Rendre le template avec Twig
echo $twig->render('gestion_pilote.html.twig', [
    'user' => $user,
    'pilotes' => $pilotes,
]);