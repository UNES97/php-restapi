<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/functions/users.php";

switch ($endpoint) {
    case "":
    case "users":
        $data = getUsers();
        $response = [
            "statusCode" => 200,
            "data" => $data,
        ];
        break;
    case "user":
        if (isset($_GET["id"])) {
            $data = getUser($_GET["id"]);
            $response = [
                "statusCode" => 200,
                "data" => $data,
                "userID" => $_GET["id"],
            ];
        } else {
            $response = [
                "statusCode" => 205,
                "message" => "Invalid user ID",
            ];
        }
        break;
    case "count":
        $data = countUsers();
        $response = [
            "statusCode" => 200,
            "data" => $data,
        ];
        break;
    default:
        $response = [
            "statusCode" => 404,
            "message" => "Endpoint not found",
        ];
}

echo json_encode($response);
