<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];

// Check if email already exists
$sql_check = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // Email already exists
    echo "Error: The email address '$email' is already in use.";
} else {
    // Insert new user if email is unique
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully";
        // Redirect to index.php after successful insertion
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
