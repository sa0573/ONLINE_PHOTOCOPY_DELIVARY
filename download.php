<?php
// Establish connection to your database
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "xerox1"; // Your MySQL database name

// Check if a file name is provided
if (isset($_GET['fname'])) {
    // Retrieve file name from the URL parameter
    $fname = $_GET['fname'];

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve file content from the database
        $stmt = $pdo->prepare("SELECT pdf_data FROM xerox1 WHERE fname = :fname");
        $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
        $stmt->execute();
        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set headers for file download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $fname . '"');
        header('Content-Length: ' . strlen($file['pdf_data'])); // Set Content-Length
        header('Cache-Control: private'); // Prevent caching
        header('Pragma: private');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        echo $file['pdf_data'];
        exit(); // Ensure no further output is sent
    } catch(PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
} else {
    // Send an error response if file name is not provided
    echo "File not found.";
}
?>
