<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Student Enrollment</title>
    <link rel="stylesheet" href="studentenrollment.css" />
  </head>
  <body>
    <section class="container">
      <header>Student Enrollment Form</header>
      
    
      <form action="" class="form" method="post">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter full name" required name="fullname" />
        </div>

        <div class="input-box">
          <label>Email Address</label>
          <input type="email" placeholder="Enter email address" required name="email" />
        </div>

        <div class="input-box">
          <label>Semester</label>
          <input type="number" placeholder="Enter Semester" required name="semester" />
        </div>

        <div class="input-box">
          <label>Enrollment Year</label>
          <input type="number" placeholder="Enter Year" required name="year" />
        </div>

        <div class="input-box">
          <label>Roll Number</label>
          <input type="number" placeholder="Enter Roll Number" required name="rollno" />
        </div>

        <button class="submit-btn" name="submit">Submit</button>
      </form>

    
      <?php
        include 'connection.php'; 

        
        if (isset($_POST['submit'])) {
       
          $fullname = $_POST['fullname'];
          $email = $_POST['email'];
          $semester = $_POST['semester'];
          $year = $_POST['year'];
          $rollno = $_POST['rollno'];

       
          $insert_query = "INSERT INTO studentreg (fullname, email, semester, enrollment_year, rollno) 
                          VALUES ('$fullname', '$email', $semester, '$year', $rollno)";

        
          $result = mysqli_query($connection, $insert_query);

        
          if ($result) {
            echo "<p style='color: green; text-align: center;'>Student data inserted successfully!</p>";
          } else {
            echo "<p style='color: red; text-align: center;'>Error inserting data: " . mysqli_error($connection) . "</p>";
          }
        }
      ?>
    </section>
  </body>
</html>
