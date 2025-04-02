<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(0); // Nécessite permission admin (2)

// Données dynamiques pour l'offre
$offer = [
    'title' => 'Développeur Full Stack H/F',
    'company' => 'CESI',
    'location' => 'Arras',
    'contractType' => 'CDI',
    'salary' => '~35k',
    'startDate' => '01/01/2025',
    'endDate' => '31/12/2025',
    'details' => 'Au sein de l’un de nos clients du secteur Télécom...',
    'objectives' => [
        'Écriture des spécifications fonctionnelles sur la base de l’existant.',
        'Maquettage.',
        'Développement d’une vue consolidée de plusieurs index.',
        'Participation à la refonte de l’interface graphique.',
    ],
    'reasons' => [
        'Un cadre de travail stimulant et innovant.',
        'Des projets impactants au service de l’éducation et de l’industrie.',
        'Une culture d’entreprise collaborative et tournée vers l’avenir.',
    ],
    'skills' => [
        'Compétences en développement d’applications web et backend.',
        'Maîtrise des langages : C++, Python, Java.',
        'Expérience avec Git et GitLab.',
    ],
    'logo' => 'thales-logo.png',
    'companyDescription' => 'CESI, école d’ingénieurs habilitée par la CTI...',
];

// Rendre le template avec Twig
echo $twig->render('offre_emploi.html.twig', [
    'offer' => $offer,
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);