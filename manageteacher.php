<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
        }
        .navbar {
            background-color: #4A90E2;
            z-index: 100;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .admin-panel {
            display: flex;
            min-height: 100vh;
            margin-top: 56px;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #334e68;
            padding: 20px;
            color: #fff;
            z-index: 90;
        }
        .sidebar h2 {
            color: #ffdd57;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: #f0f4f8;
            margin-bottom: 15px;
            font-size: 16px;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #ffdd57;
            text-decoration: underline;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #f3f4f6;
            margin-left: 250px;
        }
        .admin-title {
            color: #334e68;
            font-size: 26px;
            font-weight: bold;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header {
            font-size: 24px;
            font-weight: bold;
            color: #4A90E2;
            text-align: center;
            margin-bottom: 20px;
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box label {
            font-weight: bold;
            color: #334e68;
        }
        .input-box input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }
        button {
            background-color: #4A90E2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #357abD;
        }
        p {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="admin-panel">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="coursecreation.php"><i class="fas fa-plus-circle"></i> Create Course</a>
        <a href="coursetable.php"><i class="fas fa-book-open"></i> View Courses</a>
        <a href="manageteacher.php"><i class="fas fa-user-plus"></i> Create Teacher</a>
        <a href="teachertable.php"><i class="fas fa-chalkboard-teacher"></i> View Teachers</a>
        <a href="studentenrolment.php"><i class="fas fa-user-edit"></i> Create Student</a>
        <a href="assignteacher.php"><i class="fas fa-user-tag"></i> Assign Teacher</a>
        <a href="studenttable.php"><i class="fas fa-users"></i> View Students</a>
    </div>

    <div class="content">
        <section class="container">
            <header>Teacher Registration</header>
            <form action="" class="form" method="POST">
                <div class="input-box">
                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="Enter full name" required />
                </div>
                <div class="input-box">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter email address" required />
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required />
                </div>
                <button name="create">Create</button>
            </form>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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
