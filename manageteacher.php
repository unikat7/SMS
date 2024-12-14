<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <!-- <link rel="stylesheet" href="navbar.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
            <header>Teacher Registration</header>
            <form action="" method="POST">
                <div class="input-box">
                    <label>Full Name :</label>
                    <input type="text" name="fullname" placeholder="Enter full name" required />
                </div>
                <div class="input-box">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Enter email address" required />
                </div>
                <div class="input-box">
                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter password" required />
                </div>
                <button type="submit" name="create">Create</button>
            </form>
        </section>
    </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <?php
    include 'connection.php';

    if (!$connection) {
        die("Connection failed");
    } else {
        if (isset($_POST['create'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

           
            $check_teacher = "SELECT * FROM teacher WHERE email = '$email'";
            $result = mysqli_query($connection, $check_teacher);

            if (mysqli_num_rows($result) > 0) {
                echo "<p style='color: red; text-align: center;'>Teacher with email $email already exists!</p>";
            } else {
               
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO teacher (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
                $sql_data = mysqli_query($connection, $sql);

                if ($sql_data == 1) {
                    echo "<p style='color: green; text-align: center;'>Teacher registered successfully!</p>";
                } else {
                    echo "<p style='color: red; text-align: center;'>Failed to insert teacher data</p>";
                }
            }
        }
    }
    ?>
</body>
</html>
