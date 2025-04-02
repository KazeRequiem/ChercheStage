<?php
require_once 'init.php';

// Données dynamiques pour la page "Qui sommes-nous"
$company = [
    'story' => 'Fondée en 2015 par une équipe de professionnels passionnés...',
    'values' => [
        ['title' => 'Innovation', 'description' => 'L\'innovation est au cœur de notre ADN...'],
        ['title' => 'Accessibilité', 'description' => 'Nous concevons nos plateformes avec une exigence d\'accessibilité...'],
        ['title' => 'Excellence', 'description' => 'La recherche de l\'excellence guide chacune de nos actions...'],
        ['title' => 'Engagement', 'description' => 'Notre engagement envers nos clients et utilisateurs est total...'],
    ],
    'expertiseDescription' => 'Fort d\'une équipe pluridisciplinaire de 45 collaborateurs...',
    'expertiseAreas' => [
        ['title' => 'Développement de plateformes digitales', 'description' => 'Conception et déploiement de solutions web...'],
        ['title' => 'Intelligence artificielle et matching', 'description' => 'Développement d\'algorithmes avancés...'],
        ['title' => 'Analyse de données RH', 'description' => 'Exploitation et interprétation des données...'],
        ['title' => 'Conseil et accompagnement', 'description' => 'Accompagnement personnalisé des établissements...'],
    ],
    'clientsDescription' => 'Web4All accompagne plus de 120 établissements...',
];

// Rendre le template avec Twig
echo $twig->render('qui_sommes_nous.html.twig', [
    'company' => $company,
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);