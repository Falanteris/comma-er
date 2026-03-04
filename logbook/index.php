<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "secret";
$dbname = "LogbookDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// THE VULNERABILITY: Taking input directly from the URL query string
// Example: lookup.php?id=1
$user_id = $_GET['id'];

// THE INJECTION POINT: String concatenation in the SQL query
$sql = "SELECT username, email FROM users WHERE id = ?";

// safer method
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "User: " . $row["username"] . " - Email: " . $row["email"] . "<br>";
  }
} else {
  echo "No user found.";
}

$conn->close();
?>