<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Number Details</title>
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
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .details {
            width: 30%;
            padding: 10px;
            border-right: 1px solid #ccc;
        }

        .profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .file-list {
            width: 60%;
            padding: 10px;
            border-right: 1px solid #ccc;
            overflow-y: auto;
        }

        .upload-form {
            width: 30%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: auto; /* Center align the form */
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .logout button:hover {
            background-color: #d32f2f;
        }

        .upload-form input[type="text"],
        .upload-form select,
        .upload-form input[type="file"],
        .upload-form input[type="submit"] {
            width: calc(100% - 22px);
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .upload-form input[type="file"] {
            border: 1px solid #ccc;
        }

        .upload-form input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .upload-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .file-item .delete-btn {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .file-item .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="details">
        <?php
        // Retrieve mobile number and other details from the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "xerox";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM xerox WHERE mobileno = '$mobile' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <div class="profile">
                <h2>Profile</h2>
                <img src="profile.png" alt="Profile Image">
                <p>Mobile Number: <?php echo $row["mobileno"]; ?></p>
                <!-- Add more profile details here -->
            </div>

            <div class="logout">
                <button onclick="logout()">Logout</button>
            </div>
            <?php
        } else {
            echo "Invalid mobile number or password!";
        }
        ?>
    </div>

    <div class="file-list">
    <h2>File List</h2>
    <?php
    // Fetch file list from the database
    $sql_files = "SELECT * FROM allfiles WHERE mobileno = '$mobile'";
    $result_files = $conn->query($sql_files);

    if ($result_files->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Filename</th><th>Status</th><th>Alignment</th><th>Action</th></tr>";
        // Output each file as a table row with download link
        while ($file_row = $result_files->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='download.php?filename=" . urlencode($file_row['fname']) . "'>" . $file_row["fname"] . "</a></td>";
            echo "<td>" . $file_row["status"] . "</td>";
            echo "<td>" . $file_row["allign"] . "</td>";
            echo "<td><button class='delete-btn' onclick='deleteFile(\"" . $file_row['fname'] . "\")'>Delete</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No files found.";
    }
    ?>
</div>

<form action="upload_process.php" method="post" enctype="multipart/form-data" class="upload-form">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="file">Select File:</label>
    <input type="file" id="file" name="file" required><br><br>

    <label for="option">Select Option:</label>
    <select id="option" name="option" required>
        <option value="Option 1">Option 1</option>
        <option value="Option 2">Option 2</option>
        <option value="Option 3">Option 3</option>
    </select><br><br>

    <!-- Hidden input field to pass mobile number -->
    <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
    <!-- Hidden input field to pass the entered file name -->
    <input type="hidden" name="entered_name" id="entered_name">
    <!-- Hidden input field to pass password -->
    <input type="hidden" name="password" value="<?php echo $password; ?>">

    <input type="submit" value="Upload">
</form>
</div>

</div>
<div id="loading-overlay" style="display: none;">
    <div id="loading-spinner"></div>
</div>

<script>
    function logout() {
        // Redirect to logout page or perform logout actions here
        alert("Logout successful!");
        window.location.href = "index.php";
    }

    function deleteFile(fileName) {
        if (confirm("Are you sure you want to delete this file?")) {
            // Perform AJAX request to delete the file
            // For demonstration purposes, let's redirect to a PHP script that handles the deletion
            window.location.href = "delete_file.php?file=" + fileName;
        }
    }
</script>

</body>
</html>
