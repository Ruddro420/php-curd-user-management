<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];

// Handle image upload
$image = $_FILES['image']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($image);

// Check if email already exists
$sql_check = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // Email already exists
    echo "Error: The email address '$email' is already in use.";
} else {
    // Upload image
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert new user if email is unique and image is uploaded
        $sql = "INSERT INTO users (name, email, image) VALUES ('$name', '$email', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            echo "New user added successfully";
            // Redirect to index.php after successful insertion
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: There was a problem uploading the image.";
    }
}

$conn->close();
?>
