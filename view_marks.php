<?php
include 'connection.php';

if (isset($_GET['rollno']) && isset($_GET['semester'])) {
    $rollno = $_GET['rollno'];
    $semester = $_GET['semester'];

    $student_sql = "SELECT * FROM studentreg WHERE rollno='$rollno' AND semester='$semester'";
    $student_result = mysqli_query($connection, $student_sql);
    $student = mysqli_fetch_assoc($student_result);

    if ($student) {
        $course_sql = "SELECT c.code AS course_code, c.name AS course_name
                       FROM course c
                       WHERE c.semester='$semester'"; 
        $course_result = mysqli_query($connection, $course_sql);

        $total_marks = 0;
        $total_courses = 0;
        $assigned_marks_count = 0;
        $missing_marks = false;

       
        while ($course = mysqli_fetch_assoc($course_result)) {
            $marks_sql = "SELECT m.marks
                          FROM marks m
                          WHERE m.rollno='$rollno' AND m.semester='$semester' AND m.course_code='".$course['course_code']."'";
            $marks_result = mysqli_query($connection, $marks_sql);
            $marks = mysqli_fetch_assoc($marks_result);

            if ($marks && $marks['marks'] > 0) {
                $total_marks += $marks['marks'];
                $assigned_marks_count++;
            } else {
                $missing_marks = true;
            }
            $total_courses++;
        }

        if ($total_courses > 0) {
            if ($missing_marks) {
                $status = 'Marks are being assigned by the teacher';
                $percentage = null; 
            } else {
                $percentage = ($total_marks / ($total_courses * 100)) * 100;
                $status = ($percentage < 40) ? 'Fail' : 'Pass';
            }
        }
    } else {
        $student = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Marks</title>
    <link rel="stylesheet" href="assignmarks.css">
</head>
<body>
    <h2>View Marks for Student</h2>
    
    <?php if ($student): ?>
        <h3>Marks for <?php echo htmlspecialchars($student['fullname']); ?> (Roll No: <?php echo htmlspecialchars($rollno); ?>)</h3>
        
        <?php if ($total_courses > 0): ?>
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
                        $marks_sql = "SELECT m.marks
                                      FROM marks m
                                      WHERE m.rollno='$rollno' AND m.semester='$semester' AND m.course_code='".$course['course_code']."'";
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

            <?php if ($missing_marks): ?>
                <script type="text/javascript">
                    alert("Marks are still being assigned by the teacher. Please wait for all marks to be assigned.");
                </script>
            <?php else: ?>
                <h4>Percentage: <?php echo number_format($percentage, 2); ?>%</h4>
                <h4>Status: <?php echo $status; ?></h4>
            <?php endif; ?>

        <?php else: ?>
            <p>No courses available for this student in semester <?php echo $semester; ?>.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Student not found for roll number <?php echo htmlspecialchars($rollno); ?> and semester <?php echo $semester; ?>.</p>
    <?php endif; ?>

    <br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
