<?php
/**
 * Fichier update_api.php
 * Permet d'effectuer des requêtes API avec la méthode PUT
 */

/**
 * Effectue une requête PUT vers une API
 * 
 * @param string $url URL de l'API
 * @param array $data Données à envoyer
 * @param array $headers En-têtes HTTP additionnels (optionnel)
 * @return array Réponse de l'API décodée
 * @throws Exception En cas d'erreur
 */
function updateApi(string $url, array $data, array $headers = []): array {
    // Initialiser la session cURL
    $ch = curl_init($url);
    
    // Configurer les options cURL
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL si nécessaire
        CURLOPT_HTTPHEADER => array_merge($headers, [
            "Content-Type: application/json"
        ]),
        CURLOPT_COOKIE => isset($_COOKIE['PHPSESSID']) ? 'PHPSESSID=' . $_COOKIE['PHPSESSID'] : '', // Inclure le cookie PHPSESSID s'il existe
    ]);
    
    // Exécuter la requête
    $response = curl_exec($ch);
    
    // Gérer les erreurs cURL
    if (curl_errno($ch)) {
        $errorMessage = 'Erreur cURL : ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($errorMessage);
    }
    
    // Récupérer le code HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Fermer la session cURL
    curl_close($ch);
    
    // Décoder la réponse JSON
    $decodedResponse = json_decode($response, true);
    
    // Vérifier les erreurs de décodage JSON
    if ($response && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erreur lors du décodage JSON : ' . json_last_error_msg());
    }
    
    // Vérifier le code HTTP
    if ($httpCode >= 400) {
        $errorMessage = isset($decodedResponse['error']) ? $decodedResponse['error'] : 'Erreur HTTP ' . $httpCode;
        throw new Exception('Erreur API : ' . $errorMessage);
    }
    
    // Vérifier si l'API a renvoyé une erreur
    if (isset($decodedResponse['error'])) {
        throw new Exception('Erreur API : ' . $decodedResponse['error']);
    }
    
    return $decodedResponse ?: [];
}

/**
 * Exemple d'utilisation
 */
/*
try {
    $apiUrl = 'https://api.example.com/resources/123';
    $updateData = [
        'name' => 'Nouveau nom',
        'description' => 'Nouvelle description'
    ];
    $customHeaders = [
        'Authorization: Bearer YOUR_TOKEN'
    ];
    
    $result = updateApi($apiUrl, $updateData, $customHeaders);
    echo "Mise à jour réussie: " . print_r($result, true);
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
*/
?>