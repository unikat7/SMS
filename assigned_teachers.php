<?php
include 'connection.php'; // Include your database connection

// Handle form submission for deleting
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $delete_email = $_POST['teacher_email'];
    $delete_course_code = $_POST['course_code'];

    // Delete from course_teacher table
    $delete_query = "DELETE FROM course_teacher WHERE teacher_email = '$delete_email' AND course_code = '$delete_course_code'";
    
    if (mysqli_query($connection, $delete_query)) {
        echo "<p style='color: green;'>Assigned teacher deleted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

// Fetch assigned teachers and courses
$assigned_query = "SELECT ct.teacher_email, ct.course_code, c.name AS course_name 
                   FROM course_teacher ct 
                   JOIN course c ON ct.course_code = c.code";
$assigned_result = mysqli_query($connection, $assigned_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Teachers</title>
    <link rel="stylesheet" href="teacher.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Assigned Teachers and Courses</h2>
        <table>
            <thead>
                <tr>
                    <th>Teacher Email</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($assigned_result) > 0) {
                    while ($row = mysqli_fetch_assoc($assigned_result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars(trim($row['teacher_email'])) . "</td>";
                        echo "<td>" . htmlspecialchars(trim($row['course_code'])) . "</td>";
                        echo "<td>" . htmlspecialchars(trim($row['course_name'])) . "</td>";
                        echo "<td>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='teacher_email' value='" . htmlspecialchars(trim($row['teacher_email'])) . "'>";
                        echo "<input type='hidden' name='course_code' value='" . htmlspecialchars(trim($row['course_code'])) . "'>";
                        echo "<button type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this assignment?\")'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No assigned teachers found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
