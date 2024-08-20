<?php
// get_mobile.php
require 'db_connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter is required.']);
    exit;
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if ($id === false) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid ID parameter.']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT * FROM mobiles WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $mobile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($mobile) {
        echo json_encode($mobile);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Mobile not found.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

