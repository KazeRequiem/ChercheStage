<?php
require_once 'init.php';

// Données des entreprises
$entreprises = [
    [
        'name' => 'Thales',
        'email' => 'thales@gmail.com',
        'rating' => 4.7,
        'phone' => '09 92 38 49 23',
        'candidates' => 6,
        'location' => 'Hénin-Beaumont',
        'logo' => 'assets/thales-logo.png',
        'link' => 'description_entreprise.php?id=1',
    ],
    [
        'name' => 'Dassault',
        'email' => 'dassault@gmail.com',
        'rating' => 4.5,
        'phone' => '01 23 45 67 89',
        'candidates' => 10,
        'location' => 'Paris',
        'logo' => 'assets/dassault-logo.png',
        'link' => 'description_entreprise.php?id=2',
    ],
    [
        'name' => 'Airbus',
        'email' => 'airbus@gmail.com',
        'rating' => 4.8,
        'phone' => '02 98 76 54 32',
        'candidates' => 15,
        'location' => 'Toulouse',
        'logo' => 'assets/airbus-logo.png',
        'link' => 'description_entreprise.php?id=3',
    ],
];

// Rendre le template avec Twig
echo $twig->render('recherche_entreprise.html.twig', [
    'entreprises' => $entreprises,
]);