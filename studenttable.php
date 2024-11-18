<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Student Management</title>
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="container">
        <h2 style="text-align: center;">Student Management System</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
            <thead>
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

                // Deleting Record
                if (isset($_GET['delete'])) {
                    $studentIdToDelete = $_GET['delete'];
                    $deleteQuery = "DELETE FROM studentreg WHERE s_id = '$studentIdToDelete'";
                    mysqli_query($connection, $deleteQuery);
                    echo "<div>Record deleted successfully</div>";
                }

                // Updating Record
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

                // Fetching and displaying records
                $sql = "SELECT * FROM studentreg";
                $data = mysqli_query($connection, $sql);
                if (mysqli_num_rows($data) > 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>";
                        echo "<td>" . $result['fullname'] . "</td>";
                        echo "<td>" . $result['email'] . "</td>";
                        echo "<td>" . $result['semester'] . "</td>";
                        echo "<td>
                        <a href='?delete=" . $result['s_id'] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                        <button onclick='loadUpdateData(" . json_encode($result) . ")'>Update</button>
                        </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Update Modal -->
        <div id="updateModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 400px; background-color: #fff; padding: 20px; border: 1px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
            <h3>Update Student Information</h3>
            <form method="POST" action="">
                <input type="hidden" name="student_id" id="student_id">
                <div>
                    <label>Full Name</label>
                    <input type="text" name="fullname" id="fullname" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label>Semester</label>
                    <input type="text" name="semester" id="semester" required>
                </div>
                <div>
                    <button type="submit" name="update">Update</button>
                    <button type="button" onclick="closeModal()">Close</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function loadUpdateData(data) {
            document.getElementById('student_id').value = data.s_id;
            document.getElementById('fullname').value = data.fullname;
            document.getElementById('email').value = data.email;
            document.getElementById('semester').value = data.semester;
            document.getElementById('updateModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('updateModal').style.display = 'none';
        }
    </script>
</body>
</html>
