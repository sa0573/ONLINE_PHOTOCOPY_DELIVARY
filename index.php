<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Number Verification</title>
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

        .loading {
            display: none; /* Hide loading initially */
        }

        input[type="tel"],
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

<div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mobile = $_POST['mobile'];

        // Check if mobile number is exactly 10 digits
        if (strlen($mobile) == 10 && is_numeric($mobile)) {
            echo "<h2>Mobile Number Entered: $mobile</h2>";

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "xerox";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM xerox WHERE mobileno = '$mobile'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mobile number exists
                $row = $result->fetch_assoc();
                $correctPassword = $row['password'];

                // Check if the password is submitted
                if (isset($_POST['password'])) {
                    $enteredPassword = $_POST['password'];
                    if ($enteredPassword == $correctPassword) {
                        // Password is correct, display loading message and redirect after 5 seconds
                        echo '<div class="loading"><h2>Loading...</h2></div>';
                        echo '<form id="verificationForm" action="details.php" method="POST">';
                        echo '<input type="hidden" name="mobile" value="' . $mobile . '">';
                        echo '<input type="hidden" name="password" value="' . $correctPassword . '">';
                        echo '</form>';
                        // JavaScript code to show loading message and submit form after 5 seconds
                        echo '<script>';
                        echo 'document.querySelector(".loading").style.display = "block";';
                        echo 'setTimeout(function(){ document.getElementById("verificationForm").submit(); }, 5000);';
                        echo '</script>';
                    } else {
                        // Password is incorrect
                        echo "<h2>Invalid password</h2>";
                    }
                } else {
                    // Password is not submitted, display password prompt
                    echo '<h2>Enter Password</h2>';
                    echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST">';
                    echo '<input type="hidden" name="mobile" value="' . $mobile . '">';
                    echo 'Password: <input type="password" name="password" required><br><br>';
                    echo '<input type="submit" value="Submit">';
                    echo '</form>';
                }
            } else {
                // New mobile number, redirect to add.php
                header("Location: add.php?mobile=$mobile");
                exit(); // Make sure to exit after redirection
            }

            $conn->close();
        } else {
            echo "<h2>Please enter a valid 10-digit mobile number.</h2>";
        }
    } else {
        ?>
        <h2>Enter Mobile Number</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="mobile">Mobile Number:</label><br>
            <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" required><br><br>
            <input type="submit" value="Submit">
        </form>
        <?php
    }
    ?>
</div>

<script>
    document.getElementById("mobile").addEventListener("input", function() {
        let mobileInput = this.value.replace(/\D/g, '');
        if (mobileInput.length > 10) {
            mobileInput = mobileInput.slice(0, 10);
        }
        this.value = mobileInput;
    });
</script>

</body>
</html>
