<?php

function endpointNotFound()
{
    return [
        "statusCode" => 404,
        "message" => "Endpoint not found",
    ];
}

function checkItemNotEmptyOrNull($item)
{
    return $item !== null && $item !== "";
}

function checkPayloadNotEmpty($payload)
{
    foreach ($payload as $key => $value) {
        if (empty($value)) {
            return false;
        }
    }
    return true;
}

function isPOST()
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo json_encode([
            "statusCode" => 405,
            "message" => "Method not allowed",
        ]);
        exit();
    }
}

function isGET()
{
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        echo json_encode([
            "statusCode" => 405,
            "message" => "Method not allowed",
        ]);
        exit();
    }
}
