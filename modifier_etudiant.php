<?php
require_once 'init.php';

// Données dynamiques de l'étudiant
$etudiant = [
    'nom' => 'Jack',
    'prenom' => 'Bob',
    'etablissement' => 'Maubeuge',
    'email' => 'poulet@maillot.com',
];

// Rendre le template avec Twig
echo $twig->render('modifier_etudiant.html.twig', [
    'etudiant' => $etudiant,
]);