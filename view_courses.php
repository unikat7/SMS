<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        thead {
            background-color: #4CAF50;
            color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .update-btn, .delete-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .update-btn {
            background-color: #4CAF50;
        }
        .update-btn:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .delete-btn:hover {
            background-color: #e53935;
        }
        .update-form {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            width: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .update-form input {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .update-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>
  

<h2>Course Management</h2>
<table>
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Code</th>
            <th>Credit Hours</th>
            <th>Semester</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        include 'connection.php';
        $sql = "SELECT * FROM course";
        $data = mysqli_query($connection, $sql);
        if (mysqli_num_rows($data) > 0) {
            while ($row = mysqli_fetch_assoc($data)) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['code']}</td>
                        <td>{$row['hours']}</td>
                        <td>{$row['semester']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align: center;'>No courses found</td></tr>";
        }
        ?>
    </tbody>
</table>



</body>
</html>
