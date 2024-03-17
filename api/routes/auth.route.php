<?php

include_once ROOT . "/controllers/auth.php";

switch ($endpoint) {
    case "":
    case "login":
        isPOST();
        $response = signInUser();
        break;
    default:
        $response = endpointNotFound();
}

echo json_encode($response, JSON_PRETTY_PRINT);
