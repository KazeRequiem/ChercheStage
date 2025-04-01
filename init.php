<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('Templates'); // Assurez-vous que ce chemin est correct
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Vous pouvez activer le cache en remplaçant `false` par un chemin vers un dossier de cache
]);