<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    require_once 'database.php';
    $database = new Database();
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
            $name = trim($_POST['name'] ?? '');
            $age = (int)($_POST['age'] ?? 0);
            
            if (empty($name) || $age <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid input data']);
                exit;
            }
            
            if ($database->addUser($name, $age)) {
                echo json_encode(['success' => true, 'message' => 'User added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add user']);
            }
            break;
            
        case 'toggle':
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
                exit;
            }
            
            if ($database->toggleUserStatus($id)) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update status']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    
    if ($action === 'get') {
        $users = $database->getAllUsers();
        echo json_encode(['success' => true, 'users' => $users]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>