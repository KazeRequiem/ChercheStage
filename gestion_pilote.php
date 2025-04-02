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
        'firstName' => 'Melih',
        'editLink' => 'modifier_pilote.php',
    ],
    // Ajoutez d'autres pilotes ici
];

// Récupérer le paramètre de recherche
$search = $_GET['search'] ?? '';

// Filtrer les pilotes si une recherche est effectuée
if (!empty($search)) {
    $pilotes = array_filter($pilotes, function ($pilote) use ($search) {
        return stripos($pilote['firstName'], $search) !== false || stripos($pilote['promotion'], $search) !== false;
    });
}

// Rendre le template avec Twig
echo $twig->render('gestion_pilote.html.twig', [
    'user' => $user,
    'pilotes' => $pilotes,
    'search' => $search,
]);