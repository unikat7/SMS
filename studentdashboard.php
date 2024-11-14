<?php
include 'connection.php';
$teachers_count_query = "SELECT COUNT(*) as count FROM teacher";
$courses_count_query = "SELECT COUNT(*) as count FROM course";

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
    <title>Student Dashboard</title>
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
        .student-panel {
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
        .student-title {
            color: #334e68;
            font-size: 26px;
            font-weight: bold;
        }
        .statistics {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .stat-box {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .stat-box h3 {
            font-size: 24px;
            margin: 0;
            color: #4A90E2;
        }
        .stat-box p {
            font-size: 16px;
            color: #334e68;
        }
        .icon {
            font-size: 30px;
            color: #4A90E2;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Student Dashboard</a>
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

    <div class="student-panel">
        <div class="sidebar">
            <h2>Student Panel</h2>
            <a href="view_courses.php"><i class="fas fa-book"></i> View Courses</a>
            <a href="view_teachers.php"><i class="fas fa-users"></i> View Teachers</a>
            <a href="view_result.php"><i class="fas fa-graduation-cap"></i> View Results</a>
        </div>

        <div class="content">
            <h1 class="student-title">Dashboard</h1>
            <div class="statistics">
                <div class="stat-box">
                    <i class="fas fa-chalkboard-teacher icon"></i>
                    <div>
                        <h3><?php echo $teachers_count; ?></h3>
                        <p>Total Teachers</p>
                    </div>
                </div>
                <div class="stat-box">
                    <i class="fas fa-book-open icon"></i>
                    <div>
                        <h3><?php echo $courses_count; ?></h3>
                        <p>Total Courses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
