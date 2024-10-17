<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <thead>
            <th>Full Name</th>
            <th>Email</th>
            <th>Semester</th>
            <th>Session</th>
            <th>Rollno</th>
            <th>Remarks</th>
        </thead>
        <tbody>
            <?php
            include'connection.php';
            if(!$connection){
                die("connection failed");
            }
            else{
                $sql="select * from studentreg";
                $data=mysqli_query($connection,$sql);
                $row=mysqli_num_rows($data);
                if($row>0){
                    while($result=mysqli_fetch_assoc($data)){
                        echo"<tr>";
                        echo"<td>".$result['fullname']."</td>";
                        echo"<td>".$result['email']."</td>";
                        echo"<td>".$result['semester']."</td>";
                        echo"<td>".$result['sess']."</td>";
                        echo"<td>".$result['rollno']."</td>";
                        echo "<td>
                        <a href='updatestudentreg.php?rollno=".$result['rollno']."'>Update</a> 
                        <a href='deletestudentreg.php?rollno=".$result['rollno']."'>Delete</a>
                      <a href='assignmarks.php?rollno=".$result['rollno']."&semester=".$result['semester']."&fullname=".$result['fullname']."'>Assign Marks</a>
                      </td>";
                echo "</tr>";
                
    
            }
        }
    }
        
            ?>
     
    </table>