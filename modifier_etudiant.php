<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)

// Données dynamiques de l'étudiant
$etudiant = [
    'nom' => 'Jack',
    'prenom' => 'Bob',
    'promotion' => 'CPIA1',
    'email' => 'poulet@maillot.com',
    'telephone' => '07 89 88 88 88',
    '07/89/2333' => '08/99/2929',
];

// Rendre le template avec Twig
echo $twig->render('modifier_etudiant.html.twig', [
    'etudiant' => $etudiant,
]);