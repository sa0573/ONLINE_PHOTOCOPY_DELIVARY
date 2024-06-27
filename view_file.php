<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "xerox";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a mobile number is selected
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    // Fetch filename associated with the selected mobile number
    $sql = "SELECT files FROM xerox WHERE mobileno = '9550953767'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the filename
        $row = $result->fetch_assoc();
        $file_to_display = $row['files'];

        echo "File uploaded for mobile number 9550953767: " . $file_to_display;
    } else {
        echo "No file uploaded for mobile number 9550953767.";
    }
} else {
    echo "Please select a filename.";
}
?>
