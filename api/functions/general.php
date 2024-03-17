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

function parseEnvFile($filePath)
{
    $envData = [];
    if (file_exists($filePath)) {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (
                strpos(trim($line), "=") !== false &&
                substr(trim($line), 0, 1) !== "#"
            ) {
                list($key, $value) = explode("=", $line, 2);
                $key = trim($key);
                $value = trim($value);
                if (
                    substr($value, 0, 1) === '"' &&
                    substr($value, -1) === '"'
                ) {
                    $value = substr($value, 1, -1);
                }
                $envData[$key] = $value;
            }
        }
    }
    return $envData;
}
