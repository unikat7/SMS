<!-- reset_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>

        <?php
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            include 'connection.php';

         
            $query = "SELECT * FROM admin WHERE reset_token='$token' UNION SELECT * FROM teacher WHERE reset_token='$token' UNION SELECT * FROM student WHERE reset_token='$token'";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <form action="reset_password.php" method="POST">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" name="new_password" required />
                    </div>
                    <button type="submit" name="reset" class="btn btn-primary">Reset Password</button>
                    <input type="hidden" name="token" value="<?php echo $token; ?>" />
                </form>
                <?php
            } else {
                echo "<p>Invalid token.</p>";
            }
        }

        if (isset($_POST['reset'])) {
            $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
            $token = $_POST['token'];

       
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        
            $update_query = "UPDATE admin SET password='$hashed_password', reset_token=NULL WHERE reset_token='$token'"; // Apply similar update query for other tables (teacher, student)
            if (mysqli_query($connection, $update_query)) {
                echo "<p>Your password has been successfully reset.</p>";
            } else {
                echo "<p>Error resetting password.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
