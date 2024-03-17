<?php

function signInUser()
{
    global $connection;
    $username = $_POST["username"];
    $password = $_POST["password"];

    $statement = $connection->prepare(
        "SELECT id, username, password FROM users WHERE username = :username"
    );
    $statement->bindParam(":username", $username);
    $result = $statement->execute();

    if ($row = $result->fetchArray()) {
        $userId = $row["id"];
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            $payload = ["userID" => $userId, "username" => $username];
            $jwtToken = generateJWT($payload);
            $connection->close();
            return [
                "statusCode" => 200,
                "accessToken" => $jwtToken,
            ];
        }
    }

    $connection->close();
    return [
        "statusCode" => 205,
        "message" => "Invalid username or password, Try again",
    ];
}
