<?php
// Fichier: api_controller.php

/**
 * Classe contrôleur pour centraliser les requêtes API
 */
class ApiController {
    private $baseUrl;
    
    /**
     * Constructeur
     * @param string $baseUrl L'URL de base de l'API
     */
    public function __construct($baseUrl = 'https://web4all-api.alwaysdata.net/api/controller') {
        $this->baseUrl = $baseUrl;
    }
    
    /**
     * Récupérer des données via GET
     * @param string $endpoint Point d'accès de l'API
     * @return array Données retournées par l'API
     */
    public function get($endpoint) {
        $url = $this->baseUrl . '/' . $endpoint;
        return $this->sendRequest($url, 'GET');
    }
    
    /**
     * Créer une ressource via POST
     * @param string $endpoint Point d'accès de l'API
     * @param array $data Données à envoyer
     * @return array Réponse de l'API
     */
    public function post($endpoint, $data) {
        $url = $this->baseUrl . '/' . $endpoint;
        return $this->sendRequest($url, 'POST', $data);
    }
    
    /**
     * Mettre à jour une ressource via PUT
     * @param string $endpoint Point d'accès de l'API
     * @param array $data Données à mettre à jour
     * @return array Réponse de l'API
     */
    public function put($endpoint, $data) {
        $url = $this->baseUrl . '/' . $endpoint;
        return $this->sendRequest($url, 'PUT', $data);
    }
    
    /**
     * Supprimer une ressource via DELETE
     * @param string $endpoint Point d'accès de l'API
     * @return array Réponse de l'API
     */
    public function delete($endpoint) {
        $url = $this->baseUrl . '/' . $endpoint;
        return $this->sendRequest($url, 'DELETE');
    }
    
    /**
     * Envoyer une requête à l'API
     * @param string $url URL complète
     * @param string $method Méthode HTTP (GET, POST, PUT, DELETE)
     * @param array $data Données à envoyer (optionnel)
     * @return array Réponse de l'API
     * @throws Exception En cas d'erreur
     */
    private function sendRequest($url, $method, $data = null) {
        $ch = curl_init($url);
        
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false, // Désactivé pour le développement local uniquement
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ];
        
        if ($data !== null) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new Exception('Erreur cURL : ' . curl_error($ch));
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $decodedResponse = json_decode($response, true);
        
        // Vérifier les codes d'erreur HTTP
        if ($httpCode >= 400) {
            $errorMessage = isset($decodedResponse['message']) 
                ? $decodedResponse['message'] 
                : "Erreur API (Code: $httpCode)";
            throw new Exception($errorMessage);
        }
        
        return $decodedResponse;
    }
}
