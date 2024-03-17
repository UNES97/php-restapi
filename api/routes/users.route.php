<?php

include_once ROOT . "/controllers/users.php";
/* Place all the middlewares above your function for example the isGET & verifyJWT */
switch ($endpoint) {
    case "":
    case "users":
        isGET();
        verifyJWT();
        $response = getUsers();
        break;
    case "user":
        isGET();
        verifyJWT();
        $response = getUser();
        break;
    case "count":
        isGET();
        verifyJWT();
        $response = countUsers();
        break;
    case "create":
        isPOST();
        verifyJWT();
        $response = insertUser();
        break;
    default:
        $response = endpointNotFound();
}

echo json_encode($response, JSON_PRETTY_PRINT);
