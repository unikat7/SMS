<?php
include 'connection.php';

if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $hours = $_POST['hours'];
    $semester = $_POST['semester'];

  
    $check_sql = "SELECT * FROM course WHERE code='$code'";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Course with this code already exists!');</script>";
    } else {
        
        $insert_sql = "INSERT INTO course (name, code, hours, semester) VALUES ('$name', '$code', '$hours', '$semester')";
        if (mysqli_query($connection, $insert_sql)) {
            echo "<script>alert('Course created successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="teacher.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Course Creation</title>
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
            margin-top: 56px; /* Adjust to the height of your navbar */
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
            margin-left: 250px; /* Space for the sidebar */
        }
        .admin-title {
            color: #334e68;
            font-size: 26px;
            font-weight: bold;
        }
        .form {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        .form .input-box {
            margin-bottom: 20px;
        }
        .form .input-box label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .form .input-box input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .form button {
            width: 100%;
            padding: 12px;
            background-color: #4A90E2;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .form button:hover {
            background-color: #357ABD;
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
            <h1 class="admin-title">Course Creation</h1>
            <form action="" class="form" method="post">
                <div class="input-box">
                    <label for="name">Course Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Course Name" required />
                </div>
                <div class="input-box">
                    <label for="code">Code</label>
                    <input type="text" id="code" name="code" placeholder="Enter Course Code" required />
                </div>
                <div class="input-box">
                    <label for="hours">Credit Hours</label>
                    <input type="number" id="hours" name="hours" placeholder="Enter Credit Hours" required />
                </div>
                <div class="input-box">
                    <label for="semester">Semester</label>
                    <input type="number" id="semester" name="semester" placeholder="Enter Semester" required />
                </div>
                <button type="submit" name="create">Create</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
