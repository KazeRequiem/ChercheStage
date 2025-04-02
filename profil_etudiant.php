<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(0); // Nécessite permission admin (2)

// Données dynamiques pour le profil étudiant
$student = [
    'lastName' => 'Castagnette',
    'firstName' => 'Bob',
    'email' => 'bob.castagnette@viacesi.fr',
    'school' => 'Arras',
    'promotion' => 'CPA2 Informatique',
];

// Rendre le template avec Twig
echo $twig->render('profil_etudiant.html.twig', [
    'student' => $student,
    'user' => getUserInfo(),
]);