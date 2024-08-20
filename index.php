<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css Connect Here -->
    <link rel="stylesheet" href="style.css">
    <title>User Management</title>
</head>

<body>

    <div class="container">
        <h1>User Management</h1>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Enter Name" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="file" name="image" required> <!-- Add file input for image upload -->
            <input type="submit" value="Add User">
        </form>


        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th> <!-- Add a column for the image -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);
                $slNo = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $slNo; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="User Image" width="50" height="50"></td>
                            <!-- Display the image -->
                            <td>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn"
                                    onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                        <?php
                        $slNo++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

    </div>

</body>

</html>