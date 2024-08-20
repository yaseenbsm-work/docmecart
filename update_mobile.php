<?php
// Database connection details
$host = 'localhost'; // Your database host
$db = 'own_cart'; // Your database name
$user = 'yaseen'; // Your database user
$pass = 'Yaseen@123'; // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Retrieve POST data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$field = isset($_POST['field']) ? $conn->real_escape_string($_POST['field']) : '';
$value = isset($_POST['value']) ? $conn->real_escape_string($_POST['value']) : '';

// Validate the inputs
if (!$id || !$field || !$value) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

// Prepare and execute the update query
$allowedFields = ['name', 'price', 'rating']; // Fields that can be updated
if (in_array($field, $allowedFields)) {
    // Handle numeric values
    if ($field === 'price') {
        $value = number_format((float)$value, 2, '.', ''); // Ensure two decimal places
        $stmt = $conn->prepare("UPDATE mobiles SET `$field` = ? WHERE id = ?");
        $stmt->bind_param('di', $value, $id); // 'd' for double, 'i' for integer
    } elseif ($field === 'rating') {
        $value = number_format((float)$value, 1, '.', ''); // Ensure one decimal place
        $stmt = $conn->prepare("UPDATE mobiles SET `$field` = ? WHERE id = ?");
        $stmt->bind_param('di', $value, $id); // 'd' for double, 'i' for integer
    } else {
        $stmt = $conn->prepare("UPDATE mobiles SET `$field` = ? WHERE id = ?");
        $stmt->bind_param('si', $value, $id); // 's' for string, 'i' for integer
    }

    if ($stmt) {
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error executing query: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid field.']);
}

// Close the connection
$conn->close();
?>
