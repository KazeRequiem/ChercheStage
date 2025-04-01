<?php
require_once 'init.php';

// Données dynamiques pour l'entreprise
$company = [
    'name' => 'Thales',
    'location' => 'Maubeuge',
    'email' => 'poulet@maillot.com',
];

// Rendre le template avec Twig
echo $twig->render('modifier_entreprise.html.twig', [
    'company' => $company,
]);