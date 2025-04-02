<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)

// Rendre le template avec Twig
echo $twig->render('ajouter_entreprise.html.twig', [
    'user' => getUserInfo(),
]);