<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link rel="stylesheet" href="navbar.css" />
  </head>
  <body>
    <?php
    // include 'navbar.php';
    ?>
    <section class="container">
      <header>Create Student Login</header>
      <form action="" class="form" method="post">
        <div class="input-box">
          <label>Student Name</label>
          <select name="fullname" required>
            <option value="">Select Student</option>
            <?php
              include 'connection.php';
             
              $query = "SELECT fullname FROM studentreg";
              $result = mysqli_query($connection, $query);
             
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['fullname']."'>".$row['fullname']."</option>";
              }
            ?>
          </select>
        </div>

        <div class="input-box">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="Enter email address" required />
        </div>

        <div class="input-box">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter password" required />
        </div>

        <button name="create">Create Account</button>
      </form>
    </section>
  </body>
</html>
<?php
include 'connection.php'; 

if (isset($_POST['create'])) {
 
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 


  $check_student = "SELECT * FROM studentreg WHERE fullname = '$fullname'";
  $result_student = mysqli_query($connection, $check_student);

  if (mysqli_num_rows($result_student) > 0) {
   
    $check_login = "SELECT * FROM student WHERE fullname = '$fullname' OR email = '$email'";
    $result_login = mysqli_query($connection, $check_login);

    if (mysqli_num_rows($result_login) > 0) {
      
      echo "<p style='color: red; text-align: center;'>Account already exists for $fullname!</p>";
    } else {
     
      $insert_login = "INSERT INTO student (fullname, email, password) VALUES ('$fullname', '$email', '$password')";

      if (mysqli_query($connection, $insert_login)) {
        echo "<p style='color: green; text-align: center;'>Login created successfully for $fullname!</p>";
      } else {
        echo "<p style='color: red; text-align: center;'>Error: " . mysqli_error($connection) . "</p>";
      }
    }
  } else {
    echo "<p style='color: red; text-align: center;'>Student not found. Please make sure the student is enrolled.</p>";
  }
}
?>
