<?php
// Ensure that the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if 'id' is provided in the query string
    if (isset($_GET['id'])) {
        $mobileId = intval($_GET['id']);

        // Database connection details
        $servername = 'localhost';
        $username = 'yaseen';
        $password = 'Yaseen@123';
        $dbname = 'own_cart';

        // Create connection
        $mysqli = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        // Prepare and execute the deletion query
        $stmt = $mysqli->prepare('DELETE FROM mobiles WHERE id = ?');
        $stmt->bind_param('i', $mobileId);

        if ($stmt->execute()) {
            // Successful deletion
            $response = ['success' => true];
        } else {
            // Error occurred
            $response = ['success' => false];
        }

        // Close statement and connection
        $stmt->close();
        $mysqli->close();

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // 'id' is not provided
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'No ID provided']);
    }
} else {
    // Invalid request method
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
