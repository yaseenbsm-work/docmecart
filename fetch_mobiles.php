<?php
header('Content-Type: application/json');

// Include the database connection file
require 'db_connection.php';

// Get the database connection
$conn = getDbConnection();

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
    // Output the SQL error message
    die(json_encode(['error' => 'Error fetching mobile details: ' . $conn->error]));
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
