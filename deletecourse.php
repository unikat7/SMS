<?php
include'connection.php';
if(!$connection){
    die("failed");
}
else{
    if(isset($_GET['code'])){
        $code=$_GET['code'];
        $delete="delete from course where code='$code'";
        if(mysqli_query($connection,$delete)){
            header("Location:coursetable.php");
        }
    }
}
?>