<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
    <link rel="stylesheet" href="studentenrollment.css" />
  </head>
  <body>
    <section class="container">
      <header>Registration Form</header>
      <form action="" class="form" method="post">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter full name" required name="fullname"/>
        </div>

        <div class="input-box">
          <label>Email Address</label>
          <input type="email" placeholder="Enter email address" required name="email"/>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Semester</label>
            <input type="number" placeholder="Enter Semester" required name="semester"/>
          </div>
          
        <div class="column">
            <div class="input-box">
              <label>Session</label>
              <input type="date" placeholder="Enter Session" required name="ses"/>
            </div>
            <div class="column">
                <div class="input-box">
                  <label>Rollno</label>
                  <input type="number" placeholder="Enter phone number" required name="rollno" />
                </div>
        
        <button name="submit">Submit</button>
      </form>
    </section>
  </body>
</html>
<?php
include'connection.php';
if(!$connection){
  die("connection failed");
}
else{
  if(isset($_POST['submit'])){
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $semester=$_POST['semester'];
    $ses=$_POST['ses'];
    $rollno=$_POST['rollno'];
    $insert="insert into studentreg(fullname,email,semester,sess,rollno)values('$fullname','$email',$semester,'$ses',$rollno)";
    $studentdata=mysqli_query($connection,$insert);
    if($studentdata==1){
      echo"inserted";
    }
    else{
      echo"no";
    }
    
  }
}
?>