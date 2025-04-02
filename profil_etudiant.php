<?php
// Vérification en premier
require_once 'check_session.php';
checkPermission(0); // Seulement pour étudiants (permission 0)
require_once 'init.php';

// Récupération des données de session
$userInfo = getUserInfo();

// Données spécifiques à la vue étudiant
$student = [
    'lastName' => $userInfo['nom'] ?? 'Nom non défini',
    'firstName' => $userInfo['prenom'] ?? 'Prénom non défini',
    'email' => $userInfo['email'] ?? 'Email non défini',
    'school' => 'Arras', // À remplacer par $userInfo['school'] si disponible
    'promotion' => 'CPA2 Informatique' // À remplacer par donnée réelle
];

echo $twig->render('profil_etudiant.html.twig', [
    'student' => $student,
    'user' => $userInfo,
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);