<?php
include 'connection.php';

if (!$connection) {
    die("Connection failed");
}

if (isset($_GET['code'])) {
    $code1 = $_GET['code'];
    // Fetch course details for the selected code
    $sql = "SELECT * FROM course WHERE code='$code1'";
    $result = mysqli_query($connection, $sql);
    $course = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="teacher.css" />
</head>
<body>
<section class="container">
    <header>Update Course</header>
    <form action="" class="form" method="post">
        <div class="input-box">
            <label for="name">Course Name</label>
            <input type="text" id="name" name="name" placeholder="Enter Course Name" value="<?= htmlspecialchars($course['name']) ?>" required />
        </div>
        <div class="input-box">
            <label for="code">Code</label>
            <input type="text" id="code" name="code" placeholder="Enter Course Code" value="<?= htmlspecialchars($course['code']) ?>" required />
        </div>
        <div class="input-box">
            <label for="hours">Credit Hours</label>
            <input type="number" id="hours" name="hours" placeholder="Enter Credit Hours" value="<?= htmlspecialchars($course['hours']) ?>" required />
        </div>
        <button type="submit" name="update">Update</button>
    </form>
</section>
</body>
</html>
<?php
include 'connection.php';

if (!$connection) {
    die("Connection failed");
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $code = $_POST['code']; // New code from the form
    $hours = $_POST['hours'];

    // Fetch the original code to find the correct record
    $originalCode = $_GET['code'];

    // Update the course details in the database
    $sql = "UPDATE course SET name='$name', code='$code', hours='$hours' WHERE code='$originalCode'";
    
    $sql_data = mysqli_query($connection, $sql);
    
    if ($sql_data) {
        header("Location:coursetable.php"); // Redirect after successful update
        exit; // Ensure no further code is executed after the redirect
    } else {
        echo "Update failed: " . mysqli_error($connection);
    }
}
?>
