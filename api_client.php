<?php

/**
 * Effectue une requête GET vers une API et retourne les données décodées.
 *
 * @param string $url L'URL de l'API.
 * @param array $headers Les en-têtes HTTP à inclure dans la requête.
 * @return array Les données décodées en tableau associatif.
 * @throws Exception Si une erreur cURL ou JSON survient.
 */
function fetchApiData(string $url, array $headers = []): array
{
    // Vérification de la présence du PHPSESSID dans les cookies
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception("Erreur : PHPSESSID non défini dans les cookies.");
    }

    // Initialiser cURL
    $ch = curl_init();

    // Configuration des options cURL
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL si nécessaire
        CURLOPT_HTTPHEADER => array_merge($headers, [
            "Content-type: application/json"
        ]),
        CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Inclure le cookie PHPSESSID
    ]);

    // Exécuter la requête
    $response = curl_exec($ch);

    // Gérer les erreurs cURL
    if (curl_errno($ch)) {
        $errorMessage = 'Erreur cURL : ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($errorMessage);
    }

    // Fermer la session cURL
    curl_close($ch);

    // Décoder la réponse JSON
    $data = json_decode($response, true);

    // Vérifier les erreurs de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erreur lors du décodage JSON : ' . json_last_error_msg());
    }

    // Vérifier si l'API a renvoyé une erreur
    if (isset($data['error'])) {
        throw new Exception('Erreur API : ' . $data['error']);
    }

    return $data;
}

/**
 * Effectue une requête POST vers une API et retourne les données décodées.
 *
 * @param string $url L'URL de l'API.
 * @param array $data Les données à envoyer dans le corps de la requête.
 * @param array $headers Les en-têtes HTTP à inclure dans la requête.
 * @return array Les données décodées en tableau associatif.
 * @throws Exception Si une erreur cURL ou JSON survient.
 */
function postApiData(string $url, array $data, array $headers = []): array
{
    // Vérification de la présence du PHPSESSID dans les cookies
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception("Erreur : PHPSESSID non défini dans les cookies.");
    }

    // Initialiser cURL
    $ch = curl_init();

    // Configuration des options cURL
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL si nécessaire
        CURLOPT_HTTPHEADER => array_merge($headers, [
            "Content-Type: application/json",
            "Accept: application/json"
        ]),
        CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Inclure le cookie PHPSESSID
    ]);

    // Exécuter la requête
    $response = curl_exec($ch);

    // Gérer les erreurs cURL
    if (curl_errno($ch)) {
        $errorMessage = 'Erreur cURL : ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($errorMessage);
    }

    // Fermer la session cURL
    curl_close($ch);

    // Décoder la réponse JSON
    $data = json_decode($response, true);

    // Vérifier les erreurs de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erreur lors du décodage JSON : ' . json_last_error_msg());
    }

    // Vérifier si l'API a renvoyé une erreur
    if (isset($data['error'])) {
        throw new Exception('Erreur API : ' . $data['error']);
    }

    return $data;
}

function updateApiData(string $url, array $data): void
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    curl_close($ch);
}

function deleteApiData(string $url): void
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    curl_close($ch);
}
