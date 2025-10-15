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

// Check if username already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0){
    echo json_encode(["status"=>"error", "message"=>"Username already exists"]);
    exit();
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username,password,role) VALUES (?,?,?)");
$stmt->bind_param("sss", $username, $hashedPassword, $role);
if($stmt->execute()){
    echo json_encode(["status"=>"success", "message"=>"User registered successfully"]);
}else{
    echo json_encode(["status"=>"error", "message"=>"Registration failed"]);
}
?>

