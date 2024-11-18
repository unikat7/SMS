<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Dashboard</title>
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
.card {
    border: none;
    border-radius: 12px;
}
.card h5, .card p {
    margin: 0;
}
.card-icon {
    font-size: 30px;
    color: #fff;
    margin-right: 15px;
}
.bg-student {
    background-color: #3d8bdb;
}
.bg-teacher {
    background-color: #2c7a7b;
}
.bg-course {
    background-color: #ffb340;
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
            <a href="studentloginprocess.php"><i class="fas fa-user-plus"></i>Create Student Account</a>

        </div>

        <div class="content">
            <h1 class="admin-title">Dashboard</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-student">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-user-graduate card-icon"></i>
                            <div>
                                <h5 class="card-title">Total Students</h5>
                                <p class="card-text"><?php echo $students_count; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-teacher">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-chalkboard-teacher card-icon"></i>
                            <div>
                                <h5 class="card-title">Total Teachers</h5>
                                <p class="card-text"><?php echo $teachers_count; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-course">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-book card-icon"></i>
                            <div>
                                <h5 class="card-title">Total Courses</h5>
                                <p class="card-text"><?php echo $courses_count; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
