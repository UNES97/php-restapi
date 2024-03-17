<?php

include_once ROOT . "/functions/users.php";

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

echo json_encode($response);
