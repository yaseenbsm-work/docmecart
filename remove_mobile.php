<?php
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "yaseen";
$password = "Yaseen@123";
$dbname = "own_cart";

// remove_mobile.php
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    // Connect to your database
    $mysqli = new mysqli("localhost", "username", "password", "database");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("DELETE FROM mobiles WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to remove mobile"]);
    }

    $stmt->close();
    $mysqli->close();
}
?>
