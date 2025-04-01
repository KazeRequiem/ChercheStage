<?php
require_once 'init.php';

// Données dynamiques des tickets
$tickets = [
    [
        'id' => 1,
        'demandeur' => 'Jean Dupont',
        'titre' => 'Problème de connexion',
        'dateCreation' => '2025-03-30',
        'etat' => 'Non résolu',
        'action' => 'Marquer comme résolu',
    ],
    [
        'id' => 2,
        'demandeur' => 'Marie Curie',
        'titre' => 'Erreur sur le profil',
        'dateCreation' => '2025-03-29',
        'etat' => 'Résolu',
        'action' => 'Marquer comme non résolu',
    ],
    // Ajoutez d'autres tickets ici
];

// Rendre le template avec Twig
echo $twig->render('ticket.html.twig', [
    'tickets' => $tickets,
]);