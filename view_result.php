<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$student_sql = "SELECT fullname, rollno, semester FROM studentreg WHERE email='$email'";
$student_result = mysqli_query($connection, $student_sql);

// Ensure student record is found
$student = mysqli_fetch_assoc($student_result);
if (!$student) {
    echo "Student record not found.";
    exit;
}

$rollno = $student['rollno'];
$semester = $student['semester'];

$course_sql = "SELECT c.code AS course_code, c.name AS course_name FROM course c WHERE c.semester='$semester'";
$course_result = mysqli_query($connection, $course_sql);

$total_marks = 0;
$total_courses = 0;
$missing_marks = false;

while ($course = mysqli_fetch_assoc($course_result)) {
    $marks_sql = "SELECT m.marks FROM marks m WHERE m.rollno='$rollno' AND m.semester='$semester' AND m.course_code='".$course['course_code']."'";
    $marks_result = mysqli_query($connection, $marks_sql);
    $marks = mysqli_fetch_assoc($marks_result);

    if ($marks && isset($marks['marks']) && $marks['marks'] > 0) {
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
                // Reset the course result pointer to loop through again
                mysqli_data_seek($course_result, 0);
                while ($course = mysqli_fetch_assoc($course_result)):
                    $marks_sql = "SELECT m.marks FROM marks m WHERE m.rollno='$rollno' AND m.semester='$semester' AND m.course_code='".$course['course_code']."'";
                    $marks_result = mysqli_query($connection, $marks_sql);
                    $marks = mysqli_fetch_assoc($marks_result);
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                        <td><?php echo ($marks && isset($marks['marks'])) ? htmlspecialchars($marks['marks']) : 'Not Assigned'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h4>Percentage: <?php echo number_format($percentage, 2); ?>%</h4>
        <h4>Status: <span class="<?php echo $status === 'Pass' ? 'status-pass' : 'status-fail'; ?>"><?php echo $status; ?></span></h4>
    <?php endif; ?>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
