<?php
include'connection.php';
if(!$connection){
    die("failed");
}
else{
    if(isset($_GET['email'])){
        $email=$_GET['email'];
        $delete="delete from teacher where email='$email'";
        if(mysqli_query($connection,$delete)){
            header("Location:teachertable.php");
        }
    }
}
?>