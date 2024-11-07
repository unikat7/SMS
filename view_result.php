<?php
session_start();
include 'connection.php';

if (isset($_POST['login'])) {
    $rollno = $_POST['rollno'];
    $semester = $_POST['semester'];

    $student_sql = "SELECT * FROM studentreg WHERE rollno='$rollno' AND semester='$semester'";
    $student_result = mysqli_query($connection, $student_sql);
    $student = mysqli_fetch_assoc($student_result);

    if ($student) {
        $_SESSION['rollno'] = $rollno;
        $_SESSION['semester'] = $semester;
    } else {
        $login_error = "Invalid roll number or semester.";
    }
}

if (isset($_SESSION['rollno']) && isset($_SESSION['semester'])) {
    $rollno = $_SESSION['rollno'];
    $semester = $_SESSION['semester'];

    $course_sql = "SELECT c.code AS course_code, c.name AS course_name FROM course c WHERE c.semester='$semester'";
    $course_result = mysqli_query($connection, $course_sql);

    $total_marks = 0;
    $total_courses = 0;
    $missing_marks = false;

    while ($course = mysqli_fetch_assoc($course_result)) {
        $marks_sql = "SELECT m.marks FROM marks m WHERE m.rollno='$rollno' AND m.semester='$semester' AND m.course_code='".$course['course_code']."'";
        $marks_result = mysqli_query($connection, $marks_sql);
        $marks = mysqli_fetch_assoc($marks_result);

        if ($marks && $marks['marks'] > 0) {
            $total_marks += $marks['marks'];
        } else {
            $missing_marks = true;
            break;
        }
        $total_courses++;
    }

    if ($total_courses > 0 && !$missing_marks) {
        $percentage = ($total_marks / ($total_courses * 100)) * 100;
        $status = ($percentage < 40) ? 'Fail' : 'Pass';
    } else {
        $status = 'Pending';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .status-pass { color: green; }
        .status-fail { color: red; }
        .status-pending { color: orange; }
    </style>
</head>
<body>
    <?php if (!isset($_SESSION['rollno']) || !isset($_SESSION['semester'])): ?>
        <h2>Student Login</h2>
        <form method="post">
            <label>Roll Number:</label>
            <input type="text" name="rollno" required>
            <label>Semester:</label>
            <input type="text" name="semester" required>
            <button type="submit" name="login">Login</button>
            <?php if (isset($login_error)): ?>
                <p style="color: red;"><?php echo $login_error; ?></p>
            <?php endif; ?>
        </form>
    <?php else: ?>
        <h2>Your Result</h2>
        <h3>Marks for <?php echo htmlspecialchars($student['fullname']); ?> (Roll No: <?php echo htmlspecialchars($rollno); ?>)</h3>

        <?php if ($status === 'Pending'): ?>
            <p class="status-pending">The result has not been published yet. Please check back later.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Marks Obtained</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($course_result, 0);
                    while ($course = mysqli_fetch_assoc($course_result)):
                        $marks_sql = "SELECT m.marks FROM marks m WHERE m.rollno='$rollno' AND m.semester='$semester' AND m.course_code='".$course['course_code']."'";
                        $marks_result = mysqli_query($connection, $marks_sql);
                        $marks = mysqli_fetch_assoc($marks_result);
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                            <td><?php echo $marks ? htmlspecialchars($marks['marks']) : 'Not Assigned'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h4>Percentage: <?php echo number_format($percentage, 2); ?>%</h4>
            <h4>Status: <span class="<?php echo $status === 'Pass' ? 'status-pass' : 'status-fail'; ?>"><?php echo $status; ?></span></h4>
        <?php endif; ?>
        <br>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</body>
</html>
