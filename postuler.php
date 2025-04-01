<?php
require_once 'init.php';

// Données dynamiques pour l'offre
$offer = [
    'title' => 'Concepteur Développeur d\'Application',
];

// Rendre le template avec Twig
echo $twig->render('postuler.html.twig', [
    'offer' => $offer,
]);