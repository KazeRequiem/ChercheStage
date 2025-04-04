<?php
/**
 * Contrôleur de favoris
 * Gère les favoris des utilisateurs (affichage et suppression)
 */

require_once 'check_session.php';
require_once 'init.php';
require_once 'api_client.php';
require_once 'delete_api.php'; // Inclure la fonction deleteApi

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

// Récupérer l'ID de l'utilisateur actuel
$id_user = $_SESSION['user']['id'];

// Récupérer les favoris de l'utilisateur
function getFavoris($id_user) {
    try {
        $url = "https://web4all-api.alwaysdata.net/api/controller/favoris.php/favoris";
        $favoris = fetchApiData($url);

        // Filtrer les favoris par utilisateur
        $userFavoris = array_filter($favoris, function($item) use ($id_user) {
            return $item['id_user'] == $id_user;
        });

        return $userFavoris;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Récupérer l'ID de l'offre s'il est passé en POST
$id_offre = isset($_POST['id_offre']) ? $_POST['id_offre'] : null;

// var_dump($_POST);
// var_dump($id_user);
// var_dump($id_offre);

// Récupérer les détails d'une offre par son ID
function getOffreDetails($id_offre) {
    try {
        $url = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$id_offre";
        return fetchApiData($url);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


// Supprimer un favori
function deleteFavori($id_offre, $id_user) {
    try {
        $url = "https://web4all-api.alwaysdata.net/api/controller/favoris.php?id_offre=$id_offre&id_user=$id_user";
        return deleteApi($url);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Traitement des requêtes
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        // Obtenir la liste des favoris
        $userFavoris = getFavoris($id_user);
        $favorisWithDetails = [];

        foreach ($userFavoris as $favori) {
            $offreDetails = getOffreDetails($favori['id_offre']);

            if (isset($offreDetails['error'])) {
                $favorisWithDetails[] = ['error' => "Erreur lors de la récupération de l'offre #" . $favori['id_offre']];
            } else {
                $formattedOffre = [
                    'id' => $offreDetails['id'] ?? null,
                    'title' => $offreDetails['titre'] ?? 'Titre non disponible',
                    'description' => $offreDetails['description'] ?? 'Description non disponible',
                    'startDate' => $offreDetails['date_debut'] ?? null,
                    'endDate' => $offreDetails['date_fin'] ?? null,
                    'companyId' => $offreDetails['id_entreprise'] ?? null,
                    'contractType' => $offreDetails['type_contrat'] ?? 'Type de contrat non disponible',
                    'salary' => $offreDetails['salaire'] ?? 'Salaire non spécifié'
                ];

                $favorisWithDetails[] = $formattedOffre;
            }
        }

        // Définir le message si aucun favori n'est trouvé
        $noResultsMessage = "Vous n'avez pas encore ajouté d'offres à vos favoris.";

        // Charger la vue Twig avec les données
        echo $twig->render('candidatures_favoris.html.twig', [
            'favoris' => $favorisWithDetails,
            'noResultsMessageFavoris' => $noResultsMessage
        ]);
        break;

    case 'POST':
        // Supprimer un favori
        if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $id_offre = $_POST['id_offre'] ?? null;

            if (!$id_offre) {
                echo json_encode(['error' => 'ID de l\'offre manquant pour la suppression']);
                exit;
            }

            $response = deleteFavori($id_offre, $id_user);

            if (isset($response['error'])) {
                echo json_encode(['error' => $response['error']]);
            } else {
                header('Location: candidatures_favoris.php');
                exit;
            }
        }

        echo json_encode(['error' => 'Requête POST invalide']);
        break;

    default:
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}