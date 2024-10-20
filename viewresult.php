<?php
include 'connection.php';

// Assume the student logs in or enters their roll number
$studentRollno = $_GET['rollno']; // Or fetch from session if logged in

// Fetch student details
$studentQuery = "
    SELECT studentreg.fullname, studentreg.semester, marks.subject, marks.marks 
    FROM studentreg 
    JOIN marks ON studentreg.rollno = marks.rollno 
    WHERE studentreg.rollno = ?
";
$stmt = $connection->prepare($studentQuery);
$stmt->bind_param("s", $studentRollno);
$stmt->execute();
$studentData = $stmt->get_result();

// Fetch total marks and percentage
$marksQuery = "SELECT SUM(marks) as totalMarks, COUNT(subject) as subjectCount FROM marks WHERE rollno = ?";
$stmt = $connection->prepare($marksQuery);
$stmt->bind_param("s", $studentRollno);
$stmt->execute();
$marksData = $stmt->get_result()->fetch_assoc();

// Calculate total percentage
$maxMarksPerSubject = 60;  // Max marks for each subject
$requiredSubjectCount = 5;  // Number of subjects
$totalMarks = $marksData['totalMarks'];
$subjectCount = $marksData['subjectCount'];
$maxTotalMarks = $requiredSubjectCount * $maxMarksPerSubject;
$percentage = min(($totalMarks / $maxTotalMarks) * 100, 100);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result</title>
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
    </style>
</head>
<body>

<h2>Result of <?php echo htmlspecialchars($studentRollno); ?></h2>

<?php if ($studentData->num_rows > 0): ?>
    <table>
        <tr>
            <th>Subject</th>
            <th>Marks Obtained</th>
        </tr>

        <?php while ($row = $studentData->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo htmlspecialchars($row['marks']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Total Marks: <?php echo $totalMarks; ?> / <?php echo $maxTotalMarks; ?></h3>
    <h3>Percentage: <?php echo number_format($percentage, 2); ?>%</h3>

<?php else: ?>
    <p>No marks have been assigned yet.</p>
<?php endif; ?>

</body>
</html>
