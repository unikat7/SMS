<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        thead {
            background-color: #007BFF;
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

        th {
            text-transform: uppercase;
        }

        td {
            color: #555;
        }

        a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .update-btn {
            background-color: #28a745;
            color: white;
        }

        .update-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .card {
            width: 60%;
            margin: 30px auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        .card-header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px auto;
            width: 80%;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
        }

    </style>
</head>
<body>
    <h2>Teacher Management</h2>

    
    <?php if (isset($_GET['delete_success'])): ?>
        <div class="alert-success">Teacher record deleted successfully!</div>
    <?php endif; ?>

   
    <?php if (isset($_GET['update_success'])): ?>
        <div class="alert-success">Teacher record updated successfully!</div>
    <?php endif; ?>

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

            
            if (isset($_GET['delete'])) {
                $emailToDelete = $_GET['delete'];
                $deleteQuery = "DELETE FROM teacher WHERE email = '$emailToDelete'";
                mysqli_query($connection, $deleteQuery);
                header("Location: ".$_SERVER['PHP_SELF']."?delete_success=true");
                exit;
            }

           
            if (isset($_POST['update'])) {
                $oldEmail = $_POST['old_email'];
                $fullname = $_POST['fullname'];
                $newEmail = $_POST['email'];

                $updateQuery = "UPDATE teacher SET fullname='$fullname', email='$newEmail' WHERE email='$oldEmail'";

                if(mysqli_query($connection, $updateQuery)){
                    
                    header("Location: ".$_SERVER['PHP_SELF']."?update_success=true");
                    exit;
                } else {
                  
                    echo "Error updating record: " . mysqli_error($connection);
                }
            }

       
            $sql = "SELECT * FROM teacher";
            $data = mysqli_query($connection, $sql);
            $row = mysqli_num_rows($data);

            if ($row > 0) {
                while ($result = mysqli_fetch_assoc($data)) {
                    echo "<tr>";
                    echo "<td>" . $result['fullname'] . "</td>";
                    echo "<td>" . $result['email'] . "</td>";
                    echo "<td>
                        <a href='?delete=" . $result['email'] . "' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                        <a href='?update_form=" . $result['email'] . "' class='update-btn'>Update</a>
                    </td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <?php if (isset($_GET['update_form'])): 
        $emailToUpdate = $_GET['update_form'];
        $query = "SELECT * FROM teacher WHERE email='$emailToUpdate'";
        $result = mysqli_query($connection, $query);
        $teacherData = mysqli_fetch_assoc($result);
    ?>
    <div class="card">
        <div class="card-header">Update Teacher Information</div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="old_email" value="<?php echo $teacherData['email']; ?>">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo $teacherData['fullname']; ?>" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $teacherData['email']; ?>" required>
                </div>
                <button type="submit" name="update" class="btn-success">Update</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
