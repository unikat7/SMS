<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Teacher to Course</title>
    <link rel="stylesheet" href="teacher.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
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
            <button type="submit">Assign</button>
            <a href="assigned_teachers.php">View Assigned Teachers</a>
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
