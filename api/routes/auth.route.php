<?php

include_once ROOT . "/controllers/auth.php";
/* Place all the middlewares above your function for example the isGET & verifyJWT */
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
