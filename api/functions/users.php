<?php
include_once ROOT . "/configs/database.php";

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
    } catch (Exception $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong {$e->getMessage()}",
        ];
    }
}

function getUser()
{
    try {
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
    } catch (Exception $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$e->getMessage()}",
        ];
    }
}

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
    } catch (Exception $e) {
        return [
            "statusCode" => 500,
            "message" => "Something went wrong : {$e->getMessage()}",
        ];
    }
}
