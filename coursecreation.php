<?php

include 'connection.php';

if (isset($_POST['create'])) {
   
    $name = $_POST['name'];
    $code = $_POST['code'];
    $hours = $_POST['hours'];
    $semester = $_POST['semester'];

   
    $check_sql = "SELECT * FROM course WHERE code='$code'";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
       
        echo "<script>alert('Course with this code already exists!');</script>";
    } else {
        
        $insert_sql = "INSERT INTO course (name, code, hours, semester) VALUES ('$name', '$code', '$hours', '$semester')";
        
        if (mysqli_query($connection, $insert_sql)) {
            echo "<script>alert('Course created successfully!');</script>";
           
        } else {
            echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="teacher.css" />
    <title>Course Creation</title>
</head>
<body>
    <section class="container">
        <header>Course Creation</header>
        <form action="" class="form" method="post">
            <div class="input-box">
                <label for="name">Course Name</label>
                <input type="text" id="name" name="name" placeholder="Enter Course Name" required />
            </div>
            <div class="input-box">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" placeholder="Enter Course Code" required />
            </div>
            <div class="input-box">
                <label for="hours">Credit Hours</label>
                <input type="number" id="hours" name="hours" placeholder="Enter Credit Hours" required />
            </div>
            <div class="input-box">
                <label for="semester">Semester</label>
                <input type="number" id="semester" name="semester" placeholder="Enter Semester" required />
            </div>
            <button type="submit" name="create">Create</button>
        </form>
    </section>
</body>
</html>
