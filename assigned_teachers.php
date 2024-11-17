<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Teachers</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
        }
        .content{
            flex: 1;
            padding: 20px;
            background-color: #f3f4f6;
            margin-left: 250px;
        }
        .admin-title {
            color: #334e68;
            font-size: 26px;
            font-weight: bold;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header {
            font-size: 24px;
            font-weight: bold;
            color: #4A90E2;
            text-align: center;
            margin-bottom: 20px;
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box label {
            font-weight: bold;
            color: #334e68;
        }
        .input-box input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }
        button {
            background-color: #4A90E2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #357abD;
        }
        p {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Assigned Teachers</h2>
        <table>
            <thead>
                <tr>
                    <th>Teacher Email</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'connection.php'; 

                $query = "SELECT course_teacher.teacher_email, course.code, course.name 
                          FROM course_teacher 
                          JOIN course ON course_teacher.course_code = course.code";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                   
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['teacher_email']) . "</td>
                                <td>" . htmlspecialchars($row['code']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No teachers assigned to any course.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="assignteacher.php">Back to Assign Teacher</a>
    </div>
</body>
</html>
