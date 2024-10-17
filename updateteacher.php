<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
    <link rel="stylesheet" href="teacher.css"/>
  </head>
  <body>
    <section class="container">
      <header>Techer Registration</header>
      <form action="" class="form" method="POST">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" name="fullname" placeholder="Enter full name" required />
        </div>
        <div class="input-box">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="Enter email address" required />
        </div>
        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required />
          </div>
        <button name="update">Update</button>
      </form>
    </section>
  </body>
</html>

<?php
include'connection.php';
if(!$connection){
  die("failed");
}
else{
  if(isset($_POST['update'])){
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);
    $email1=$_GET['email'];
    $sql="update teacher set email='$email',fullname='$fullname',password='$hashed_password' where email='$email1'";
    $sql_data=mysqli_query($connection,$sql);
    if($sql_data==1){
        header("Location:teachertable.php");
    }
    else{
        echo"failed";
    }
}

  }

?>