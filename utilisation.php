<?php
require_once 'init.php';

// Données dynamiques pour la politique d'utilisation
$policy = [
    'sections' => [
        ['title' => 'Introduction', 'content' => 'La présente politique d\'utilisation définit les règles...'],
        ['title' => 'Accès aux Services', 'content' => 'L\'accès à nos services est réservé aux utilisateurs...'],
        ['title' => 'Utilisation Acceptable', 'content' => 'Vous vous engagez à utiliser nos services de manière conforme...'],
        ['title' => 'Responsabilités', 'content' => 'Web4All décline toute responsabilité en cas d\'utilisation inappropriée...'],
        ['title' => 'Modifications', 'content' => 'Nous nous réservons le droit de modifier cette politique...'],
    ],
];

// Rendre le template avec Twig
echo $twig->render('utilisation.html.twig', [
    'policy' => $policy,
]);