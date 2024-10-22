<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Management System - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        body {
            background-image: url('https://www.transparenttextures.com/patterns/fabric-light.png'); 
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50; 
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0056b3; 
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #7f8c8d;
        }
    </style>
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
        </form>

        <?php
        session_start();
        include 'connection.php';

        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

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
