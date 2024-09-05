<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Get form data
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prepare and bind the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO contact (name, surname, email, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $surname, $email, $message);

$response = [];
if ($stmt->execute()) {
    header("Location:thank.html");
} else {
    $response['status'] = 'error';
    $response['message'] = $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Return JSON response
echo json_encode($response);
?>
