<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xerox";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the file parameter is set
if (isset($_GET['file'])) {
    // Retrieve the filename from the query parameter
    $fileName = $_GET['file'];

    // SQL query to delete the file from the table
    $sql = "DELETE FROM allfiles WHERE fname = '$fileName'";

    if ($conn->query($sql) === TRUE) {
        // File deleted successfully
        echo "File deleted successfully.";
    } else {
        // Error deleting file
        echo "Error deleting file: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // File parameter is not set
    echo "File parameter is not set.";
}
?>
