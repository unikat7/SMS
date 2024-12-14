<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Management System - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2 class="login-header">Student Management System</h2>
        <h4 class="login-header">Login</h4>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" required />
            </div>
            <div class="form-group">
                <label for="role">Login As</label>
                <select class="form-control" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <button type="submit" name="login" class="btn btn-custom btn-block">Login</button>
<a href="forgot_password.php" class="btn btn-link btn-block">Forgot Password?</a>

        </form>

        <?php
        session_start();
        include 'connection.php';

        if (isset($_POST['login'])) {
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $role = mysqli_real_escape_string($connection, $_POST['role']);

            if ($role == 'admin') {
                $query = "SELECT * FROM admin WHERE email='$email'";
            } elseif ($role == 'teacher') {
                $query = "SELECT * FROM teacher WHERE email='$email'";
            } elseif ($role == 'student') {
                $query = "SELECT * FROM student WHERE email='$email'";
            }

            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    if ($role == 'admin') {
                        header("Location: admin_dashboard.php");
                    } elseif ($role == 'teacher') {
                        $_SESSION['teacher_email'] = $email;
                        header("Location: teacherdashboard.php");
                    } elseif ($role == 'student') {
                        header("Location: studentdashboard.php");
                    }
                } else {
                    echo "<p class='error'>Invalid password!</p>";
                }
            } else {
                echo "<p class='error'>No user found with this email!</p>";
            }
        }
        ?>

        <div class="footer">
            &copy; <?php echo date("Y"); ?> Student Management System
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
