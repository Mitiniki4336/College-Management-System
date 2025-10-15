<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "college_system");
if ($conn->connect_error) {
    echo json_encode(["status"=>"error", "message"=>"Database connection failed"]);
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

if (!$username || !$password || !$role) {
    echo json_encode(["status"=>"error", "message"=>"All fields are required"]);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND role=?");
$stmt->bind_param("ss", $username, $role);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(["status"=>"success", "role"=>$role]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Invalid credentials"]);
}
?>

