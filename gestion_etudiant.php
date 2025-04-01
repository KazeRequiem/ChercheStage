<?php
require_once 'init.php';

// Données dynamiques pour les étudiants
$students = [
    [
        'lastName' => 'Castagnette',
        'firstName' => 'Baptiste',
        'promotion' => 'AR4JPO1',
        'location' => 'Arras',
    ],
    [
        'lastName' => 'Dupont',
        'firstName' => 'Marie',
        'promotion' => 'AR4JPO2',
        'location' => 'Lille',
    ],
    // Ajoutez d'autres étudiants ici
];

// Rendre le template avec Twig
echo $twig->render('gestion_etudiant.html.twig', [
    'students' => $students,
]);