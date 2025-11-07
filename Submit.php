<?php
// Database connection details - change according to your RDS setup
$host = "database-1.cje4q6ikyasa.ap-south-1.rds.amazonaws.com";  // e.g., mydb.abc123xyz.us-east-1.rds.amazonaws.com
$user = "root";
$pass = "7620692525";
$dbname = "aditya";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'] ?? '';
$password = $_POST['password'] ?? '';

// Simple validation
if (empty($name) || empty($password)) {
    die("Name and Password are required!");
}

// Hash password before storing (important for security)
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare SQL query
$stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $hashedPassword);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>