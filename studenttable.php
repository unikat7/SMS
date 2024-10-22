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

                // Delete operation
                if (isset($_GET['delete'])) {
                    $rollnoToDelete = $_GET['delete'];
                    $deleteQuery = "DELETE FROM studentreg WHERE rollno = '$rollnoToDelete'";
                    mysqli_query($connection, $deleteQuery);
                    echo "<div class='alert alert-success'>Record deleted successfully</div>";
                }

                // Update operation
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
                        <a href='?delete=" . $result['rollno'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                        <a href='?update_form=" . $result['rollno'] . "' class='btn btn-primary btn-sm'>Update</a> 
                        <a href='assignmarks.php?rollno=" . $result['rollno'] . "&semester=" . $result['semester'] . "&fullname=" . $result['fullname'] . "' class='btn btn-success btn-sm'>View Marks</a>
                        </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

       
        <?php if (isset($_GET['update_form'])): 
            $rollnoToUpdate = $_GET['update_form'];
            $query = "SELECT * FROM studentreg WHERE rollno='$rollnoToUpdate'";
            $result = mysqli_query($connection, $query);
            $studentData = mysqli_fetch_assoc($result);
        ?>
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">Update Student Information</div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="rollno" value="<?php echo $studentData['rollno']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" value="<?php echo $studentData['fullname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $studentData['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="text" name="semester" class="form-control" value="<?php echo $studentData['semester']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enrollment Year</label>
                        <input type="text" name="enrollment_year" class="form-control" value="<?php echo $studentData['enrollment_year']; ?>" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
