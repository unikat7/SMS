<?php
include'connection.php';
if(!$connection){
    die("failed");
}
else{
    if(isset($_POST['create'])){
        $name=$_POST['name'];
        $code=$_POST['code'];
       $hours=$_POST['hours'];
       $semester=$_POST['semester'];
       
        $sql="insert into course(name,code,hours,semester) values('$name','$code','$hours','$semester')";
        $sql_data=mysqli_query($connection,$sql);
        if($sql_data==1){
            echo"inserted";
        }
        else{
            echo"failed";
        }
    }
}
?>