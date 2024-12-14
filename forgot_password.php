<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="POST">
            <div class="form-group">
                <label for="email">Enter your registered email address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            include 'connection.php';  // Include your database connection file

            // Get the email input and sanitize it to prevent SQL injection
            $email = mysqli_real_escape_string($connection, $_POST['email']);

            // Select only the 'email' column from all tables (admin, teacher, student)
            $query = "SELECT email FROM admin WHERE email='$email' 
                      UNION 
                      SELECT email FROM teacher WHERE email='$email' 
                      UNION 
                      SELECT email FROM student WHERE email='$email'";

            // Execute the query to check if the email exists in any of the tables
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                // If email exists, generate a reset token
                $token = bin2hex(random_bytes(50));  // Generate a random token

                // Identify the table the email belongs to and update the reset token for that user
                // For simplicity, assuming we update for admin, but you can add logic to identify the table dynamically
                $update_query = "UPDATE admin SET reset_token='$token' WHERE email='$email'";

                // Execute the update query (for the admin table in this case)
                mysqli_query($connection, $update_query); 

                // Generate the reset password link
                $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
                $subject = "Password Reset Request";

                // Prepare the email body as HTML
                $message = "
                <html>
                <head>
                    <title>Password Reset Request</title>
                </head>
                <body>
                    <p>Hello,</p>
                    <p>Click the link below to reset your password:</p>
                    <a href='$reset_link'>$reset_link</a>
                    <p>If you did not request this, please ignore this email.</p>
                </body>
                </html>
                ";

                // Set the headers to send HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                $headers .= "From: no-reply@yourwebsite.com" . "\r\n"; // You can change this to your email

                // Send the reset link to the user's email in HTML format
                if(mail($email, $subject, $message, $headers)) {
                    echo "<p>A password reset link has been sent to your email address.</p>";
                } else {
                    echo "<p>Failed to send the reset link. Please try again later.</p>";
                }

            } else {
                echo "<p>No account found with this email address.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
