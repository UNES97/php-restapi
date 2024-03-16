<?php

$connection = new SQLite3(
    "demo_api.db",
    SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE
);
