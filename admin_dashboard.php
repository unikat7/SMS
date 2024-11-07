<?php
include 'connection.php';

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
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Dashboard</title>
    
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
            <h1 class="admin-title">Dashboard</h1>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
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
                    <div class="card text-white bg-success">
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
                    <div class="card text-white bg-info">
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
