<?php
include_once __DIR__ . "configs/database.php";

function getUsers()
{
    $users = [
        [
            "name" => "John Doe",
            "age" => 30,
            "email" => "john@example.com",
        ],
        [
            "name" => "Jane Smith",
            "age" => 25,
            "email" => "jane@example.com",
        ],
        [
            "name" => "Michael Johnson",
            "age" => 35,
            "email" => "michael@example.com",
        ],
    ];
    return $users;
}

function getUser($id)
{
    $user = [
        "name" => "Michael Johnson",
        "age" => 35,
        "email" => "michael@example.com",
    ];
    return $user;
}

function countUsers()
{
    return 3;
}
