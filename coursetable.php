<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        thead {
            background-color: #4CAF50;
            color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .update-btn, .delete-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .update-btn {
            background-color: #4CAF50;
        }
        .update-btn:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .delete-btn:hover {
            background-color: #e53935;
        }
        .update-form {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            width: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .update-form input {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .update-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Course Management</h2>

<!-- Course Table -->
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

        // Handle delete operation
        if (isset($_POST['delete_course'])) {
            $code = $_POST['code_course'];
            $delete_sql = "DELETE FROM course WHERE code='$code'";
            mysqli_query($connection, $delete_sql);
            header("Location: ".$_SERVER['PHP_SELF']); // Refresh the page
            exit();
        }

        // Handle update form submission for courses
        if (isset($_POST['update_course'])) {
            $code = $_POST['code'];
            $name = $_POST['name'];
            $hours = $_POST['hours'];
            $semester = $_POST['semester'];

            $update_sql = "UPDATE course SET name='$name', hours='$hours', semester='$semester' WHERE code='$code'";
            mysqli_query($connection, $update_sql);
            header("Location: ".$_SERVER['PHP_SELF']); // Refresh the page
            exit();
        }

        // Fetch courses
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

<!-- Course Update Form -->
<?php
if (isset($_GET['code_course'])) {
    $code = $_GET['code_course'];
    $sql = "SELECT * FROM course WHERE code='$code'";
    $result = mysqli_query($connection, $sql);
    $course = mysqli_fetch_assoc($result);

    if ($course) {
        echo "<div class='update-form'>
                <form method='POST' action=''>
                    <h3>Update Course</h3>
                    <input type='hidden' name='code' value='".$course['code']."'>
                    <input type='text' name='name' value='".$course['name']."' required placeholder='Course Name'>
                    <input type='text' name='hours' value='".$course['hours']."' required placeholder='Credit Hours'>
                    <input type='text' name='semester' value='".$course['semester']."' required placeholder='Semester'>
                    <button type='submit' name='update_course'>Update Course</button>
                </form>
              </div>";
    }
}
?>

</body>
</html>
