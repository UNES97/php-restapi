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

function initCORS()
{
    global $envData;
    if ($envData["ALLOWED_DOMAINS"] == "*") {
        header("Access-Control-Allow-Origin: *");
    } else {
        /* Remove square brackets and split the string into an array & Trim */
        $allowed_domains_string = trim($envData["ALLOWED_DOMAINS"], "[]");
        $allowed_domains = explode(",", $allowed_domains_string);
        $allowed_domains = array_map("trim", $allowed_domains);

        /* Get the referring domain from the HTTP referer header */
        $referer = isset($_SERVER["HTTP_REFERER"])
            ? parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST)
            : "";

        if (!empty($referer) && in_array($referer, $allowed_domains)) {
            header("Access-Control-Allow-Origin: $referer");
        } else {
            echo json_encode([
                "statusCode" => 403,
                "message" => "Access denied",
            ]);
            exit();
        }
    }
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}

function encrypt($text)
{
    try {
        global $envData;
        $secretKey = $envData["SECRET_KEY"];
        $secretKey = hash("sha256", $secretKey);

        $iv = openssl_random_pseudo_bytes(16);
        /* Encrypt the text using AES-256-CBC cipher */
        $encrypted = openssl_encrypt(
            $text,
            "aes-256-cbc",
            hex2bin($secretKey),
            OPENSSL_RAW_DATA,
            $iv
        );
        if ($encrypted == false) {
            throw new Exception("Encryption error");
        }
        return [
            "iv" => bin2hex($iv),
            "encryptedText" => bin2hex($encrypted),
        ];
    } catch (Exception $e) {
        error_log("Encryption error: " . $e->getMessage());
        throw $e;
    }
}

function decrypt($encryptedData)
{
    try {
        global $envData;
        $secretKey = $envData["SECRET_KEY"];
        $secretKey = hash("sha256", $secretKey);

        /* Convert iv from hex to binary */
        $iv = hex2bin($encryptedData["iv"]);

        /* Decrypt the encrypted text using AES-256-CBC cipher */
        $decrypted = openssl_decrypt(
            hex2bin($encryptedData["encryptedText"]),
            "aes-256-cbc",
            hex2bin($secretKey),
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($decrypted == false) {
            throw new Exception("Decryption error");
        }
        return $decrypted;
    } catch (Exception $e) {
        error_log("Decryption error: " . $e->getMessage());
        throw $e;
    }
}
