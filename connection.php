<?php
$hostname="localhost";
$username="root";
$password="unika#123";
$dbname="project";
$connection=mysqli_connect($hostname,$username,$password,$dbname);
if(!($connection)){
      echo"connection failed";
}
// else{
//     echo"successful";
// }
?>