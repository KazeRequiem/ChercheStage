<?php
require_once 'init.php';

// Données de l'admin
$admin = [
    'lastName' => 'Castagnette',
    'firstName' => 'Bob',
    'email' => 'bob.castagnette@viacesi.fr',
    'school' => 'Arras',
    'promotions' => ['CPA2 Informatique', 'CPA1 Informatique', 'CPA3 Informatique'],
];

// Rendre le template avec Twig
echo $twig->render('profil_admin.html.twig', [
    'admin' => $admin,
]);