<?php
// L'ordre est important !
require_once 'check_session.php';
checkPermission(1); // Seulement pour pilotes (permission 1)
require_once 'init.php';

$userInfo = getUserInfo();

$pilot = [
    'lastName' => $userInfo['nom'] ?? 'Nom non défini',
    'firstName' => $userInfo['prenom'] ?? 'Prénom non défini',
    'email' => $userInfo['email'] ?? 'Email non défini',
    'school' => 'Arras',
    'promotions' => ['CPA2 Informatique', 'CPA1 Informatique', 'CPA3 Informatique']
];

echo $twig->render('profil_pilote.html.twig', [
    'pilot' => $pilot,
    'user' => $userInfo // N'oubliez pas de passer userInfo au template
]);