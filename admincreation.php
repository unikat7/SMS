<?php

include 'connection.php';


if (isset($_POST['create'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO admin (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
    
  
    if (mysqli_query($connection, $sql)) {
        echo "Admin registered successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Registration</title>
</head>
<body>
    <form action="" method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" required />
        
        <label>Email Address</label>
        <input type="email" name="email" required />
        
        <label>Password</label>
        <input type="password" name="password" required />
        
        <button name="create">Create Admin</button>
    </form>
</body>
</html>
