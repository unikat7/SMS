<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        thead {
            background-color: #4CAF50;
            color: white;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .update-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <input type="text" name="sname" placeholder="Enter teacher name">
        <button type="submit" name="search">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'connection.php';

            if (!$connection) {
                die("Connection failed");
            }

            if (isset($_POST['search'])) {
                $name = $_POST['sname'];
                $sql = "SELECT * FROM teacher WHERE fullname LIKE '$name%'";
            } else {
                $sql = "SELECT * FROM teacher";
            }

            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" .$row['fullname'] . "</td>";
                    echo "<td>" .$row['email'] . "</td>";
                    echo "<td><a href='updateteacher.php?email=".$row['email']."' class='update-btn'>Update</a> ";
                    echo "<a href='deleteteacher.php?email=".$row['email']."' class='delete-btn'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
               echo "<tr><td colspan='3'>No teacher found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
