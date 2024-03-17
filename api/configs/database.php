<?php

$connection = new SQLite3(
    $envData["DB_NAME"],
    SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE
);
