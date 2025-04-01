<?php
require_once 'init.php';

// Données dynamiques du pilote
$pilote = [
    'nom' => 'Jack',
    'prenom' => 'Bob',
    'etablissement' => 'Maubeuge',
    'email' => 'poulet@maillot.com',
];

// Rendre le template avec Twig
echo $twig->render('modifier_pilote.html.twig', [
    'pilote' => $pilote,
]);