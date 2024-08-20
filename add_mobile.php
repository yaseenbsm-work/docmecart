<?php
$servername = "localhost";
$username = "yaseen";
$password = "Yaseen@123";
$dbname = "own_cart";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$photo = $_POST['photo'];
$name = $_POST['name'];
$price = floatval($_POST['price']);
$rating = floatval($_POST['rating']);

$sql = "INSERT INTO mobiles (photo, name, price, rating) VALUES ('$photo', '$name', '$price', '$rating')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();