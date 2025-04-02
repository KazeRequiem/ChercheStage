<?php
require_once 'check_session.php';
checkPermission(2); // Seulement pour admin (permission 2)
require_once 'init.php';

$userInfo = getUserInfo();

$admin = [
    'lastName' => $userInfo['nom'] ?? 'Nom admin',
    'firstName' => $userInfo['prenom'] ?? 'Prénom admin',
    'email' => $userInfo['email'] ?? 'Email admin',
    'school' => 'Toutes écoles', // Spécifique admin
    'permissions' => 'Completes' // Champ spécifique
];

echo $twig->render('profil_admin.html.twig', [
    'admin' => $admin,
    'user' => $userInfo
]);