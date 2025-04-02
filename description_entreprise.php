<?php
require_once 'check_session.php';
checkPermission(0); // Nécessite permission admin (2)
require_once 'init.php';


// Données dynamiques de l'entreprise
$entreprise = [
    'name' => 'Thales',
    'email' => 'thales@gmail.com',
    'rating' => 4.7,
    'phone' => '09 92 38 49 23',
    'candidates' => 6,
    'location' => 'Hénin-Beaumont',
    'logo' => 'assets/thales-logo.png',
    'description' => 'CESI, école d’ingénieurs habilitée par la CTI, forme depuis plus de 60 ans des ingénieurs polyvalents et adaptés aux besoins des entreprises. Avec un réseau de 25 campus en France, CESI s’engage à accompagner ses étudiants vers l’excellence professionnelle.',
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
];

// Rendre le template avec Twig
echo $twig->render('description_entreprise.html.twig', [
    'entreprise' => $entreprise,
        'user' => getUserInfo(),
]);