<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin
require_once 'init.php';
require_once 'update_api.php'; // Inclure la fonction updateApi
require_once 'delete_api.php'; // Inclure la fonction deleteApi

// Vérifier si l'ID de l'étudiant est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    if (isset($_POST['etudiant_id']) && !empty($_POST['etudiant_id'])) {
        $etudiantId = $_POST['etudiant_id'];
    } else {
        die('Erreur : ID de l\'étudiant manquant.');
    }
} else {
    $etudiantId = $_GET['id'];
}

$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$etudiantId";

try {
    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier si c'est une suppression
        if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            // Récupérer l'ID de l'étudiant
            $etudiantId = $_POST['etudiant_id'] ?? null;

            if (!$etudiantId) {
                throw new Exception('ID de l\'étudiant manquant pour la suppression.');
            }

            // Construire l'URL de l'API
            $deleteUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$etudiantId";

            // Effectuer la requête DELETE via l'API
            $response = deleteApi($deleteUrl);

            // Vérifier si la suppression a réussi
            if (isset($response['success']) && $response['success'] === true) {
                // Rediriger avec un message de succès
                header("Location: /gestion_etudiant.php?success=1");
                exit;
            } else {
                throw new Exception('Erreur lors de la suppression.');
            }
        }

        // Logique de mise à jour (si ce n'est pas une suppression)
        $updateData = [
            'prenom' => $_POST['prenom'] ?? '',
            'nom' => $_POST['nom'] ?? '',
            'email' => $_POST['email'] ?? '',
            'telephone' => $_POST['telephone'] ?? '',
            'datenaissance' => $_POST['datenaissance'] ?? '',
            'promotion' => $_POST['promotion'] ?? '',
        ];

        $response = updateApi($apiUrl, $updateData);

        if (isset($response['success']) && $response['success'] === true) {
            header("Location: /gestion_etudiant.php");
            exit;
        } else {
            throw new Exception('Erreur lors de la mise à jour.');
        }
    }

    // Récupérer les données actuelles de l'étudiant via l'API
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

    $etudiant = json_decode($response, true);

    if (!$etudiant || !isset($etudiant['id_user'])) {
        throw new Exception('Impossible de récupérer les données de l\'étudiant ou ID manquant.');
    }

    // Rendre le template avec Twig
    echo $twig->render('modifier_etudiant.html.twig', [
        'etudiant' => $etudiant, // Doit contenir les données de l'étudiant, y compris 'id_user'
        'user' => getUserInfo(),
        'success' => $_GET['success'] ?? null,
        'error' => $_GET['error'] ?? null,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php',
    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    echo $twig->render('modifier_etudiant.html.twig', [
        'error' => $e->getMessage(),
    ]);
}