<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Get form data
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$website = $_POST['website'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO quotes (name, number, email, website) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $number, $email, $website);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Quote request submitted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
