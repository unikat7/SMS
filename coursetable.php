<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Course Management</title>
    <style>
    </style>
</head>
<body>

<?php
include'navbar.php';

?>

<div class="content">
    <h2>Course Management</h2>
    <table class="table table-bordered">
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
                                <button class='btn btn-warning' onclick=\"openModal('{$row['code']}', '{$row['name']}', '{$row['hours']}', '{$row['semester']}')\">Update</button>
                                <form method='POST' action='' style='display:inline;'>
                                    <input type='hidden' name='code_course' value='{$row['code']}'>
                                    <button type='submit' name='delete_course' class='btn btn-danger'>Delete</button>
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

<!-- Modal for updating course -->
<div id="courseModal" class="modal">
    <div class="modal-header">
        <h4>Update Course</h4>
    </div>
    <div class="modal-body">
        <form method="POST" action="">
            <input type="hidden" name="old_code" id="old_code">
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" id="course_name" name="course_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="credit_hours">Credit Hours</label>
                <input type="number" id="credit_hours" name="credit_hours" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" id="semester" name="semester" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="submit" name="update_course" class="btn btn-success">Update</button>
                <button type="button" class="btn-close" onclick="closeModal()">Close</button>
            </div>
        </form>
    </div>
</div>

<div id="modalOverlay" class="modal-overlay" onclick="closeModal()"></div>

<script>
 
    function openModal(code, name, hours, semester) {
        document.getElementById('old_code').value = code;
        document.getElementById('course_name').value = name;
        document.getElementById('credit_hours').value = hours;
        document.getElementById('semester').value = semester;

        document.getElementById('courseModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
    }

    // Close modal
    function closeModal() {
        document.getElementById('courseModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
    }
</script>

<?php
// Handle course update
if (isset($_POST['update_course'])) {
    $old_code = $_POST['old_code'];
    $course_name = $_POST['course_name'];
    $credit_hours = $_POST['credit_hours'];
    $semester = $_POST['semester'];

    $update_sql = "UPDATE course SET name='$course_name', hours='$credit_hours', semester='$semester' WHERE code='$old_code'";
    if (mysqli_query($connection, $update_sql)) {
        echo "<script>alert('Course updated successfully'); window.location.href='".$_SERVER['PHP_SELF']."';</script>";
    } else {
        echo "<script>alert('Error updating course: ".mysqli_error($connection)."');</script>";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
