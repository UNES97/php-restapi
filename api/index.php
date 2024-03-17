<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/api");
/* Load ENV file */
$envFilePath = ROOT . "/.env";
/* Define routes */
$routes = ["users", "auth"];
/* Define functions files names & Load them */
$functions = ["general"];

foreach ($functions as $f) {
    include_once ROOT . "/functions/{$f}.php";
}

/* Load ENV variables you can access using the variable $envData['Variable_name'] */
$envData = parseEnvFile($envFilePath);

/*
 * Handle CORS (Cross-Origin Resource Sharing) based on allowed domains from environment variable.
 * If ALLOWED_DOMAINS is "*", allow requests from any domain. Otherwise, allow requests only from specified domains.
 */
initCORS();

/* Load database */
include_once ROOT . "/configs/database.php";

/* Load the route based on the Uri  */
$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uriSegments = explode("/", rtrim($requestUri, "/"));
$key = array_search("api", $uriSegments);
if ($key !== false) {
    unset($uriSegments[$key]);
    $uriSegments = array_values($uriSegments);
}

$t = count($uriSegments);
$routeParent = $uriSegments[$t - ($t - 1)];
$endpoint = end($uriSegments);

if (in_array($routeParent, $routes)) {
    include_once ROOT . "/routes/{$routeParent}.route.php";
} else {
    $response = [
        "statusCode" => 404,
        "message" => "Route not found",
    ];
    echo json_encode($response);
    exit();
}
