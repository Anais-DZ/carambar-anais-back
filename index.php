<?php
// MISE EN PLACE DE L'API

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// INCLUDES
include './env.php';
include 'controller/controllerJoke.php';

// Vérification de la méthode
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée.", "code" => 405]);
    return;
}

// Connexion BDD avec try/catch
try {
    $bdd = new PDO(
        'mysql:host=' . $_ENV['dbhost'] . ';dbname=' . $_ENV['dbname'] . ';charset=utf8mb4',
        $_ENV['dblogin'],
        $_ENV['dbpassword'],
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Erreur de connexion à la base de données']);
    error_log('Erreur BDD : ' . $e->getMessage());
    exit;
}

// Récupération URL
$url = parse_url($_SERVER['REQUEST_URI']);

// Analyser l'intérieur de l'url pour récupérer le path (path = la partie de l'url se trouvant après le nom de domaine)
$path = isset($url['path']) ? $url['path'] :'';

// Nettoyage de l'URL (supprime le chemin du projet si nécessaire)
$path = str_replace('/carambar-projet', '', $path);
$path = rtrim($path, '/');

// Routing
switch ($path) {
    case '/blagues':
        $controller = new JokeController($bdd);
        $controller->getAllJokes($bdd);
        break;

    case '/blagues/random':
        $controller = new JokeController($bdd);
        $controller->getRandomJoke($bdd);
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Route non trouvée']);
        break;
}
