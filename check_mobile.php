<?php
// Establish connection to your database
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "xerox"; // Your MySQL database name

// Check if mobile number is provided
if (isset($_POST['mobileNumber'])) {
    $mobileNumber = $_POST['mobileNumber'];

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the mobile number exists in the database
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM xerox WHERE mobileno = :mobileNumber");
        $stmt->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            echo "exists";
        } else {
            echo "not_exists";
        }
    } catch(PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
} else {
    // Send an error response if mobile number is not provided
    echo "Mobile number is required.";
}
?>
