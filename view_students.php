<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Student Management System</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Semester</th>
                    <th>Enrollment Year</th>
                    <th>Roll No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'connection.php';
                
                if (!$connection) {
                    die("Connection failed");
                }

                
                if (isset($_GET['delete'])) {
                    $rollnoToDelete = $_GET['delete'];
                    $deleteQuery = "DELETE FROM studentreg WHERE rollno = '$rollnoToDelete'";
                    mysqli_query($connection, $deleteQuery);
                    echo "<div class='alert alert-success'>Record deleted successfully</div>";
                }

                if (isset($_POST['update'])) {
                    $rollnoToUpdate = $_POST['rollno'];
                    $fullname = $_POST['fullname'];
                    $email = $_POST['email'];
                    $semester = $_POST['semester'];
                    $enrollment_year = $_POST['enrollment_year'];

                    $updateQuery = "UPDATE studentreg SET fullname='$fullname', email='$email', semester='$semester', enrollment_year='$enrollment_year' WHERE rollno='$rollnoToUpdate'";
                    mysqli_query($connection, $updateQuery);

              
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit;
                }

             
                $sql = "SELECT * FROM studentreg";
                $data = mysqli_query($connection, $sql);
                $row = mysqli_num_rows($data);
                
                if ($row > 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>";
                        echo "<td>" . $result['fullname'] . "</td>";
                        echo "<td>" . $result['email'] . "</td>";
                        echo "<td>" . $result['semester'] . "</td>";
                        echo "<td>" . $result['enrollment_year'] . "</td>";
                        echo "<td>" . $result['rollno'] . "</td>";
                        echo "<td>
                        <a href='assign_marks.php?rollno=" . $result['rollno'] . "&semester=" . $result['semester'] . "&fullname=" . $result['fullname'] . "' class='btn btn-success btn-sm'>Assign Marks</a>
                        </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
