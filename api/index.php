<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/api");

$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

$uriSegments = explode("/", rtrim($requestUri, "/"));
$t = count($uriSegments);
$routeParent = $uriSegments[$t - ($t - 1)];
$endpoint = end($uriSegments);

$routes = ["users"];

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
