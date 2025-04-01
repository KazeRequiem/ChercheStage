<?php
require_once 'init.php';

// Données dynamiques pour les entreprises
$companies = [
    [
        'name' => 'Thales',
        'location' => 'Hénin-Beaumont',
        'email' => 'thales@gmail.com',
        'phone' => '07 43 54 32 43',
        'logo' => 'thales-logo.png',
    ],
    [
        'name' => 'Airbus',
        'location' => 'Toulouse',
        'email' => 'airbus@gmail.com',
        'phone' => '06 12 34 56 78',
        'logo' => 'airbus-logo.png',
    ],
    [
        'name' => 'Safran',
        'location' => 'Paris',
        'email' => 'safran@gmail.com',
        'phone' => '05 67 89 01 23',
        'logo' => 'safran-logo.png',
    ],
];

// Rendre le template avec Twig
echo $twig->render('gestion_entreprise.html.twig', [
    'companies' => $companies,
]);