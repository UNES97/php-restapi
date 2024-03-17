<?php

include_once ROOT . "/controllers/users.php";

switch ($endpoint) {
    case "":
    case "users":
        isGET();
        $response = getUsers();
        break;
    case "user":
        isGET();
        $response = getUser();
        break;
    case "count":
        isGET();
        $response = countUsers();
        break;
    case "create":
        isPOST();
        $response = insertUser();
        break;
    default:
        $response = endpointNotFound();
}

echo json_encode($response, JSON_PRETTY_PRINT);
