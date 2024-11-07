<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher Registration</title>
    <link rel="stylesheet" href="teacher.css" />
  </head>
  <body>
    <section class="container">
      <header>Teacher Registration</header>
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
        <button name="create">Create</button>
      </form>
    </section>

    <?php
    include 'connection.php'; 

    if (!$connection) {
      die("Connection failed");
    } else {
      if (isset($_POST['create'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        
        $check_teacher = "SELECT * FROM teacher WHERE email = '$email'";
        $result = mysqli_query($connection, $check_teacher);

        if (mysqli_num_rows($result) > 0) {
          
          echo "<p style='color: red; text-align: center;'>Teacher with email $email already exists!</p>";
        } else {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO teacher (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
          $sql_data = mysqli_query($connection, $sql);

          if ($sql_data == 1) {
            echo "<p style='color: green; text-align: center;'>Teacher registered successfully!</p>";
          } else {
            echo "<p style='color: red; text-align: center;'>Failed to insert teacher data</p>";
          }
        }
      }
    }
    ?>
  </body>
</html>
