<?php
include 'connection.php';

if (isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $old_email = $_POST['old_email'];

    $sql = "UPDATE teacher SET fullname='$fullname', email='$email' WHERE email='$old_email'";

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Teacher information updated successfully.'); window.location.href='teacher_management.php';</script>";
    } else {
        echo "<script>alert('Error updating information: " . mysqli_error($connection) . "');</script>";
    }
}

if (isset($_GET['delete'])) {
    $email_to_delete = $_GET['delete'];

    $delete_sql = "DELETE FROM teacher WHERE email='$email_to_delete'";

    if (mysqli_query($connection, $delete_sql)) {
        echo "<script>alert('Teacher record deleted successfully.'); window.location.href='teacher_management.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($connection) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <link rel="stylesheet" href="teacher.css">
</head>
<style>
    
</style>
<body>
  
    <h2>Teacher Management</h2>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM teacher";
            $data = mysqli_query($connection, $sql);
            $row = mysqli_num_rows($data);

            if ($row > 0) {
                while ($result = mysqli_fetch_assoc($data)) {
                    echo "<tr>";
                    echo "<td>" . $result['fullname'] . "</td>";
                    echo "<td>" . $result['email'] . "</td>";
                    echo "<td>
                        <a href='javascript:void(0)' class='update-btn' onclick=\"showModal('".$result['fullname']."', '".$result['email']."')\">Update</a>
                        <a href='?delete=" . $result['email'] . "' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                    </td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <div class="modal-overlay" id="modalOverlay"></div>

    <div class="modal" id="updateModal">
        <div class="modal-header">Update Teacher Information</div>
        <div class="modal-body">
            <form method="POST" action="">
                <input type="hidden" name="old_email" id="oldEmail">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn-success">Update</button>
                    <button type="button" class="btn-close" onclick="closeModal()">Close</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showModal(fullname, email) {
            document.getElementById('fullname').value = fullname;
            document.getElementById('email').value = email;
            document.getElementById('oldEmail').value = email;

            document.getElementById('modalOverlay').style.display = 'block';
            document.getElementById('updateModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
            document.getElementById('updateModal').style.display = 'none';
        }
    </script>
</body>
</html>
