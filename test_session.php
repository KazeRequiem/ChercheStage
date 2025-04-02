<?php
header("Content-Type: application/json");

function isSessionValid() {
    $apiUrl = "https://web4all-api.alwaysdata.net/test_session.php";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return isset($data['session_active']) && $data['session_active'] === true ? $data : ["error" => "Session inactive"];
    }

    return ["error" => "Non xd ntm"];
}

// Renvoie le résultat en JSON
echo json_encode(isSessionValid());
?>
