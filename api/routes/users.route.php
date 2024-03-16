<?php

include_once ROOT . "/functions/users.php";
include_once ROOT . "/functions/helpers.php";

switch ($endpoint) {
    case "":
    case "users":
        $response = getUsers();
        break;
    case "user":
        $response = getUser();
        break;
    case "count":
        $response = countUsers();
        break;
    default:
        $response = endpointNotFound();
}

echo json_encode($response);
