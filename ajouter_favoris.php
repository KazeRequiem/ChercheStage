<?php
// Ajouter un favori
if (isset($_GET['id_offre'])) {
    $idOffre = intval($_GET['id_offre']);

    // URL de l'API pour ajouter un favori
    $addFavorisUrl = "https://web4all-api.alwaysdata.net/api/controller/favoris.php?id_offre=$idOffre&id_user=$userId";

    try {
        // Envoyer une requête à l'API pour ajouter le favori
        $response = fetchApiData($addFavorisUrl);

        // Rediriger vers la page des favoris après l'ajout
        header('Location: candidatures_favoris.php');
        exit;
    } catch (Exception $e) {
        // Gérer les erreurs et afficher un message
        die('Erreur lors de l\'ajout du favori : ' . $e->getMessage());
    }
}