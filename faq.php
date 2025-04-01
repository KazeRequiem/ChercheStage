<?php
require_once 'vendor/autoload.php';

// Configurer Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/Templates');
$twig = new \Twig\Environment($loader);

// Données dynamiques pour le template
$data = [
    'questions' => [
        [
            'question' => 'Comment créer un compte ?',
            'answer' => 'Pour créer un compte, cliquez sur « Accéder à mon espace » sur la page d’accueil et suivez les instructions.',
        ],
        [
            'question' => 'Comment postuler à une offre ?',
            'answer' => 'Une fois connecté, vous pouvez consulter les offres et postuler en quelques clics.',
        ],
        [
            'question' => 'Est-ce que l\'inscription est gratuite ?',
            'answer' => 'Oui, l\'inscription est entièrement gratuite pour les candidats.',
        ],
        [
            'question' => 'Comment contacter un recruteur ?',
            'answer' => 'Vous pouvez contacter un recruteur directement via la messagerie intégrée après avoir postulé à une offre.',
        ],
        [
            'question' => 'Comment supprimer mon compte ?',
            'answer' => 'Vous pouvez demander la suppression de votre compte dans les paramètres de votre profil.',
        ],
        
    ],
    'recommended' => [
        'Optimiser votre profil pour attirer les recruteurs',
        'Comment bien rédiger une candidature ?',
        'Gérer vos notifications et alertes',
        'Sécuriser votre compte et vos données',
    ],
];

// Rendre le template Twig
echo $twig->render('faq.html.twig', $data);