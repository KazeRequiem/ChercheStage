<?php
// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie les permissions de l'utilisateur
 * @param int $requiredPermission Niveau de permission requis (0=candidat, 1=pilote, 2=admin)
 */
function checkPermission($requiredPermission) {
    // Vérifier si la session user existe
    if (empty($_SESSION['user'])) {
        if (!headers_sent()) {
            header("Location: connexion.php?error=session_required");
            exit();
        }
        die("Session invalide. Veuillez vous reconnecter.");
    }

    // Vérifier si la permission existe
    if (!isset($_SESSION['user']['permission'])) {
        if (!headers_sent()) {
            header("Location: connexion.php?error=invalid_permission");
            exit();
        }
        die("Permission non définie.");
    }

    // Vérifier la permission
    if ((int)$_SESSION['user']['permission'] < (int)$requiredPermission) {
        $_SESSION['access_error'] = [
            'required' => $requiredPermission,
            'actual' => $_SESSION['user']['permission']
        ];
        
        if (!headers_sent()) {
            header("Location: unauthorized.php");
            exit();
        }
        die("Permission insuffisante.");
    }
}

/**
 * Récupère les infos utilisateur
 * @return array|null
 */
function getUserInfo() {
    return $_SESSION['user'] ?? null;
}

function checkRole($requiredRole) {
    // Vérifie si l'utilisateur a le rôle exact requis
    if (empty($_SESSION['user']) || $_SESSION['user']['permission'] != $requiredRole) {
        $_SESSION['access_error'] = [
            'required_role' => $requiredRole,
            'actual_role' => $_SESSION['user']['permission'] ?? null
        ];
        
        if (!headers_sent()) {
            header("Location: unauthorized.php");
            exit();
        }
        die("Accès réservé aux candidats.");
    }
}