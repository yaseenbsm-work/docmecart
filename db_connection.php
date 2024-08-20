<?php
// db_connection.php

function getDbConnection() {
    $servername = "localhost";
    $username = "yaseen";
    $password = "Yaseen@123";
    $dbname = "own_cart";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die(json_encode(['error' => $conn->connect_error]));
    }

    return $conn;
}
