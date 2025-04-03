<?php
/**
 * Fichier delete_api.php
 * Permet d'effectuer des requêtes API avec la méthode DELETE
 */

/**
 * Effectue une requête DELETE vers une API
 * 
 * @param string $url URL de l'API
 * @param array $headers En-têtes HTTP additionnels (optionnel)
 * @return array Réponse de l'API décodée
 * @throws Exception En cas d'erreur
 */
function deleteApi(string $url, array $headers = []): array {
    // Vérifier si le cookie de session existe
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception('Session non valide. Veuillez vous reconnecter.');
    }

    // Initialiser la session cURL
    $ch = curl_init($url);

    // Configurer les options cURL
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL
        CURLOPT_HTTPHEADER => array_merge($headers, [
            "Content-Type: application/json",
            "Accept: application/json",
        ]),
        CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Transmettre le cookie de session
    ]);

    // Exécuter la requête
    $response = curl_exec($ch);

    // Gérer les erreurs cURL
    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    // Récupérer le code HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Décoder la réponse JSON
    $decodedResponse = json_decode($response, true);

    // Vérifier le code HTTP
    if ($httpCode >= 400) {
        $errorMessage = $decodedResponse['error'] ?? "Erreur HTTP $httpCode";
        throw new Exception("Erreur API : $errorMessage");
    }

    return $decodedResponse ?: [];
}