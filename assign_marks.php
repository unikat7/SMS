<?php
session_start();
include 'connection.php';

$teacher_email = $_SESSION['teacher_email'];

if (isset($_GET['rollno']) && isset($_GET['semester'])) {
    $rollno = $_GET['rollno'];
    $semester = $_GET['semester'];

    $all_subjects_sql = "SELECT code, name FROM course WHERE semester = '$semester'";
    $all_subjects_result = mysqli_query($connection, $all_subjects_sql);
    
    $teacher_subjects_sql = "SELECT course.code FROM course_teacher 
                             JOIN course ON course_teacher.course_code = course.code 
                             WHERE course_teacher.teacher_email = '$teacher_email'
                             AND course.semester = '$semester'";
    $teacher_subjects_result = mysqli_query($connection, $teacher_subjects_sql);
    
    $teacher_subjects = [];
    while ($row = mysqli_fetch_assoc($teacher_subjects_result)) {
        $teacher_subjects[] = $row['code'];
    }

    
    $student_sql = "SELECT * FROM studentreg WHERE rollno='$rollno' AND semester='$semester'";
    $student_result = mysqli_query($connection, $student_sql);
    $student = mysqli_fetch_assoc($student_result);
    $student_id = $student['s_id'];

 
    $existing_marks_sql = "SELECT course_code, marks FROM marks WHERE rollno='$rollno' AND semester='$semester'";
    $existing_marks_result = mysqli_query($connection, $existing_marks_sql);

    $existing_marks = [];
    while ($row = mysqli_fetch_assoc($existing_marks_result)) {
        $existing_marks[$row['course_code']] = $row['marks'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['marks'] as $course_code => $mark) {
        if (in_array($course_code, $teacher_subjects)) {
            if (isset($existing_marks[$course_code])) {
               
                $update_marks_sql = "UPDATE marks SET marks='$mark' 
                                     WHERE rollno='$rollno' AND semester='$semester' AND course_code='$course_code'";
                mysqli_query($connection, $update_marks_sql);
                echo "<p style='color: green;'>Marks updated successfully for $course_code!</p>";
            } else {
              
                $insert_marks_sql = "INSERT INTO marks (rollno, semester, course_code, teacher_email, marks) 
                                     VALUES ('$rollno', '$semester', '$course_code', '$teacher_email', '$mark')";
                mysqli_query($connection, $insert_marks_sql);
                echo "<p style='color: green;'>Marks assigned successfully for $course_code!</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign or Update Marks</title>
</head>
<body>
    <h2>Assign or Update Marks for <?php echo htmlspecialchars($student['fullname']); ?> (Roll No: <?php echo htmlspecialchars($rollno); ?>)</h2>
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Mark</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($all_subjects_result) > 0) {
                    while ($subject = mysqli_fetch_assoc($all_subjects_result)) {
                        $subject_code = htmlspecialchars($subject['code']);
                        $subject_name = htmlspecialchars($subject['name']);
                        $current_marks = isset($existing_marks[$subject_code]) ? $existing_marks[$subject_code] : '';
                        
                        echo "<tr>
                                <td>$subject_name</td>";

                        if (in_array($subject_code, $teacher_subjects)) {
                            if ($current_marks !== '') {
                                echo "<td><input type='number' name='marks[$subject_code]' value='$current_marks' min='0' max='100' required></td>";
                                echo "<td><span style='color: green;'>✓ Marks already assigned, can update</span></td>";
                            } else {
                                echo "<td><input type='number' name='marks[$subject_code]' min='0' max='100' required></td>";
                                echo "<td><span style='color: orange;'>Marks not assigned yet, can assign</span></td>";
                            }
                        } else {
                            echo "<td><input type='number' value='$current_marks' min='0' max='100' readonly placeholder='N/A'></td>";
                            echo "<td><span style='color: red;'>N/A</span></td>";
                        }
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No subjects found for semester $semester.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit">Submit Marks</button>
    </form>
</body>
</html>
