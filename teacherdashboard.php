<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
     
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .dashboard {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        .dashboard a {
            text-decoration: none;
            padding: 15px 25px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>Teacher Dashboard</h1>
    <div class="dashboard">
        <a href="assign_marks.php">Assign Marks</a>
        <a href="view_students.php">View Students</a>
    </div>

</body>
</html>
