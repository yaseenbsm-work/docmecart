<?php
header('Content-Type: application/json');

// Database connection settings
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

// Get parameters
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'price-asc';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 7;

$offset = ($page - 1) * $itemsPerPage;

// Determine sorting order
switch ($sort) {
    case 'price-asc':
        $sortQuery = 'ORDER BY price ASC';
        break;
    case 'price-desc':
        $sortQuery = 'ORDER BY price DESC';
        break;
    case 'rating-asc':
        $sortQuery = 'ORDER BY rating ASC';
        break;
    case 'rating-desc':
        $sortQuery = 'ORDER BY rating DESC';
        break;
    default:
        $sortQuery = 'ORDER BY price ASC'; // Default sorting
}

// Construct SQL query
$sql = "SELECT * FROM mobiles WHERE name LIKE '%$search%' $sortQuery LIMIT $itemsPerPage OFFSET $offset";

// Execute query
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die(json_encode(['error' => $conn->error]));
}

// Fetch results
$mobiles = array();
while ($row = $result->fetch_assoc()) {
    $mobiles[] = $row;
}

// Output JSON
echo json_encode($mobiles);

// Close connection
$conn->close();

