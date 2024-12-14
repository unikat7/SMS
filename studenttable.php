<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Arial', sans-serif;
        }
        h2 {
            margin-top: 20px;
            font-weight: bold;
            color: #4A90E2;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            text-align: center;
        }
        .btn-update, .btn-delete {
            padding: 5px 10px;
            margin: 0 5px;
            font-size: 0.9rem;
        }
        .btn-update {
            background-color: #ffc107;
            border-color: #ffc107;
            color: white;
        }
        .btn-update:hover {
            background-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        /* Modal styling */
        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            background-color: #4A90E2;
            color: white;
            font-weight: bold;
        }
        .modal-footer button {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Student Table </h2>
        
        <table class="table table-striped table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Semester</th>
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
                    $studentIdToDelete = $_GET['delete'];
                    $deleteQuery = "DELETE FROM studentreg WHERE s_id = '$studentIdToDelete'";
                    mysqli_query($connection, $deleteQuery);
                    echo "<div>Record deleted successfully</div>";
                }

                if (isset($_POST['update'])) {
                    $studentId = $_POST['student_id'];
                    $fullname = $_POST['fullname'];
                    $email = $_POST['email'];
                    $semester = $_POST['semester'];
                    $updateQuery = "UPDATE studentreg SET fullname='$fullname', email='$email', semester='$semester' WHERE s_id='$studentId'";
                    mysqli_query($connection, $updateQuery);
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit;
                }

                $sql = "SELECT * FROM studentreg";
                $data = mysqli_query($connection, $sql);
                if (mysqli_num_rows($data) > 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>";
                        echo "<td>" . $result['fullname'] . "</td>";
                        echo "<td>" . $result['email'] . "</td>";
                        echo "<td>" . $result['semester'] . "</td>";
                        echo "<td>
                            <a href='?delete=" . $result['s_id'] . "' class='btn btn-delete' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                            <button class='btn btn-update' onclick='loadUpdateData(" . json_encode($result) . ")'>Update</button>
                        </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

       
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Student Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="student_id" id="student_id">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <input type="text" class="form-control" name="semester" id="semester" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadUpdateData(data) {
            document.getElementById('student_id').value = data.s_id;
            document.getElementById('fullname').value = data.fullname;
            document.getElementById('email').value = data.email;
            document.getElementById('semester').value = data.semester;
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        }
    </script>
</body>
</html>
