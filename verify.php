<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xerox";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching input data
$mobile = $_POST['mobile'];

// Checking if mobile number exists in the database
$sql = "SELECT * FROM xerox WHERE mobileno = '$mobile'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mobile number exists, prompt for password
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enter Password</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            form {
                width: 300px;
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
        </style>
    </head>
    <body>
        <h2>Enter Password</h2>
        <form action="details.php" method="POST">
            <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" value="Submit">
        </form>
    </body>
    </html>
    <?php
} else {
    // New mobile number, prompt to create password
    ?>
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

            form {
                width: 300px;
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
        </style>
    </head>
    <body>
        <h2>Create Password</h2>
        <form action="add.php" method="POST">
            <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
            Mobile Number: <?php echo $mobile; ?><br>
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" value="Submit">
        </form>
    </body>
    </html>
    <?php
}

$conn->close();
?>
