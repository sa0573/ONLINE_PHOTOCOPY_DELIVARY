<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            width: 300px;
        }

        .loading {
            display: none; /* Hide loading symbol by default */
        }

        form {
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
        }

        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .hide {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve mobile number and password from the form
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];

        // Database connection
        $servername = "localhost";
        $username = "root";
        $db_password = ""; // Rename the variable for database password
        $dbname = "xerox";

        $conn = new mysqli($servername, $username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert mobile number and password into the database
        $sql = "INSERT INTO xerox (mobileno, password) VALUES ('$mobile', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Display loading symbol and redirect after a delay
            echo '<h2>Creating Account...</h2>';
            echo '<div class="loading">Creating account...</div>'; // Loading symbol
            echo '<form action="details.php" method="POST" class="hide">'; // Add hide class
            echo '<input type="hidden" name="mobile" value="' . $mobile . '">';
            echo '<input type="hidden" name="password" value="' . $password . '">';
            echo '<div id="loading" class="loading">Creating account...</div>'; // Loading symbol
            echo '<script>';
            echo 'document.getElementById("loading").style.display = "block";'; // Show loading symbol
            echo 'setTimeout(function(){ document.forms[0].submit(); }, 3000);'; // Redirect after 3 seconds
            echo '</script>';
            echo '</form>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" <?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo 'class="hide"'; ?>>
        <h2>Create Password</h2>
        <?php
        // Display the entered mobile number
        if (isset($_GET['mobile'])) {
            $mobile = $_GET['mobile'];
            echo "<p>Mobile Number: $mobile</p>";
            echo '<input type="hidden" name="mobile" value="' . $mobile . '">';
        }
        ?>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
