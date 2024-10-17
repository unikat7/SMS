<?php
include 'connection.php';

// Fetch distinct roll numbers and corresponding full names
$studentQuery = "SELECT rollno, fullname, semester FROM studentreg";
$studentData = mysqli_query($connection, $studentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .remarks-completed {
            color: green;
            font-weight: bold;
        }
        .remarks-pending {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Student Marks Table</h2>

<table>
    <tr>
        <th>Full Name</th>
        <th>Semester</th>
        <th>Total Marks</th>
        <th>Percentage</th>
        <th>Status</th>
    </tr>

    <?php
    if (mysqli_num_rows($studentData) > 0) {
        while ($student = mysqli_fetch_assoc($studentData)) {
            $rollno = $student['rollno'];
            $fullname = $student['fullname'];
            $semester = $student['semester'];

            // Use prepared statements for fetching marks to avoid SQL injection
            $marksQuery = "SELECT subject, SUM(marks) as totalMarks FROM marks WHERE rollno = ? GROUP BY subject";
            $stmt = $connection->prepare($marksQuery);
            $stmt->bind_param("s", $rollno);
            $stmt->execute();
            $marksData = $stmt->get_result();

            // Initialize variables
            $totalMarks = 0;
            $subjectCount = 0;
            $maxMarksPerSubject = 60; // Maximum marks for each subject
            $requiredSubjectCount = 5; // Total subjects expected

            if ($marksData && mysqli_num_rows($marksData) > 0) {
                while ($markRow = mysqli_fetch_assoc($marksData)) {
                    $totalMarks += $markRow['totalMarks'];
                    $subjectCount++;
                }

                // Ensure there are 5 subjects
                if ($subjectCount >= $requiredSubjectCount) {
                    $maxTotalMarks = $requiredSubjectCount * $maxMarksPerSubject; // Maximum possible total marks
                    $percentage = min(($totalMarks / $maxTotalMarks) * 100, 100); // Calculate percentage, capping at 100%
                    $marksStatus = "Completed";
                } else {
                    $percentage = 0;
                    $marksStatus = "Pending";
                }

                // Display each student's marks
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fullname) . "</td>";
                echo "<td>" . htmlspecialchars($semester) . "</td>";
                echo "<td>" . ($marksStatus === "Completed" ? $totalMarks : 'Pending') . "</td>";
                echo "<td>" . ($marksStatus === "Completed" ? number_format($percentage, 2) . '%' : 'Pending') . "</td>";
                echo "<td class='" . ($marksStatus === "Completed" ? "remarks-completed" : "remarks-pending") . "'>" . $marksStatus . "</td>";
                echo "</tr>";

            } else {
                // No marks available for the student
                echo "<tr><td colspan='5'>No marks found for " . htmlspecialchars($fullname) . "</td></tr>";
            }
        }
    } else {
        echo "<tr><td colspan='5'>No student records found</td></tr>";
    }
    ?>
</table>

</body>
</html>
