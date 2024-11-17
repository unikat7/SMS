<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Assign Teacher to Course</title>
    <link rel="stylesheet" href="navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="teacher.css">
    <style>
    </style>
</head>
<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="content">
        <h2>Assign Teacher to Course</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="teacher_email">Select Teacher:</label>
                <select name="teacher_email" id="teacher_email" required>
                    <?php
                    include 'connection.php';
                    $result = mysqli_query($connection, "SELECT email FROM teacher");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars(trim($row['email'])) . "'>" . htmlspecialchars(trim($row['email'])) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="course_code">Select Course:</label>
                <select name="course_code" id="course_code" required>
                    <?php
                    $result = mysqli_query($connection, "SELECT code, name FROM course");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars(trim($row['code'])) . "'>" . htmlspecialchars(trim($row['name'])) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button id="assignBtn" type="submit">Assign</button><br>
            <div id="assigned">

                <a id="assigned" target="_blank" href="assigned_teachers.php">View Assigned Teachers</a>
            </div>
        </form>

        <?php
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $teacher_email = $_POST['teacher_email'];
            $course_code = $_POST['course_code'];

           
            $insert_query = "INSERT INTO course_teacher (teacher_email, course_code) VALUES ('$teacher_email', '$course_code')";

            if (mysqli_query($connection, $insert_query)) {
                echo "<p style='color: green;'>Teacher assigned to course successfully!</p>";
            } else {
                echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
