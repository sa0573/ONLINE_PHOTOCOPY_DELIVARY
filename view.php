<!DOCTYPE html>
<html>
<head>
    <title>View PDFs</title>
</head>
<body>
    <h2>Uploaded PDF Files</h2>
    <?php
    // Establish connection to your database
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $dbname = "xerox1"; // Your MySQL database name

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve PDF files from the database
        $stmt = $pdo->prepare("SELECT name, fname FROM xerox1");
        $stmt->execute();
        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display each PDF file with a download link
        foreach ($files as $file) {
            echo '<a href="download.php?fname=' . urlencode($file['fname']) . '">' . $file['name'] . '</a><br>';
        }
    } catch(PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
    ?>
</body>
</html>
