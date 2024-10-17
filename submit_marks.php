<?php
include 'connection.php';
if (!$connection) {
    die("connection failed");
} else {
    if (isset($_POST['submit'])) {
        $Math = $_POST['Math'];
        $Science = $_POST['Science'];
        $English = $_POST['English'];
        $History = $_POST['History'];

        // Calculate the total marks as a percentage
        $totalMarks = (($Math + $Science + $English + $History) / 240) * 100;

        // Format the percentage with two decimal places
        $formattedTotalMarks = number_format($totalMarks, 2);

        // Output the percentage
        echo "The total marks in percentage are: " . $formattedTotalMarks . "%";
    }
}
?>
