<?php
include 'connection.php';
if(!$connection){
    die("failed");
}
else{
    $sql="select * from teacher";
    $data=mysqli_query($connection,$sql);
    $row=mysqli_num_rows($data);
    if($row>0){
        while($result=mysqli_fetch_assoc($data)){
            echo"<tr>";
            echo"<td>".$result['fullname']."</td>";
            echo"<td>".$result['email']."</td>";
            echo "<td><a href='updateteacher.php?email=".$result['email']."'>Update</a></td>";
            echo "<td><a href='deleteteacher.php?email=".$result['email']."'>Delete</a></td>";
            echo"</tr>";
        }
    }
}
?>