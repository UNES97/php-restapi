<?php

/* Get users */
function getUsers()
{
    $data = [];
    try {
        global $connection;
        $query = "SELECT id, username, email, created_at FROM users";
        $statement = $connection->prepare($query);
        $result = $statement->execute();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        $result->finalize();
        return [
            "statusCode" => 200,
            "data" => $data,
        ];
    } catch (PDOException $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong {$e->getMessage()}",
        ];
    } catch (Exception $f) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$f->getMessage()}",
        ];
    }
}

/* Get user by ID */
function getUser()
{
    try {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            global $connection;
            $query = $connection->prepare(
                "SELECT  id, username, email, created_at FROM users WHERE id = :id"
            );
            $query->bindParam(":id", $id);
            $result = $query->execute();
            $data = $result->fetchArray(SQLITE3_ASSOC);
            $result->finalize();
            return [
                "statusCode" => 200,
                "data" => $data,
            ];
        } else {
            return [
                "statusCode" => 200,
                "message" => "Invalid ID, please re-check",
            ];
        }
    } catch (PDOException $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$e->getMessage()}",
        ];
    } catch (Exception $f) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$f->getMessage()}",
        ];
    }
}

/* Get users count */
function countUsers()
{
    try {
        global $connection;
        $query = $connection->prepare(
            "SELECT  COUNT(id) AS totalUsers FROM users"
        );
        $result = $query->execute();
        $data = $result->fetchArray(SQLITE3_ASSOC);
        $result->finalize();
        return [
            "statusCode" => 200,
            "data" => $data,
        ];
    } catch (PDOException $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$e->getMessage()}",
        ];
    } catch (Exception $f) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$f->getMessage()}",
        ];
    }
}

/* Create a user */
function insertUser()
{
    global $connection;
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    try {
        if (checkPayloadNotEmpty([$username, $email, $password])) {
            return [
                "statusCode" => 205,
                "message" => "Please check your payload",
            ];
        } else {
            $query = $connection->prepare(
                "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, :created_at)"
            );
            $query->bindParam(":username", $username);
            $query->bindParam(":email", $email);
            $query->bindParam(
                ":password",
                password_hash($password, PASSWORD_DEFAULT)
            );
            $query->bindParam(":created_at", date("Y-m-d H:i:s"));
            if ($query->execute()) {
                return [
                    "statusCode" => 200,
                    "message" => "Data created successfully",
                ];
            } else {
                return [
                    "statusCode" => 205,
                    "message" => "Something went wrong while inserting data",
                ];
            }
        }
    } catch (PDOException $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$e->getMessage()}",
        ];
    } catch (Exception $f) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$f->getMessage()}",
        ];
    }
}
