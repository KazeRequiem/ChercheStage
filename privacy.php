<?php
require_once 'vendor/autoload.php';

// Configurer Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/Templates');
$twig = new \Twig\Environment($loader);

// Données dynamiques (si nécessaire)
$data = [
    'email_contact' => 'confidentialite@web4all.com',
];

// Rendre le template Twig
echo $twig->render('privacy.html.twig', $data);