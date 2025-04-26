<?php
// login_process.php
session_start(); // Start session to store user session data

include('db.php'); // Include the database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize inputs to prevent SQL Injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password (assuming passwords are hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Password is correct, store session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect to dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            // Incorrect password
            echo "Invalid password!";
        }
    } else {
        // User not found
        echo "No user found with that email!";
    }
}

$conn->close(); // Close database connection
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="" method="POST">
                <div class="textbox">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="textbox">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>



    <style> 

/* General body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Login container to center the box */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

/* Login box */
.login-box {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Heading */
.login-box h2 {
    margin-bottom: 20px;
    color: #333;
}

/* Input fields container */
.textbox {
    margin-bottom: 20px;
    text-align: left;
}

.textbox label {
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

.textbox input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    background-color: #f9f9f9;
    color: #333;
}

/* Button */
.btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

/* Link below the form */
.register-link {
    margin-top: 20px;
    font-size: 14px;
    color: #333;
}

.register-link a {
    color: #007bff;
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}

</style>

</body>
</html>
