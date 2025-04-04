<?php
require_once 'init.php';

// Rendre le template avec Twig
echo $twig->render('notre_mission.html.twig',[
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php',
]
);