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

// Retrieve form data
$name = $_POST['name'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$photo = $_FILES['photo']['tmp_name'];

// Read image file and encode as base64
$photoContent = file_get_contents($photo);
$photoBase64 = base64_encode($photoContent);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO mobiles (name, price, rating, photo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sdds", $name, $price, $rating, $photoBase64);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

// Close the connection
$stmt->close();
$conn->close();

?>
