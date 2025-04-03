<?php
/**
 * Contrôleur de favoris
 * Gère les favoris des utilisateurs
 */

// Inclusion du client API
require_once 'check_session.php';
checkPermission(2); // Nécessite permission admin (2)
require_once 'init.php';
require_once 'api_client.php';

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

// Récupérer les détails d'une offre par son ID
function getOffreDetails($id_offre) {
    try {
        $url = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$id_offre";
        return fetchApiData($url);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Ajouter un favori
function addFavori($id_offre, $id_user) {
    try {
        $url = "https://web4all-api.alwaysdata.net/api/controller/favoris.php?id_offre=$id_offre&id_user=$id_user";
        $response = fetchApiData($url);
        return ['success' => true, 'message' => 'Favori ajouté avec succès'];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Supprimer un favori
function deleteFavori($id_offre, $id_user) {
    try {
        $url = "https://web4all-api.alwaysdata.net/api/controller/favoris.php/delete?id_offre=$id_offre&id_user=$id_user";
        $response = fetchApiData($url);
        return ['success' => true, 'message' => 'Favori supprimé avec succès'];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Traitement des requêtes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtenir la liste des favoris avec les détails des offres
        $userFavoris = getFavoris($id_user);
        $favorisWithDetails = [];
        
        foreach ($userFavoris as $favori) {
            $offreDetails = getOffreDetails($favori['id_offre']);
            
            if (isset($offreDetails['error'])) {
                $favorisWithDetails[] = ['error' => "Erreur lors de la récupération de l'offre #" . $favori['id_offre']];
            } else {
                // Formater les données pour correspondre au format attendu par le template Twig
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
        
        // Si c'est une requête AJAX, retourner les données en JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($favorisWithDetails);
            exit;
        }
        
        // Sinon, charger la vue Twig avec les données // Assurez-vous d'inclure votre configuration Twig
        echo $twig->render('candidatures_favoris.html.twig', [
            'favoris' => $favorisWithDetails,
            'noResultsMessageFavoris' => $noResultsMessage,
            'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

        ]);
        break;
        
    case 'POST':
        // Ajouter un favori
        if (isset($_GET['id_offre'])) {
            $id_offre = $_GET['id_offre'];
            $result = addFavori($id_offre, $id_user);
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'ID d\'offre non spécifié']);
        }
        break;
        
    case 'DELETE':
        // Supprimer un favori
        if (isset($_GET['id_offre'])) {
            $id_offre = $_GET['id_offre'];
            $result = deleteFavori($id_offre, $id_user);
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'ID d\'offre non spécifié']);
        }
        break;
        
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}