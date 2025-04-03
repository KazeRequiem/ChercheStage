<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite au moins pilote (1)
require_once 'init.php';

// Vérifier si l'ID de l'offre est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    if (isset($_POST['offre_id']) && !empty($_POST['offre_id'])) {
        $offreId = $_POST['offre_id'];
    } else {
        die('Erreur : ID de l\'offre manquant.');
    }
} else {
    $offreId = $_GET['id'];
}

$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$offreId";

try {
    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier si c'est une suppression
        if (isset($_POST['delete']) && $_POST['delete'] === '1') {
            // Construire l'URL de l'API pour la suppression
            $deleteUrl = $apiUrl;

            // Effectuer la requête DELETE via cURL
            $ch = curl_init($deleteUrl);
            curl_setopt_array($ch, [
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
                CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Transmettre le cookie de session
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 && $httpCode !== 201) {
                throw new Exception("Erreur API : Code HTTP $httpCode");
            }

            // Rediriger avec un message de succès
            header("Location: /gestion_offre.php?success=1");
            exit;
        }

        // Logique de mise à jour (si ce n'est pas une suppression)
        $updateData = [
            'titre' => $_POST['titre'] ?? '',
            'description' => $_POST['description'] ?? '',
            'date_debut' => $_POST['date_debut'] ?? '',
            'date_fin' => $_POST['date_fin'] ?? '',
            'id_entreprise' => $_POST['id_entreprise'] ?? '',
            'type_contrat' => $_POST['type_contrat'] ?? '',
            'salaire' => $_POST['salaire'] ?? '',
        ];

        // Valider les données avant l'envoi
        foreach ($updateData as $key => $value) {
            if (empty($value)) {
                throw new Exception("Erreur : Le champ $key est requis.");
            }
        }

        // Effectuer la requête PUT via cURL
        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($updateData),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Transmettre le cookie de session
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Erreur cURL : ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 && $httpCode !== 201) {
            throw new Exception("Erreur API : Code HTTP $httpCode");
        }

        // Rediriger avec un message de succès
        header("Location: /gestion_offre.php?success=1");
        exit;
    }

    // Récupérer les données actuelles de l'offre via l'API
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception('Session non valide. Veuillez vous reconnecter.');
    }

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
        ],
        CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Transmettre le cookie de session
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 && $httpCode !== 201) {
        throw new Exception("Erreur API : Code HTTP $httpCode");
    }

    $offre = json_decode($response, true);

    if (!$offre || !isset($offre['id_offre'])) {
        throw new Exception('Impossible de récupérer les données de l\'offre ou ID manquant.');
    }

    // Rendre le template avec Twig
    echo $twig->render('modifier_offre.html.twig', [
        'offre' => $offre, // Doit contenir les données de l'offre
        'user' => getUserInfo(),
        'success' => $_GET['success'] ?? null,
        'error' => $_GET['error'] ?? null,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php',
    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    echo $twig->render('modifier_offre.html.twig', [
        'error' => $e->getMessage(),
    ]);
}