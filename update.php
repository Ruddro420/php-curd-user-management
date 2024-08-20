<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $update_image_sql = "";

    if (!empty($image)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $update_image_sql = ", image='$target_file'";
        } else {
            echo "Error: There was a problem uploading the image.";
            exit();
        }
    }

    // Update user details
    $sql = "UPDATE users SET name='$name', email='$email' $update_image_sql WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $conn->close();
    header("Location: index.php");
    exit();
} else {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .image-preview {
            text-align: center;
            margin-bottom: 15px;
        }
        .image-preview img {
            border: 1px solid #ddd;
            border-radius: 4px;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            
            <div class="image-preview">
                <label for="image">Current Image:</label>
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="User Image">
            </div>
            
            <label for="image">Upload New Image (optional):</label>
            <input type="file" name="image">
            
            <input type="submit" value="Update User">
        </form>
    </div>
</body>
</html>
