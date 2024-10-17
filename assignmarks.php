<?php
include 'connection.php';

// Fetch subjects (course names) from the database
$subjects = [];
$sql = "SELECT code, name FROM course"; // Adjust this query to get the subject details from the course table
$result = mysqli_query($connection, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $subjects[$row['code']] = $row['name']; // Using code as the value for the dropdown
    }
}

// Fetch roll number, semester, and full name from the URL if available
if (isset($_GET['rollno']) && isset($_GET['semester']) && isset($_GET['fullname'])) {
    $rollno = $_GET['rollno'];
    $semester = $_GET['semester'];
    $fullname = $_GET['fullname'];
} else {
    $rollno = '';
    $semester = '';
    $fullname = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Marks</title>
</head>
<body>
    <form action="" method="post">
        <label>Full Name:</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($fullname) ?>" readonly>
        
        <label>Semester:</label>
        <input type="number" name="semester" value="<?= htmlspecialchars($semester) ?>" readonly>
        
        <label>Roll No:</label>
        <input type="number" name="rollno" value="<?= htmlspecialchars($rollno) ?>" readonly>
        
        <label>Subjects:</label>
        <select name="subject" required>
            <option value="">Select a subject</option>
            <?php foreach ($subjects as $key => $subject) : ?>
                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($subject) ?></option>
            <?php endforeach; ?>
        </select>
        
        <label>Insert Marks:</label>
        <input type="number" name="subjectmarks" min="0" max="60" required>
        
        <button type="submit" name="submit">Submit Marks</button>
    </form>

<?php
if (isset($_POST['submit'])) {
    $rollno = $_POST['rollno'];
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];
    $marks = $_POST['subjectmarks'];

    // Validate marks input (marks should not exceed 60)
    if ($marks < 0 || $marks > 60) {
        echo "Invalid marks. Marks should be between 0 and 60.";
    } else {
        // Prepared statement for checking if marks already exist
        $checkQuery = "SELECT * FROM marks WHERE rollno = ? AND subject = ?";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bind_param("ss", $rollno, $subject);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Marks for this subject have already been entered.";
        } else {
            // Prepared statement for inserting marks
            $insertQuery = "INSERT INTO marks (semester, subject, marks, rollno) VALUES (?, ?, ?, ?)";
            $insertStmt = $connection->prepare($insertQuery);
            $insertStmt->bind_param("isis", $semester, $subject, $marks, $rollno);

            if ($insertStmt->execute()) {
                echo "Marks inserted successfully.";
            } else {
                echo "Error inserting marks: " . $insertStmt->error;
            }
        }
    }
}
?>
</body>
</html>
