<?php
// Establish connection to your database
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "xerox"; // Your MySQL database name

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve form data
    $enteredName = $_POST['name']; // Changed to get the entered name
    $option = $_POST['option'];
    $mobile = $_POST['mobile']; // Assuming you're passing the mobile number from the previous page
    $password = $_POST['password']; // Assuming you're passing the password from the previous page

    // Check if a file is uploaded
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // Extract file details
        $fileName = $file['name']; // Get the filename
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // Check for any upload errors
        if ($fileError === 0) {
            // Read the contents of the uploaded file
            $fileContent = file_get_contents($fileTmpName);

            // Prepare and execute the SQL query to insert the file into the database
            $stmt = $pdo->prepare("INSERT INTO allfiles (fname, pdf_data, allign, mobileno) VALUES (:fileName, :fileContent, :selectedOption, :mobile)");
            $stmt->bindParam(':fileName', $fileName, PDO::PARAM_STR); // Bind the filename
            $stmt->bindParam(':fileContent', $fileContent, PDO::PARAM_LOB);
            $stmt->bindParam(':selectedOption', $option, PDO::PARAM_STR);
            $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect to the details.php page with mobile number and password as GET parameters
            header("Location: details.php?mobile=$mobile&password=$password");
            exit();
        } else {
            // Send an error response if there's an upload error
            echo "Error uploading file: " . $fileError;
        }
    } else {
        // Send an error response if no file is uploaded
        echo "No file uploaded.";
    }
} catch(PDOException $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
}
?>
