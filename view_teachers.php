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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        
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
      
    </div>
</body>
</html>
