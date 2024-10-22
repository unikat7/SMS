<?php
include 'connection.php'; // Include your database connection

// Fetch counts of students, teachers, and courses for the dashboard
$students_count_query = "SELECT COUNT(*) as count FROM studentreg";
$teachers_count_query = "SELECT COUNT(*) as count FROM teacher";
$courses_count_query = "SELECT COUNT(*) as count FROM course";

$students_count = mysqli_fetch_assoc(mysqli_query($connection, $students_count_query))['count'];
$teachers_count = mysqli_fetch_assoc(mysqli_query($connection, $teachers_count_query))['count'];
$courses_count = mysqli_fetch_assoc(mysqli_query($connection, $courses_count_query))['count'];
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin Dashboard</title>

    <style>
        body {
            padding-top: 20px;
        }
        .admin-panel {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="admin-panel">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <a href="coursecreation.php">Create Course</a>
            <a href="coursetable.php">View Courses</a>
            <a href="manageteacher.php">Create Teacher</a>
            <a href="teachertable.php">View Teachers</a>
            <a href="studentenrolment.php">Create Student</a>
            <a href="assignteacher.php">Assign Teacher</a>

            <a href="studenttable.php">View Students</a>
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="admin-title">Dashboard</h1>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Students</h5>
                            <p class="card-text"><?php echo $students_count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Total Teachers</h5>
                            <p class="card-text"><?php echo $teachers_count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Total Courses</h5>
                            <p class="card-text"><?php echo $courses_count; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
