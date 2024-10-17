<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table with Update and Delete Actions</title>
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
        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
        }
        td {
            background-color: #fff;
            color: #333;
        }
        a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-transform: uppercase;
        }
        .update-btn {
            background-color: #4CAF50;
            color: white;
        }
        .update-btn:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .delete-btn:hover {
            background-color: #e53935;
        }
        .remarks {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Code</th>
                <th>Credit Hours</th>
                <th>Semester</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include'connection.php';
            if(!$connection){
                die("failed");
            }
            else{
                $sql="select * from course";
    $data=mysqli_query($connection,$sql);
    $row=mysqli_num_rows($data);
    if($row>0){
        while($result=mysqli_fetch_assoc($data)){
            echo"<tr>";
            echo"<td>".$result['name']."</td>";
            echo"<td>".$result['code']."</td>";
            echo"<td>".$result['hours']."</td>";
            echo"<td>".$result['semester']."</td>";
            echo "<td>
            <a href='updatecourse.php?code=".$result['code']."'>Update</a> 
            <a href='deletecourse.php?code=".$result['code']."'>Delete</a>
          </td>";
            echo"</tr>";
        }
    }
}
            
            ?>
        </tbody>
    </table>
</body>
</html>
