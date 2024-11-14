<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="coursetable.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Course Management</title>
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
        <h2>Course Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Code</th>
                    <th>Credit Hours</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'connection.php';

                if (isset($_POST['delete_course'])) {
                    $code = $_POST['code_course'];
                    $delete_sql = "DELETE FROM course WHERE code='$code'";
                    mysqli_query($connection, $delete_sql);
                    header("Location: ".$_SERVER['PHP_SELF']); 
                    exit();
                }

                $sql = "SELECT * FROM course";
                $data = mysqli_query($connection, $sql);
                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['code']}</td>
                                <td>{$row['hours']}</td>
                                <td>{$row['semester']}</td>
                                <td class='actions'>
                                    <a href='?code_course={$row['code']}' class='update-btn'>Update</a>
                                    <form method='POST' action='' style='display:inline;'>
                                        <input type='hidden' name='code_course' value='{$row['code']}'>
                                        <button type='submit' name='delete_course' class='delete-btn'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>No courses found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
